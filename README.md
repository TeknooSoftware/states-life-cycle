Teknoo Software - States Life Cyclable extension
================================================

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/cee11d43-81b1-4974-a388-880a532a2c4f/mini.png)](https://insight.sensiolabs.com/projects/cee11d43-81b1-4974-a388-880a532a2c4f) [![Build Status](https://travis-ci.org/TeknooSoftware/states-life-cycle.svg?branch=master)](https://travis-ci.org/TeknooSoftware/states-life-cycle)

This extention provides some new behavior to your stated class :
- Automated stated class : to switch automatically to states defined by validation rules defined in class by assertions
- Lifecycable stated class : to dispatch states updates from a stated class to observer
- Traceable stated class : to keep evolution of states in the lifecycle of your stated class
- Scenario : to create easily scenarii in php or yaml between stated class instances and others application's components

Shorts Examples
---------------

    /**
     * File Person/States/English.php
     */
    class English extends \Teknoo\States\State\AbstractState 
    {
        // ...
    }
    
    /**
     * File Person/States/French.php
     */
    class French extends \Teknoo\States\State\AbstractState 
    {
        // ...
    }
    
    /**
     * File Person.php
     */
    class Person extends \Teknoo\States\Proxy\Standard implements AutomatedInterface, LifeCyclableInterface
    {
        private $nationality;
        
        public function setNationality(string $nationality): Person 
        {
            $this->nationality = $nationality;
            
            //To update states of this instance according to its assertions and
            //dispatch states change to observer
            $this->updateStates();
            
            return $this;
        }
    
        public function setTravel(Travel $travel): Person
        {
            // ...
        }
        
        public function getTravel(): Travel
        {
            // ...
        }


        /**
         * @return AssertionInterface[]
         */
        public function getStatesAssertions(): array
        {
            return [
                (new Assertion([French::class]))->with('nationality', new IsEqual('Fr')),
                (new Assertion([English::class]))->with('nationality', new IsNotEqual('Fr'))
            ];
        }
    }

    /**
     * File Travel/States/Schengen.php
     */
    class Schengen extends \Teknoo\States\State\AbstractState 
    {
        // ...
    }
    
    /**
     * File Travel/States/Uk.php
     */
    class Uk extends \Teknoo\States\State\AbstractState 
    {
        // ...
    }
    
    /**
     * File Travel.php
     */
    class Travel extends \Teknoo\States\Proxy\Standard 
    {
        // ..
    }
    
    //Scenario
    //Use the helper generator to get needed instance of observer and event dispatcher, it's not a mandatory tool
    $di = include 'src/generator.php';

    //Scenario to enable Schengen state to travel of French man
    $di->get(ManagerInterface::class)
        ->registerScenario(
            (new ScenarioBuilder($di->get(TokenizerInterface::class)))
            ->towardStatedClass('demo\Person')
            ->onIncomingState('French')
            ->run(function (EventInterface $event) {
                $person = $event->getObserved();
                $person->getTravel()->switchState('Schengen');
            })
            ->build(new Scenario())
    );
    
    //Scenario to enable UK state to travel of English man
    $di->get(ManagerInterface::class)
        ->registerScenario(
            (new ScenarioBuilder($di->get(TokenizerInterface::class)))
            ->towardStatedClass('demo\Person')
            ->onIncomingState('English')
            ->run(function (EventInterface $event) {
                $person = $event->getObserved();
                $person->getTravel()->switchState('UK');
            })
            ->build(new Scenario())
    );
    
    
    //Demo
    $frenchMan = new Person();
    $travel1 = new Travel();
    $frenchMan->setTravel($travel1);
    
    print_r($travel1->listEnabledStates()); //Print []
    $frenchMan->setNationality('Fr');
    print_r($travel1->listEnabledStates()); //Print ['Schengen"]
    
    $englishMan = new Person();
    $travel2 = new Travel();
    $frenchMan->setTravel($travel2);
    
    print_r($travel2->listEnabledStates()); //Print []
    $englishMan->setNationality('En');
    print_r($travel2->listEnabledStates()); //Print ['UK"]
    $englishMan->setNationality('Fr');
    print_r($travel2->listEnabledStates()); //Print ['Schengen"]
    
    

Full Example
------------
Examples of using this library is available in the folder demo.

Installation & Requirements
---------------------------
To install this library with composer, run this command :

    composer require teknoo/states-life-cycle
    
You must install a event dispatcher, like symfony/event-dispatcher.

    composer require symfony/event-dispatcher
    
The library provide a native support of `Symfony Event Dispatcher`. If you use another
event dispatcher, you must write you own `EventDispatcherBridgeInterface`.

Next, you must configure the generator, with the event dispatcher bridge defined in `demo/EventDispatcherBridge.php` :
    
    $di = include 'src/generator.php';

A PHP-DI configuration is available into `src/di.php`. You can use PHP-DI
with Symfony with [PHP-DI Symfony Bridge](http://php-di.org/doc/frameworks/symfony2.html).

This library requires :

    * PHP 7+
    * Teknoo Software States 3.1+
    * PHP-DI
    * Symfony event dispatcher (not required)
    * Symfony yaml to parse yaml scenarii (not required)

How to create an observed stated class and Scenarri
---------------------------------------------------
Quick How-to to learn how use this library : [Startup](docs/quick-startup.md).

API Documentation
-----------------
Generated documentation from the library with PhpDocumentor : Coming soon

Credits
-------
Richard Déloge - <richarddeloge@gmail.com> - Lead developer.
Teknoo Software - <http://teknoo.software>

About Teknoo Software
---------------------
**Teknoo Software** is a PHP software editor, founded by Richard Déloge. 
Teknoo Software's DNA is simple : Provide to our partners and to the community a set of high quality services or software,
 sharing knowledge and skills.

License
-------
States Life Cycle is licensed under the MIT License - see the licenses folder for details

Contribute :)
-------------

You are welcome to contribute to this project. [Fork it on Github](CONTRIBUTING.md)
