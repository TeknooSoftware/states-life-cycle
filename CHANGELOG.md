#Teknoo Software - States Life Cyclable extension - Change Log

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
