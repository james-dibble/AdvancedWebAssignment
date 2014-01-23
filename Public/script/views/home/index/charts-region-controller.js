function ChartsRegionController($scope, $http, apiService)
{
    $scope.regions = [];
    $scope.loadingRegions = true;
    $scope.loadingRegionsFailed = false;
    $scope.json = '';
    $scope.requestUri = apiService.baseApiRequest() + '/crimes/6-2013/json';
    
    $http.get($scope.requestUri).success(function(data)
    {
        $scope.regions = [];
        $scope.loadingRegions = false;
        $scope.loadingRegionsFailed = false;
        $scope.json = JSON.stringify(data, null, 4);
        
        $scope.regions = data.response.crimes.region;
        
        $('#region-bar-chart').highcharts({
                chart: {
                    type: 'column',
                    margin: [50, 50, 100, 80]
                },
                title: {
                    text: 'Regional Crime Totals'
                },
                xAxis: {
                    categories: $.Enumerable.From($scope.regions).Select(function(region) {
                        return region.id;
                    }).ToArray(),
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
                    pointFormat: 'Total Crime <b>{point.y:.1f}</b>',
                },
                series: [{
                        name: 'TotalCrimes',
                        data: $.Enumerable.From($scope.regions).Select(function(region) {
                            return region.total;
                        }).ToArray(),
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

            var regionsTotal = $.Enumerable.From($scope.regions).Select(function(region) {
                            return region.total;
                        }).Sum();
                        
            var pieData = $.Enumerable.From($scope.regions).Select(function(region) {
                            return [region.id, region.total / regionsTotal];
                        }).ToArray();

            $('#region-pie-chart').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: 'Regional Crimes'
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
                        name: 'Regional Crimes',
                        data: pieData
                    }]
            });
    })
            .error(function()
    {
        $scope.loadingRegionsFailed = true;
        $scope.loadingRegions = false;
        $scope.activeRegion = null;
    });
}