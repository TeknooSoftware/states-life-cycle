Teknoo Software - States Life Cyclable extension
================================================

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/cee11d43-81b1-4974-a388-880a532a2c4f/mini.png)](https://insight.sensiolabs.com/projects/cee11d43-81b1-4974-a388-880a532a2c4f) [![Build Status](https://travis-ci.org/TeknooSoftware/states-life-cycle.svg?branch=master)](https://travis-ci.org/TeknooSoftware/states-life-cycle)

Welcome and thank you to having downloaded this extension. 
It's allow you to add some new behavior to your stated class :
- Automated stated class : to switch automatically to states defined by validation rules defined in class by assertions
- Lifecycable stated class : to dispatch states updates from a stated class to observer
- Traceable stated class : to keep evolution of states in the lifecycle of your stated class
- Scenario : to create easily scenarii in php or yaml between stated class instances and others application's components
 
Example
-------
Examples of using this library is available in the folder demo.

Installation
------------
To install this library with composer, run this command :

    composer require teknoo/states-life-cycle

Requirements
------------
This library requires :

    * PHP 7+ (For PHP5.4 to 5.6, please to use the first major version, States 1.0+)
    * Composer
    * Teknoo Software States
    * Symfony event-dispatcher to dispatch event
    * Symfony yaml to parse yaml scenarii
    * Knplabs gaufrette to read yaml scenarri

Quick startup
-------------
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
**Teknoo Software** is a PHP software editor, founded by Richard Déloge, also co-founder of the web agency Uni Alteri. 
Teknoo Software shares the same DNA as Uni Alteri : Provide to our partners and to the community a set of high quality services or software, sharing knowledge and skills.

License
-------
States Life Cycle is licensed under the MIT License - see the licenses folder for details

Contribute :)
-------------

You are welcome to contribute to this project. [Fork it on Github](CONTRIBUTING.md)
