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
                <div class="col-lg-4">
                    <h3>Regions</h3>
                    <input type="search" data-ng-model="regionFilter" placeholder="Filter Regions" class="form-control" />
                    <ul class="nav nav-pills nav-stacked text-center">
                        <li data-ng-show="regionsLoading" class="disabled"><a href="#">Loading</a></li>
                        <li data-ng-show="loadingRegionsFailed" class="disabled"><a href="#">Failed</a></li>
                        <li data-ng-hide="filteredRegions.length" class="disabled"><a href="#">No Results</a></li>
                        <li data-ng-show="!regionsLoading && !loadingRegionsFailed" data-ng-repeat="region in filteredRegions = (regions | filter:regionFilter)"><a href="#">{{region.name}}</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h3>Data</h3>
                </div>
                <div class="col-lg-4">
                    <h3>Charts</h3>
                    <ul class="nav nav-tabs">
                        <li><a href="#region-bar" data-toggle="tab" class="active">Bar</a></li>
                        <li><a href="#region-pie" data-toggle="tab">Pie</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="region-bar">
                            <div class="row">&nbsp;</div>
                            <div class="row">
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
</div>