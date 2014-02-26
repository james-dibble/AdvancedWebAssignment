<div class="row">
    <div class="col-lg-9">
        <div class="row" id="report">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>Report</h2>
                </div>
                <div id="patterns">
                    <h3>Use of patterns</h3>
                    <p>
                        Several design patterns were utilised to build the application.  The overall architecture is based around 
                        service-orientation, where actions completed upon domain models are restricted to a layer of classes.  These
                        classes are also the only ones that have access to the persistence layer.  The domain model layer is shared
                        between all the layers of the application.
                    </p>
                    <p>
                        The presentation layer, relies upon an MVC pattern, where the controllers invoke services to gain information
                        about the models and build views or data responses.  HTTP actions are routed to appropriate controllers via
                        HTAccess entries and the sole "script" file in the application that invokes the routing framework.
                    </p>
                    <p>
                        Inversion of Control is the final core part of the architecture, where dependencies are defined before routing
                        is invoked and injected into controllers when they are constructed.  This helps apply the Dependency Inversion 
                        principle of <a href="http://en.wikipedia.org/wiki/SOLID" target="_blank">SOLID</a>
                        object oriented design.  If a <a href="http://en.wikipedia.org/wiki/Test-driven_development" target="_blank">TDD</a> 
                        development approach had been utilised, as the vast majority of dependencies are injected into classes rather 
                        than created, unit testing would have been much easier to complete as mock objects could have substituted.
                    </p>
                    <p>
                        For persistence, the Data Mapper pattern was chosen.  Domain model objects can be constructed from database
                        entries extracted using a dictionary of classes mapped to a certain type, so that a common interface can
                        be used to retrieve, save and update persisted objects.  It would have been preferable to use stored procedures
                        rather than hard coding SQL statements, but the <code>CREATE PROCEDURE</code> statement was denied.
                    </p>
                </div>
                <div id="issues">
                    <h3>Issues Overcome</h3>
                    <p>
                        As PEAR libraries were not allowed to be used, an XML serialiser needed to be devised.  Rather than creating
                        a class to serailise each object into XML, a class was created that reflected the properties on an object 
                        instance and produced an XML file.
                    </p>
                    <p>
                        In terms of server-side caching, data-caching would have been far more appropriate for this assignment, but
                        as this requires libraries such as <a href="http://php.net/memcache" target="_blank">memcache</a> are not 
                        available on the UWE Apache servers.  Instead a content caching mechanism was devised where the contents
                        of the the output buffer are automatically saved for each request and retrieved if a path previously accessed
                        has been cached.
                    </p>
                </div>
                <div id="outcomes">
                    <h3>Learning Outcomes</h3>
                    <p>
                        I learnt a great deal about utilising design patterns in a functional programming language (PHP), and was able
                        to expand my knowledge of creating RESTful data APIs that conform to a predefined URI structure.  Another important
                        skill I enhanced was dealing with unfit requirements, specifically the PUT request, by going back to the client
                        (in this case the module leader) and request information about it and suggesting appropriate alternatives.
                    </p>
                </div>
                <p><strong>Words</strong> <span class="badge">426</span></p>
            </div>
        </div>
        <div class="row" id="uri">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>URI Distinctions from Specification</h2>
                </div>
                <h3>
                    PUT
                </h3>
                <p>
                    As I made the decision not to store the totals anywhere and instead calculate them, the specification for the 
                    <code>PUT</code> request was inadequate.  I instead decided to follow a similar URI scheme to the <code>POST</code>
                    request where individual values for an existing area can be updated using its abbreviation.
                </p>
                <p>
                    The URI therefore becomes:
                </p>
                <pre>
http://www.cems.uwe.ac.uk/~{username}/atwd/crimes/6-2013/put/{region}/{area}/{crimeAbbreviation}:{value}/{json|xml}
                </pre>
                <p>
                    For multiple updated values the values are "-" delimited:
                </p>
                <pre>
http://www.cems.uwe.ac.uk/~{username}/atwd/crimes/6-2013/put/{region}/{area}/{crimeAbbreviation}:{value}-{crimeAbbreviation}:{value}/{json|xml}
                </pre>
                <p>
                    The list of abbreviations are as follows:
                </p>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Crime Type</th>
                        <th>Abbreviation</th>
                    </tr>
                    <tr>
                        <td>BicycleTheft</td>
                        <td>bt</td>
                    </tr>
                    <tr>
                        <td>CriminalDamageAndArson</td>
                        <td>cdaa</td>
                    </tr>
                    <tr>
                        <td>DomesticBurglary</td>
                        <td>db</td>
                    </tr>
                    <tr>
                        <td>DrugOffenses</td>
                        <td>do</td>
                    </tr>
                    <tr>
                        <td>Fruad</td>
                        <td>frd</td>
                    </tr>
                    <tr>
                        <td>Homocide</td>
                        <td>hom</td>
                    </tr>
                    <tr>
                        <td>MiscCrimes</td>
                        <td>mc</td>
                    </tr>
                    <tr>
                        <td>MiscTheft</td>
                        <td>mt</td>
                    </tr>
                    <tr>
                        <td>NonDomesticBurglary</td>
                        <td>ndb</td>
                    </tr>
                    <tr>
                        <td>PossesionOfWeapons</td>
                        <td>pow</td>
                    </tr>
                    <tr>
                        <td>PublicOrderOffenses</td>
                        <td>poo</td>
                    </tr>
                    <tr>
                        <td>Robbery</td>
                        <td>rob</td>
                    </tr>
                    <tr>
                        <td>SexualOffenses</td>
                        <td>so</td>
                    </tr>
                    <tr>
                        <td>Shoplifting</td>
                        <td>shop</td>
                    </tr>
                    <tr>
                        <td>TheftFromPerson</td>
                        <td>tfp</td>
                    </tr>
                    <tr>
                        <td>TheftOffenses</td>
                        <td>th</td>
                    </tr>
                    <tr>
                        <td>VehicleOffenses</td>
                        <td>vo</td>
                    </tr>
                    <tr>
                        <td>ViolenceWithInjury</td>
                        <td>vwi</td>
                    </tr>
                    <tr>
                        <td>ViolenceWithoutInjury</td>
                        <td>vwoi</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row" id="credits">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>Credits</h2>
                </div>
                <p>
                <table class="table table-bordered">
                    <tr>
                        <th>Plugin</th>
                        <th>Link</th>
                        <th>Usage</th>
                    </tr>
                    <tr>
                        <td><span class="label label-primary">AngularJS</span></td>
                        <td><a href="http://angularjs.org/" target="_blank"><code>http://angularjs.org/</code></a></td>
                        <td>
                            <ul>
                                <li>MVVM client side architecture</li>
                                <li>AJAX request building and processing</li>
                                <li>Data binding</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="label label-primary">Bootstrap</span></td>
                        <td><a href="http://getbootstrap.com/" target="_blank"><code>http://getbootstrap.com/</code></a></td>
                        <td>
                            <ul>
                                <li>Client-side styling</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="label label-primary">Readable Bootswatch Theme</span></td>
                        <td><a href="http://bootswatch.com/readable/" target="_blank"><code>http://bootswatch.com/readable/</code></a></td>
                        <td>
                            <ul>
                                <li>Client-side styling</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="label label-primary">Highcharts</span></td>
                        <td><a href="http://www.highcharts.com/" target="_blank"><code>http://www.highcharts.com/</code></a></td>
                        <td>
                            <ul>
                                <li>Data visualisation</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="label label-primary">LINQ JS</span></td>
                        <td><a href="http://linqjs.codeplex.com/" target="_blank"><code>http://linqjs.codeplex.com/</code></a></td>
                        <td>
                            <ul>
                                <li>Array querying</li>
                                <li>JS object manipulation</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="label label-primary">Repo.js</span></td>
                        <td><a href="http://darcyclarke.me/dev/repojs/" target="_blank"><code>http://darcyclarke.me/dev/repojs/</code></a></td>
                        <td>
                            <ul>
                                <li>Displaying code source from Github.</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="label label-primary">Angular Local Storage</span></td>
                        <td><a href="https://github.com/agrublev/angularLocalStorage" target="_blank"><code>https://github.com/agrublev/angularLocalStorage</code></a></td>
                        <td>
                            <ul>
                                <li>Two way bindable HTML5 Local Storage wrapper.</li>
                            </ul>
                        </td>
                    </tr>
                </table>
                </p>
            </div>
        </div>
        <div class="row" id="code">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>Code</h2>
                </div>
                <p>
                    Code history hosted upon <a href="https://github.com/james-dibble/AdvancedWebAssignment">GitHub</a>.
                </p>
                <?php
                $relativePath = '/../../../../';

                displayFolderContents(dirname(__FILE__) . $relativePath, $relativePath);

                function displayFolderContents($dir, $relativePath)
                {
                    $actualDirName = explode($relativePath, $dir)[1];

                    echo "<strong>$actualDirName</strong>";
                    echo '<ul class="unstyled">';

                    $cdir = scandir($dir);

                    foreach ($cdir as $key => $value)
                    {
                        if (!in_array($value, array(".", "..")))
                        {
                            if (!is_dir($dir . DIRECTORY_SEPARATOR . $value))
                            {
                                $linkPath = CONTEXT_PATH . 'crimes/doc/source' . $actualDirName . '/' . $value;

                                echo "<li><a href=\"$linkPath\">$value</a></li>";
                            }
                        }
                    }

                    foreach ($cdir as $key => $value)
                    {
                        if (!in_array($value, array(".", "..")))
                        {
                            if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                            {
                                displayFolderContents($dir . DIRECTORY_SEPARATOR . $value, $relativePath);
                            }
                        }
                    }

                    echo '</ul>';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3 visible-lg">
        <nav data-spy="affix" data-offset-top="60" data-offset-bottom="200" role="complementary" id="scrollTarget">
            <ul class="nav nav-pills nav-stacked" style="width: 300px">
                <li><a href="#report">Report</a></li>
                <li><a href="#uri">Uri Distinctions From Specification</a></li>
                <li><a href="#credits">Credits</a></li>
                <li><a href="#code">Code</a></li>
            </ul>
        </nav>
    </div>
</div>
