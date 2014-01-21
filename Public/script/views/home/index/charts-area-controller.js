function ChartsAreaController($scope, $http)
{
    $scope.regionsLoading = true;
    $scope.loadingRegionsFailed = false;
    $scope.regions = [];
    $scope.activeRegion = null;

    $http.get('/~j3-dibble/atwd/locations/region/json')
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

    var LoadRegionData = function ()
    {
        $scope.areaDataLoading = true;

        var regionName = $scope.activeRegion.name.split(' ').join('-');

        $http.get(['/~j3-dibble/atwd/crimes/6-2013/', regionName, '/json'].join(''))
                .success(function(data) {
            $scope.areas = [];
            $scope.areaDataLoading = false;
            $scope.loadingAreaDataFailed = false;

            $(data.response.crimes.region.area).each(function(index, elem)
            {
                $scope.areas.push({name: elem.id, total: elem.total});
            });

            $('#area-bar-chart').highcharts({
                chart: {
                    type: 'column',
                    margin: [50, 50, 100, 80]
                },
                title: {
                    text: ['Crimes in ', $scope.activeRegion.name].join('')
                },
                xAxis: {
                    categories: $.Enumerable.From($scope.areas).Select(function(area) {
                        return area.name;
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
                        data: $.Enumerable.From($scope.areas).Select(function(area) {
                            return area.total;
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

            var regionTotal = $.Enumerable.From($scope.areas).Select(function(area) {
                            return area.total;
                        }).Sum();
                        
            var pieData = $.Enumerable.From($scope.areas).Select(function(area) {
                            return [area.name, area.total / regionTotal];
                        }).ToArray();

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
                        data: pieData
                    }]
            });

        })
                .error(function()
        {
            $scope.loadingAreaDataFailed = true;
            $scope.areaDataLoading = false;
        });
    }
}