<div data-ng-controller="ChartsController">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Crimes By Region</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Data</h3>
                </div>
                <div class="col-lg-6">
                    <h3>Charts</h3>
                    <ul class="nav nav-tabs">
                        <li><a href="#region-bar" data-toggle="tab" class="active">Bar</a></li>
                        <li><a href="#region-pie" data-toggle="tab">Pie</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="region-bar">
                            <div class="row">
                                <div class="row">&nbsp;</div>
                                <div class="col-lg-12">
                                    <div class="alert alert-warning">Data loading</div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="region-pie">
                            <div class="row">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning">Data loading</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
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
                        <li data-ng-show="!regionsLoading && !loadingRegionsFailed" data-ng-repeat="region in filteredRegions = (regions | filter:regionFilter)"><a href="#" data-ng-click="setActiveRegion(region)">{{region.name}}</a></li>
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
                        <div class="col-lg-12">
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
                                <li class="active"><a href="#regionBar" data-toggle="tab">Bar</a></li>
                                <li><a href="#regionPie" data-toggle="tab">Pie</a></li>
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
                                        <div class="col-lg-12">
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
                                        <div class="col-lg-12">
                                            <div id="region-pie-chart" style="height: 400px; margin: 0 auto"></div>    
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