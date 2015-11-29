Teknoo Software - States Life Cyclable extension
================================================

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/cee11d43-81b1-4974-a388-880a532a2c4f/mini.png)](https://insight.sensiolabs.com/projects/cee11d43-81b1-4974-a388-880a532a2c4f) [![Build Status](https://travis-ci.org/TeknooSoftware/statesBundle.svg?branch=next)](https://travis-ci.org/TeknooSoftware/statesBundle)

Welcome and thank you to having downloaded this extension. 
It's allow you to add some new behavior to your stated class :
- Automated stated class : to switch automatically to states defined by validation rules defined in class by assertions
- Lifecycable stated class : to dispatch states updates from a stated class to observer
- Traceable stated class : to keep evolution of states in the lifecycle of your stated class
- Scenario : to create easily scenarii in php or yaml between stated class instances and others application's components
 
Example
-------
An example of using this library is available in the folder demo.

Installation
------------
To install this library with composer, run this command :

    composer require teknoo/states:next-dev

Requirements
------------
This library requires :

    * PHP 7+ (For PHP5.4 to 5.6, please to use the first major version, States 1.0+)
    * Composer
    * Teknoo Software States
    * Symfony event-dispatcher to dispatch event
    * Symfony yaml to parse yaml scenarii
    * Knplabs gaufrette to read yaml scenarru

Although highly recommended, Composer is not needed, this library can be used with its own psr0 autoloader.

Presentation
------------
Quick How-to to learn how use this library : [Startup](docs/howto/details.md).

Quick startup
-------------
Quick How-to to learn how use this library : [Startup](docs/howto/quick-startup.md).

API Documentation
-----------------
Generated documentation from the library with PhpDocumentor : [Open](https://cdn.rawgit.com/TeknooSoftware/states/master/docs/api/index.html).

Behavior Documentation
----------------------
Documentation to explain how this library works : [Behavior](docs/howto/behavior.md).

Mandatory evolutions in 2.x versions
------------------------------------

From the version 2.0, this library has been redesigned to 
* Reuse all composer's autoloader usefull and powerfull features instead internal autoloader.
* Reduce the number of necessary components to the internal functioning of this library (Dependency Injector, Closure Injector). 
* Forbid the usage of slows functions like `call_user_func`.
* Use `Closure::call()` instead of `Closure::bind` to reduce memory ans cpu consumptions.
* Use Scalar Type Hinting to use PHP Engine's check instead if statements.

Credits
-------
Richard Déloge - <richarddeloge@gmail.com> - Lead developer.
Teknoo Software - <http://teknoo.software>

About Teknoo Software
---------------------
**Teknoo Software** is a PHP software editor, founded by Richard Déloge, also co-founder of the web agency Uni Alteri. 
Teknoo Software shares the same DNA as Uni Alteri : Provide to our partners and to the community a set of high quality services or software, sharing knowledge and skills.

License
-------
States is licensed under the MIT and GPL3+ Licenses - see the licenses folder for details

Contribute :)
-------------

You are welcome to contribute to this project. [Fork it on Github](CONTRIBUTING.md)
