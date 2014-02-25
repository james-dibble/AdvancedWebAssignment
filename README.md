#Advanced Topics in Web Development Assignment

## Report

### Use of patterns

Several design patterns were utilised to build the application. The overall
architecture is based around service-orientation, where actions completed upon
domain models are restricted to a layer of classes. These classes are also the
only ones that have access to the persistence layer. The domain model layer is
shared between all the layers of the application.

The presentation layer, relies upon an MVC pattern, where the controllers
invoke services to gain information about the models and build views or data
responses. HTTP actions are routed to appropriate controllers via HTAccess
entries and the sole "script" file in the application that invokes the routing
framework.

Inversion of Control is the final core part of the architecture, where
dependencies are defined before routing is invoked and injected into
controllers when they are constructed. This helps apply the Dependency
Inversion principle of [SOLID](http://en.wikipedia.org/wiki/SOLID) object
oriented design. If a [TDD](http://en.wikipedia.org/wiki/Test-
driven_development) development approach had been utilised, as the vast
majority of dependencies are injected into classes rather than created, unit
testing would have been much easier to complete as mock objects could have
substituted.

For persistence, the Data Mapper pattern was chosen. Domain model objects can
be constructed from database entries extracted using a dictionary of classes
mapped to a certain type, so that a common interface can be used to retrieve,
save and update persisted objects. It would have been preferable to use stored
procedures rather than hard coding SQL statements, but the `CREATE PROCEDURE`
statement was denied.

### Issues Overcome

As PEAR libraries were not allowed to be used, an XML serialiser needed to be
devised. Rather than creating a class to serailise each object into XML, a
class was created that reflected the properties on an object instance and
produced an XML file.

In terms of server-side caching, data-caching would have been far more
appropriate for this assignment, but as this requires libraries such as
[memcache](http://php.net/memcache) are not available on the UWE Apache
servers. Instead a content caching mechanism was devised where the contents of
the the output buffer are automatically saved for each request and retrieved
if a path previously accessed has been cached.

### Learning Outcomes

I learnt a great deal about utilising design patterns in a functional
programming language (PHP), and was able to expand my knowledge of creating
RESTful data APIs that conform to a predefined structure.

# URI Distinctions from Specification

###  PUT

As I made the decision not to store the totals anywhere and instead calculate
them, the specification for the `PUT` request was inadequate. I instead
decided to follow a similar URI scheme to the `POST` request where individual
values for an existing area can be updated using its abbreviation.

The URI therefore becomes:

    
    
    http://www.cems.uwe.ac.uk/~{username}/atwd/crimes/6-2013/put/{region}/{area}/{crimeAbbreviation}:{value}/{json|xml}
            

For multiple updated values the values are "-" delimited:

    
    
    http://www.cems.uwe.ac.uk/~{username}/atwd/crimes/6-2013/put/{region}/{area}/{crimeAbbreviation}:{value}-{crimeAbbreviation}:{value}/{json|xml}
            

The list of abbreviations are as follows:

BicycleTheft - bt

CriminalDamageAndArson - cdaa

DomesticBurglary - db

DrugOffenses - do

Fruad - frd

Homocide - hom

MiscCrimes - mc

MiscTheft - mt

NonDomesticBurglary - ndb

PossesionOfWeapons - pow

PublicOrderOffenses - poo

Robbery - rob

SexualOffenses - so

Shoplifting - shop

TheftFromPerson - tfp

TheftOffenses - th

VehicleOffenses - vo

ViolenceWithInjury - vwi

ViolenceWithoutInjury - vwoi

## Credits

AngularJS

[`http://angularjs.org/`](http://angularjs.org/)

  * MVVM client side architecture
  * AJAX request building and processing
  * Data binding

Bootstrap

[`http://getbootstrap.com/`](http://getbootstrap.com/)

  * Client-side styling

Readable Bootswatch Theme

[`http://bootswatch.com/readable/`](http://bootswatch.com/readable/)

  * Client-side styling

Highcharts

[`http://www.highcharts.com/`](http://www.highcharts.com/)

  * Data visualisation

LINQ JS

[`http://linqjs.codeplex.com/`](http://linqjs.codeplex.com/)

  * Array querying
  * JS object manipulation

Repo.js

[`http://darcyclarke.me/dev/repojs/`](http://darcyclarke.me/dev/repojs/)

  * Displaying code source from Github.

