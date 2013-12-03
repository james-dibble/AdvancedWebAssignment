function ChartsController($scope, $http)
{
    $scope.regionsLoading = true;
    $scope.loadingRegionsFailed = false;
    $scope.regions = [];
    $scope.activeRegion = null;

    $http.get('/atwd/locations/region/json')
            .success(function(data)
    {
        $scope.regions = [];
        $scope.regionsLoading = false;
        $scope.loadingRegionsFailed = false;
        $scope.activeRegion = null;

        $(data.response.location).each(function(index, elem)
        {
            $scope.regions.push({name: elem.name});
        });
    })
            .error(function()
    {
        $scope.loadingRegionsFailed = true;
        $scope.regionsLoading = false;
        $scope.activeRegion = null;
    });

    $scope.setActiveRegion = function(region)
    {
        $scope.activeRegion = region;
        LoadRegionData();
    };

    $scope.areaDataLoading = false;
    $scope.loadingAreaDataFailed = false;
    $scope.areas = [];

    function LoadRegionData()
    {
        $scope.areaDataLoading = true;

        $http.get(['/atwd/crimes/6-2013/', $scope.activeRegion.name.replace(' ', '-'), '/json'].join(''))
                .success(function(data) {
            $scope.areas = [];
            $scope.areaDataLoading = false;
            $scope.loadingAreaDataFailed = false;

            $(data.response.crimes.region.area).each(function(index, elem)
            {
                $scope.areas.push({name: elem.id, total: elem.total});
            });

        })
                .error(function()
        {
            $scope.loadingAreaDataFailed = true;
            $scope.areaDataLoading = false;
        });
    }
}