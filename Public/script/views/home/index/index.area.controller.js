function ChartsAreaController($scope, $http, apiService, cacheService)
{
    $scope.activeRegion = null;

    $scope.areaDataLoading = false;
    $scope.loadingAreaDataFailed = false;
    $scope.areas = [];

    cacheService.bindRegions($scope, 'regions', function(newValue) {
        $scope.regions = newValue;
    });

    $scope.setActiveRegion = function(region)
    {
        $scope.activeRegion = region;
        LoadRegionData();
    };

    var LoadRegionData = function()
    {
        $scope.areaDataLoading = true;

        $scope.requestUri = [
            apiService.baseApiRequest() + '/crimes/6-2013/',
            $scope.activeRegion.name.toLowerCase().replace(/ /g, '_'),
            '/json'
        ].join('');

        $http.get($scope.requestUri).success(function(data)
        {
            $scope.areas = [];
            $scope.areaDataLoading = false;
            $scope.loadingAreaDataFailed = false;

            $(data.response.crimes.region.area).each(function(index, elem)
            {
                $scope.areas.push({name: elem.id, total: elem.total});
            });
            
            createBarChart();
            createPieChart();
        })
        .error(function()
        {
            $scope.loadingAreaDataFailed = true;
            $scope.areaDataLoading = false;
        });
    };

    var createBarChart = function() {
        $('#area-bar-chart').highcharts({
            chart: {
                type: 'column',
                margin: [50, 50, 100, 80]
            },
            title: {
                text: ['Crimes in ', $scope.activeRegion.name].join('')
            },
            xAxis: {
                categories: buildBarChartCategories(),
                labels: {
                    rotation: -45,
                    align: 'right'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total Crimes'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Total Crime <b>{point.y:.1f}</b>'
            },
            series: [{
                    name: 'TotalCrimes',
                    data: buildBarChartData(),
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        x: 4,
                        y: 10
                    }
                }]
        });
    };

    var buildBarChartCategories = function() {
        var categories = $.Enumerable.From($scope.areas).Select(function(area) {
            return area.name;
        }).ToArray();

        return categories;
    };

    var buildBarChartData = function() {
        var data = $.Enumerable.From($scope.areas).Select(function(area) {
            return area.total;
        }).ToArray();

        return data;
    };

    var createPieChart = function() {
        $('#area-pie-chart').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: ['Crimes in ', $scope.activeRegion.name].join('')
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                    type: 'pie',
                    name: ['Crimes in ', $scope.activeRegion.name].join(''),
                    data: createPieData()
                }]
        });
    };

    var calculateRegionTotal = function() {
        var regionTotal = $.Enumerable.From($scope.areas).Select(function(area) {
            return area.total;
        }).Sum();

        return regionTotal;
    };

    var createPieData = function() {
        var regionTotal = calculateRegionTotal();

        var pieData = $.Enumerable.From($scope.areas).Select(function(area) {
            return [area.name, area.total / regionTotal];
        }).ToArray();

        return pieData;
    };
}