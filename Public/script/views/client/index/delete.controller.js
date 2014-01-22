function DeleteFormController($scope, $http)
{
    $scope.region = null;
    $scope.area = null;
    $scope.regions = [];
    $scope.requestUri = '';
    $scope.json = '';
    
    $scope.regionsRequestUri = '/atwd/locations/region/json';

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
        var baseUri = '/atwd/crimes/6-2013/delete';
                
        $scope.requestUri = [baseUri, $scope.area.name.toLowerCase(), 'json'].join('/');
        
        $http.get($scope.requestUri).success(function(data)
        {
            $scope.json = JSON.stringify(data, null, 4);
        });
    };
}