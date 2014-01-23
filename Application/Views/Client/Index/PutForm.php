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
                            <select data-ng-model="area" ng-options="a.name for a in region.areas" class="form-control">
                                <option>Select Area</option>
                            </select>
                        </div>
                    </div>
                    <div data-ng-repeat="crimeStatistic in crimeStatistics">
                        <div class="col-lg-5 col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Crime Type</label>
                                <div class="col-sm-9">
                                    <select data-ng-model="crimeStatistic.type" ng-options="t.name for t in crimeTypes" class="form-control">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="form-group">
                                <label class="col-sm-7 control-label">Crime Number</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" placeholder="Crime Number" data-ng-model="crimeStatistic.number" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <button type="button" class="btn btn-danger" data-ng-click="removeStatistic(crimeStatistic)">Remove</button>
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