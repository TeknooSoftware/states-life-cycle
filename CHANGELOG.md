#Teknoo Software - States Life Cyclable extension - Change Log

###[2.0.1] - 2017-02-15
###Fix
- Code style fix
- License file follow Github specs
- Add tools to checks QA, use `make qa` and `make test`, `make` to initalize the project, (or `composer update`).
- Update Travis to use this tool
- Fix QA Errors

###[2.0.0] - 2017-01-06
###Release
- First release

###[2.0.0-beta1] - 2016-12-21
###Release
- First beta

##[2.0.0-alpha4] - 2016-10-31
###Added
- Event dispatcher interface to allow developer to use theirs owns dispatcher
    instead of symfony/event-dispatcher.
- Event trait to allow developer to implement theirs own event instance    

###Removed
- Hard coupling with symfony/event-dispatcher.
- Event class, replace by a trait to allow developer to implement theirs own event instance

###Updated
- Migrate Symfony Event to Require-dev because to uncouple this library with Symfony/event-dispatcher.

###Fixed
- Code style
- Scenarii in demo
- Deprecated units tests

##[2.0.0-alpha3] - 2016-10-27
###Updated
- Require States 3.0.0-alpha3 at least.
- Code style fix
- Update doc

##[2.0.0-alpha2] - 2016-10-11
###Fix
- Fix travis configuration

##[2.0.0-alpha1] - 2016-10-07
###Updated
- Version to support States 3+
- Update tests to be compliant with States 3+
- Update demo to be compliant with States 3+
- Fix Tokenizer to manage Full qualified state name

##[1.0.3] - 2016-09-02
###Fixed
- code style fix for insight of sensiolabs bugs

##[1.0.2] - 2016-09-02
###Fixed
- Fix bug with States 2.1 with canonical states name (use state's class name with namespace).

##[1.0.1] - 2016-08-04
###Fixed
- Improve optimization on call to native function and optimized

##[1.0.0] - 2016-07-26
###Updated
- First stable release

###Added
- Api Doc

###Fixed
- Remove legacy reference to Uni Alteri in licences
- Improve documentation and fix documentations
- Fix code style with cs-fixer

##[1.0.0-RC1] - 2016-04-09
###Updated
- first RC

###Fixed
- Fix code style with cs-fixer

##[1.0.0-beta5] - 2016-02-02
###Updated
- Composer minimum requirement
- Support Symfony Event Dispatcher 3.0
- Support Symfony Yaml 3.0

##[1.0.0-beta4] - 2016-01-20
###Updated
- Clean .gitignore
- Optimizing for inlined internal functions

##[1.0.0-beta3] - 2016-01-19
###Fixed
- Code style

##[1.0.0-beta2] - 2016-01-17
###Added
- Documentation

###Fixed
- Composer minimum stability error

##[1.0.0-beta1] - 2016-01-12
###Added
- Documentation
- Scenario builder in Yaml

###Fixed
- Test and coverages

###Removed
- Dead code in Scenario Builder

##[1.0.0-alpha1] - 2015-11-23
- First release of this library 

###Added
- Automated stated class : to switch automatically to states defined by validation rules defined in class
- Lifecycable stated class : to dispatch updates from a stated class to observer
- Traceable stated class : to keep evolution of states in the lifecycle of your stated class
- Scenario : to create easily scenario between stated class instances and others application's components
