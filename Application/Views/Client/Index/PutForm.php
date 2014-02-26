<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#put">
                Put
            </a>
        </h4>
    </div>
    <div id="put" class="panel-collapse collapse out">
        <div class="panel-body">
            <form class="form-horizontal" role="form" data-ng-controller="PutFormController">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Region</label>
                        <div class="col-sm-9">
                            <select data-ng-model="region" ng-options="r.name for r in regions" class="form-control">
                                <option>Select Region</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Area</label>
                        <div class="col-sm-9">
                            <select data-ng-model="area" ng-options="a.name for a in region.areas" data-ng-change="getAreaStatistics()" class="form-control">
                                <option>Select Area</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12" data-ng-show="areDataFailedToLoad">
                        <div class="alert alert-danger">Loading Area Data Failed</div>
                    </div>
                    <div data-ng-repeat="crimeStatistic in crimeStatistics">
                        <div class="col-lg-9 col-md-9">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{crimeStatistic.type.name}}</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" placeholder="Crime Number" data-ng-model="crimeStatistic.value" data-ng-change="makeDirty(crimeStatistic)" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-block" data-ng-click="put()">Put</button>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Request URI</div>
                        <div class="panel-body">
                            <pre>{{requestUri}}</pre>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">Response</div>
                        <div class="panel-body">
                            <pre>{{json}}</pre>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>