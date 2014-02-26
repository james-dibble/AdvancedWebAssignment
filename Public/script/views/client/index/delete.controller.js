function DeleteFormController($scope, $http, apiService, cacheService)
{
    $scope.region = null;
    $scope.area = null;
    $scope.requestUri = '';
    $scope.json = '';

    cacheService.bindRegions($scope, 'regions', function(newValue){
        $scope.regions = newValue;
    });

    $scope.delete = function()
    {
        $scope.json = '';

        var baseUri = apiService.baseApiRequest() + '/crimes/6-2013/delete';

        $scope.requestUri = [baseUri, $scope.area.name.toLowerCase(), 'json'].join('/');

        $http.get($scope.requestUri).success(function(data)
        {
            $scope.json = JSON.stringify(data, null, 4);

            cacheService.updateRegionCache();
                        
            $scope.region = null;
            $scope.area = null;
        }).error(function(data)
        {
            $scope.json = data;
        });
    };
}