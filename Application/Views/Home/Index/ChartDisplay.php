<div>
    <div class="panel panel-primary" data-ng-controller="ChartsRegionController">
        <div class="panel-heading">
            <h3 class="panel-title">Crimes By Region</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12" data-ng-show="loadingRegions">
                    <div class="alert alert-warning">Data loading</div>
                </div>
                <div class="col-lg-12" data-ng-show="loadingAreaDataFailed">
                    <div class="alert alert-danger">Loading Region Data Failed</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Data</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" data-ng-show="areaDataLoading">
                            <div class="alert alert-warning" data-ng-show="loadingRegions">Data loading</div>
                        </div>
                        <div class="col-lg-12" data-ng-show="loadingAreaDataFailed">
                            <div class="alert alert-danger">Loading Region Data Failed</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" data-ng-hide="areaDataLoading">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Region</th>
                                    <th>Total</th>
                                </tr>
                                <tr data-ng-repeat="region in regions">
                                    <td>{{region.id}}</td>
                                    <td>{{region.total}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <h3>Charts</h3>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#regionBar" data-toggle="tab">Bar</a></li>
                                <li><a href="#regionPie" data-toggle="tab">Pie</a></li>
                                <li><a href="#regionJson" data-toggle="tab">JSON</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="regionBar">
                                    <div class="row">&nbsp;</div>
                                    <div class="row">
                                        <div class="col-lg-12" data-ng-show="areaDataLoading">
                                            <div class="alert alert-warning">Data loading</div>
                                        </div>
                                        <div class="col-lg-12" data-ng-show="loadingAreaDataFailed">
                                            <div class="alert alert-danger">Loading Area Data Failed</div>
                                        </div>
                                        <div class="col-lg-12" data-ng-hide="areaDataLoading">
                                            <div id="region-bar-chart" style="height: 400px; margin: 0 auto"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="regionPie">
                                    <div class="row">&nbsp;</div>
                                    <div class="row">
                                        <div class="col-lg-12" data-ng-show="areaDataLoading">
                                            <div class="alert alert-warning">Data loading</div>
                                        </div>
                                        <div class="col-lg-12" data-ng-show="loadingAreaDataFailed">
                                            <div class="alert alert-danger">Loading Area Data Failed</div>
                                        </div>
                                        <div class="col-lg-12" data-ng-hide="areaDataLoading">
                                            <div id="region-pie-chart" style="height: 400px; margin: 0 auto"></div>    
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="regionJson">
                                    <div class="row">&nbsp;</div>
                                    <div class="row">
                                        <div class="col-lg-12" data-ng-show="areaDataLoading">
                                            <div class="alert alert-warning">Data loading</div>
                                        </div>
                                        <div class="col-lg-12" data-ng-show="loadingAreaDataFailed">
                                            <div class="alert alert-danger">Loading Area Data Failed</div>
                                        </div>
                                        <div class="col-lg-12" data-ng-hide="areaDataLoading">
                                            <span class="label label-primary">Request URI</span><code>{{requestUri}}</code>
                                            <br />
                                            <br />
                                            <pre>{{json}}</pre>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-primary" data-ng-controller="ChartsAreaController">
        <div class="panel-heading">
            <h3 class="panel-title">Crimes By Area</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-2">
                    <h3>Regions</h3>
                    <input type="search" data-ng-model="regionFilter" placeholder="Filter Regions" class="form-control" />
                    <ul class="nav nav-pills nav-stacked text-center">
                        <li data-ng-show="regionsLoading" class="disabled"><a href="#">Loading</a></li>
                        <li data-ng-show="loadingRegionsFailed" class="disabled"><a href="#">Failed</a></li>
                        <li data-ng-hide="filteredRegions.length || !loadingRegionsFailed" class="disabled"><a href="#">No Results</a></li>
                        <li data-ng-show="!regionsLoading && !loadingRegionsFailed" data-ng-repeat="region in filteredRegions = (regions | filter:regionFilter)"><a href="" data-ng-click="setActiveRegion(region)">{{region.name}}</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Data</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" data-ng-show="areaDataLoading">
                            <div class="alert alert-warning">Data loading</div>
                        </div>
                        <div class="col-lg-12" data-ng-show="loadingAreaDataFailed">
                            <div class="alert alert-danger">Loading Area Data Failed</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" data-ng-hide="areaDataLoading">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Area</th>
                                    <th>Total</th>
                                </tr>
                                <tr data-ng-repeat="area in areas">
                                    <td>{{area.name}}</td>
                                    <td>{{area.total}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <h3>Charts</h3>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#areaBar" data-toggle="tab">Bar</a></li>
                                <li><a href="#areaPie" data-toggle="tab">Pie</a></li>
                                <li><a href="#areaJson" data-toggle="tab">JSON</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="areaBar">
                                    <div class="row">&nbsp;</div>
                                    <div class="row">
                                        <div class="col-lg-12" data-ng-show="areaDataLoading">
                                            <div class="alert alert-warning">Data loading</div>
                                        </div>
                                        <div class="col-lg-12" data-ng-show="loadingAreaDataFailed">
                                            <div class="alert alert-danger">Loading Area Data Failed</div>
                                        </div>
                                        <div class="col-lg-12" data-ng-hide="areaDataLoading">
                                            <div id="area-bar-chart" style="height: 400px; margin: 0 auto"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="areaPie">
                                    <div class="row">&nbsp;</div>
                                    <div class="row">
                                        <div class="col-lg-12" data-ng-show="areaDataLoading">
                                            <div class="alert alert-warning">Data loading</div>
                                        </div>
                                        <div class="col-lg-12" data-ng-show="loadingAreaDataFailed">
                                            <div class="alert alert-danger">Loading Area Data Failed</div>
                                        </div>
                                        <div class="col-lg-12" data-ng-hide="areaDataLoading">
                                            <div id="area-pie-chart" style="height: 400px; margin: 0 auto"></div>    
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="areaJson">
                                    <div class="row">&nbsp;</div>
                                    <div class="row">
                                        <div class="col-lg-12" data-ng-show="areaDataLoading">
                                            <div class="alert alert-warning">Data loading</div>
                                        </div>
                                        <div class="col-lg-12" data-ng-show="loadingAreaDataFailed">
                                            <div class="alert alert-danger">Loading Area Data Failed</div>
                                        </div>
                                        <div class="col-lg-12" data-ng-hide="areaDataLoading">
                                            <span class="label label-primary">Request URI</span><code>{{requestUri}}</code>
                                            <br />
                                            <br />
                                            <pre>{{json}}</pre>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>