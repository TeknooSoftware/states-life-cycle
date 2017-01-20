States Life Cyclable - Quick startup
====================================

Install dependencies
--------------------

*Warning, PHP7+ is required*

    composer require teknoo/states
    composer require teknoo/states-life-cycle

Prepare bootstrap file
----------------------

In your bootstrap file of your application, you must initialize the State library and this extension.

*If your application is built on Symfony 2+ a special bundle is already available on
Github : ([statesBundle](https://github.com/TeknooSoftware/statesBundle), you can skip to next step.*


    /**
     * Initialize the states library following the states's documentations
     * @var LoaderInterface $stateLoader
     */
    $stateLoader = require_once ROOT_PATH.'/vendor/teknoo/states/src/bootstrap.php';
    //Repeat this operation for each PSR4 Namewpsace
    $stateLoader->registerNamespace('Namespace\\of\\your\\stated\\classes', ROOT_PATH.'path/to/your/statedclass');

    //Use the helper generator to get needed instance of observer and event dispatcher, it's not a mandatory tool
    $generator = new Generator();
    $eventDistpatcher = $generator->getEventDispatcher();

By default, the `Generator` build an instance of `Symfony EventDispatcher`, but you can define your proper dispatcher
following the interface `EventDispatcherInterface` with the method `setEventDispatcher` of the generator.

Implement an Automated stated class
-----------------------------------

Instances of an automated stated class can change automaticaly theirs states according to theirs attributes.
Availables states are described by some assertions, implementing the interface `AssertionInterface`. They are checked
by the system at each call of the stated class's method `updateStates()`.

An automated stated class must implement the interface `AutomatedInterface`. An implementation is provided by this library
by the trait `AutomatedTrait`.

Assertions must be returned the method `getStatesAssertions()` of your stated class, as an array of `AssertionInterface` instances.

Some implementations are also provided by this extension :

    * `Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Asertion` to perform assertions on attribute
    * `Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Callback` to perform assertion on a callback

**Warning : A state is enable is at least one assertion associate with it is valid.**

An automated stated class need no others components to work. We can see the demo 2 to observe this mechanism.

Assertions on properties
------------------------

**Without callable** : You define the value required by this assertion to be valid, the assertion performs a classic
equal test (use the php operator `==`).

    /**
     * {@inheritdoc}
     */
     public function getStatesAssertions(): array
     {
        return [
         /* ... */
         (new Assertion(['StateName1']))->with('myPropertyName', 'requiredValueToBeValid'),
         (new Assertion(['StateName2']))->with('myPropertyName2', 'requiredValueToBeValid')
         /* ... */
        ];
     }

**With a callable** : You pass a callable instead of the required valud to perform the test by the assertion.
Some callable are provided by the extension in the namespace `Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Property`;

    use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Property as AssertionProperty;

    /** .. */

    /**
     * {@inheritdoc}
     */
     public function getStatesAssertions(): array
     {
        return [
         /* ... */
         (new Assertion(['StateName1']))->with('myPropertyName', 'is_numeric'),
         (new Assertion(['StateName2']))->with('myPropertyName2', [$this, 'myMethod']),
         (new Assertion(['StateName1']))->with('myPropertyName', new AssertionProperty\IsInstanceOf('\DateTime')),
         /* ... */
        ];
     }

Assertions with callable
------------------------

    /**
     * {@inheritdoc}
     */
     public function getStatesAssertions(): array
     {
        return [
         /* ... */
         (new Callback(['StateName1','StateName2]))->call([$this, 'myMethod']),
         /* ... */
        ];
     }


Implement a Lifecycable stated class
------------------------------------

A lifecycable stated class instance is an instance able to trace its states changes (incoming/outgoing states) and
broadcast this information to another componinents in yours applications. This behavior is built on the Observer pattern.
A lifecycable stated class must implement the interface `LifeCyclableInterface`.
An implementation is provided by this extension with the trait `LifeCyclableTrait`.

To be able to trace its states activity, an instance must be linked to an observer. The observer must implement the interface
`ObserverInterface`. A default implementation is provided with this library by `Observer`.

The link between a stated class instance and its observer is represented and managed by an `ObservedInterface` instance.
A default implementation of this interface is provided by `Observed`. Instances of `Observed` are built by the factory
on demand of the observer.

An observer instance can be retrieved with the Generator provided by this library.

    $observer = $generator->getObserver();
    $observer->attachObject($lifeCyclableStatedInstance);

    $lifeCyclableStatedInstance->notifyObserved();

States activity is fetched and broadcasted when the method `notifyObserved` of the stated class instance is called.

We can see the demo 1 to observe this mechanism.

Implement an Automated and Lifecyclable stated class
----------------------------------------------------

To implement an automated and lifecyclable stated classn you must implements to interfaces described in previous steps.
A trait is provided by this extention to implement these interfaces : `AutomatedLifeCyclableTrait`

When the method `updateStates` of your stated class instances is called, new states are computed like an automated class
and changes are broadcasted to observers like a lifecyclable class.

Observe a life cyclable stated class
------------------------------------

When an observer observing changes about a stated class instance, it send several events via the EventDispatcher.
These event are broadcasted even if no changes are observed. It broadcast four types of events :

Event's name are generated by a tokenizer implementing the interface `Teknoo\States\LifeCycle\Tokenization\TokenizerInterface`.

*   a global event about a stated class : <base token>.
*   one event by enabled state : <base token>:<state name>.
*   one event by incoming state : <base token>:+<state name>.
*   one event by outgoing state : <base token>:-<state name>.

*<basename> corresponding to lowerized canonical stated class name, namespace separator are converted to underscore.*

Event broadcasted by the observer implements the interface `Teknoo\States\LifeCycle\Event\EventInterface`.

See demos to learn  more.

Trace change of a lifecyclable stated class
-------------------------------------------

A lifecyclable stated class provides an api to browse in its states activity trace. This interface is available via
the observed instance with the method `getStateTrace())`

It will be return a `Teknoo\States\LifeCycle\Trace\TraceInterface`.

Perform scenarii with several stated classes
--------------------------------------------

The extension provides also an api to create scenarii to describe interaction between stated class instances and others
components. Scenarii can be written with `ScenarioBuilder` or `ScenarioYamlBuilder`.

A scenario can be attached to all instances of a stated class or to a specific stated class instance,
and its execution can be condition states enabled or not (including incoming and outgoing states).
The scenario contains also a callable to execute when all conditions are valid.

All scenarii must be registered into a manager, linked with the event dispatcher. By default, the generator performs this
by calling

    $generator = new Generator();
    $manager = $generator->getManager();

You have two ways to create a scenario :

With the `\Teknoo\States\LifeCycle\Scenario\ScenarioBuilder` class, to create scenarii in PHP. See the demo 4 for more informations
With the `\Teknoo\States\LifeCycle\Scenario\ScenarioYamlBuilder` class to create scenarii in YAML
(See the demo file and the folder scenarii in demo) : Callable can use parameter, prefixed by '$' to define object to use.

See demos 4 and 5 to learn  more.
