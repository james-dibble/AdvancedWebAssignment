<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#delete">
                Delete
            </a>
        </h4>
    </div>
    <div id="delete" class="panel-collapse collapse out">
        <div class="panel-body">
            <form class="form-horizontal" role="form" data-ng-controller="DeleteFormController">
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
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-block" data-ng-click="delete()">Delete</button>
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