function DeleteFormController($scope, $http, apiService)
{
    $scope.region = null;
    $scope.area = null;
    $scope.regions = [];
    $scope.requestUri = '';
    $scope.json = '';

    $scope.regionsRequestUri = apiService.baseApiRequest() + '/locations/region/json';

    $http.get($scope.regionsRequestUri).success(function(data)
    {
        $scope.regions = [];

        $(data.response.location).each(function(index, elem)
        {
            $scope.regions.push(elem);
        });
    });

    $scope.delete = function()
    {
        $scope.json = '';

        var baseUri = apiService.baseApiRequest() + '/crimes/6-2013/delete';

        $scope.requestUri = [baseUri, $scope.area.name.toLowerCase(), 'json'].join('/');

        $http.get($scope.requestUri).success(function(data)
        {
            $scope.json = JSON.stringify(data, null, 4);

            var index = $scope.region.areas.indexOf($scope.area);
            $scope.region.areas.splice(index, 1);
                        
            $scope.region = null;
            $scope.area = null;
        }).error(function(data)
        {
            $scope.json = data;
        });
    };
}