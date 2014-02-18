function DeleteFormController($scope, $http, apiService, cacheService)
{
    $scope.region = null;
    $scope.area = null;
    $scope.regions = [];
    $scope.requestUri = '';
    $scope.json = '';

    $scope.regions = cacheService.bindRegions($scope, 'regions');

    $scope.delete = function()
    {
        $scope.json = '';

        var baseUri = apiService.baseApiRequest() + '/crimes/6-2013/delete';

        $scope.requestUri = [baseUri, $scope.area.name.toLowerCase(), 'json'].join('/');

        $http.get($scope.requestUri).success(function(data)
        {
            $scope.json = JSON.stringify(data, null, 4);

            cacheService.updateCache();
            
            $scope.region = null;
            $scope.area = null;
        }).error(function(data)
        {
            $scope.json = data;
        });
    };
}