function PutFormController($scope, $http, apiService)
{
    $scope.region = null;
    $scope.area = null;
    $scope.crimeStatistics = [];
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

    $scope.put = function()
    {
        $scope.json = '';
        
        var baseUri = apiService.baseApiRequest() + '/crimes/6-2013/put';
        
        var dirtyStatistics = $.Enumerable.From($scope.crimeStatistics).Where(function(crimeStatistic) { return crimeStatistic.isDirty; });
        
        var statisticsParameter = dirtyStatistics
                .Select(function(stat){ return [stat.type.abbreviation, stat.value].join(':') })
                .ToArray()
                .join('-');

        $scope.requestUri 
                = [
                    baseUri, 
                    $scope.region.name.toLowerCase().replace(/ /g, '_'), 
                    $scope.area.name.toLowerCase().replace(/ /g, '_'), 
                    statisticsParameter, 
                    'json'
                ].join('/');

        $http.get($scope.requestUri).success(function(data)
        {
            $scope.json = JSON.stringify(data, null, 4);
        }).error(function(data)
        {
            $scope.json = data;
        });;
    };

    $scope.getAreaStatistics = function()
    {
        var baseUri = apiService.baseApiRequest() + '/crimes/6-2013';

        var requestUri = [baseUri, $scope.region.name.replace(/ /g, '_'), $scope.area.name.replace(/ /g, '_'), 'json'].join('/');

        $scope.crimeStatistics = [];

        $http.get(requestUri).success(function(data)
        {
            $scope.crimeStatistics = data.response.crimes.crimeStatistics;
        });
    };
    
    $scope.makeDirty = function(crimeStatistic)
    {
        crimeStatistic.isDirty = true;
    };
}