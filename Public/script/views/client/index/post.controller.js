function PostFormController($scope, $http, apiService, cacheService)
{
    $scope.region = null;
    $scope.areaName = '';
    $scope.crimeStatistics = [];
    $scope.crimeTypes = [];
    $scope.requestUri = '';
    $scope.json = '';
    
    cacheService.bindRegions($scope, 'regions', function(newValue){
        $scope.regions = newValue;
    });
    
    $scope.crimeTypesRequestUri = apiService.baseApiRequest() + '/crimes/types/json';

    $http.get($scope.crimeTypesRequestUri).success(function(data)
    {
        $scope.crimeTypes = [];

        $(data.response.crimes).each(function(index, elem)
        {
            $scope.crimeTypes.push(elem);
        });
    });
    
    $scope.addStatistic = function()
    {
        $scope.crimeStatistics.push({ type: {}, number: '0' });
    };
    
    $scope.removeStatistic = function(statistic)
    {
        $scope.crimeStatistics = $.grep($scope.crimeStatistics, function(value) {
            return value !== statistic;
          });
    };
    
    $scope.post = function()
    {
        $scope.json = '';
        
        var baseUri = apiService.baseApiRequest() + '/crimes/6-2013/post';
        
        var statistics = $.Enumerable
                .From($scope.crimeStatistics)
                .Select(function(stat){ return [stat.type.abbreviation, stat.number].join(':') })
                .ToArray()
                .join('-');
        
        $scope.requestUri = [baseUri, $scope.region.name.toLowerCase().replace(' ', '_'), $scope.areaName, statistics, 'json'].join('/');
        
        $http.get($scope.requestUri).success(function(data)
        {
            $scope.json = JSON.stringify(data, null, 4);
            
            cacheService.updateRegionCache();
            
            $scope.region = null;
            $scope.areaName = '';
            $scope.crimeStatistics = [];
        }).error(function(data)
        {
            $scope.json = data;
        });;
    };
}