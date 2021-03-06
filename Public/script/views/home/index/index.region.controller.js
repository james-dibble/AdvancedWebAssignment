function ChartsRegionController($scope, cacheService)
{
    $scope.regions = [];
    $scope.nationals = [];

    cacheService.bindRegionStatistics($scope, 'regionStatistics', function(newValue) {
        if (newValue === null)
        {
            $scope.regions = [];
            $scope.nationals = [];
        }
        else
        {
            $scope.regions = newValue.region;
            $scope.nationals = newValue.national;
        }

        buildBarChart();

        buildPieChart();
    });

    cacheService.updateRegionStatisticsCache();

    var buildBarChart = function() {
        $('#region-bar-chart').highcharts({
            chart: {
                type: 'column',
                margin: [50, 50, 100, 80]
            },
            title: {
                text: 'Crime Statistics for England and Wales'
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
                pointFormat: 'Total Crime <b>{point.y:.1f}</b>',
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

    var buildBarChartData = function() {
        var barChartData = $.Enumerable.From($scope.regions).Select(function(region) {
            return region.total;
        }).Concat($.Enumerable.From($scope.nationals).Select(function(national) {
            return national.total;
        })).ToArray();

        return barChartData;
    };

    var buildBarChartCategories = function() {
        var categories = $.Enumerable.From($scope.regions).Select(function(region) {
            return region.id;
        }).Concat($.Enumerable.From($scope.nationals).Select(function(national) {
            return national.id;
        })).ToArray();

        return categories;
    };

    var buildPieChart = function() {
        $('#region-pie-chart').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Crime Statistics for England and Wales'
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
                    name: 'Crime Statistics for England and Wales',
                    data: buildPieData()
                }]
        });
    }

    var calculateRegionsTotal = function() {
        var total = $.Enumerable.From($scope.regions).Select(function(region) {
            return region.total;
        }).Concat($.Enumerable.From($scope.nationals).Select(function(national) {
            return national.total;
        })).Sum();

        return total;
    }

    var buildPieData = function() {
        var regionsTotal = calculateRegionsTotal();

        var pieData = $.Enumerable.From($scope.regions).Select(function(region) {
            return [region.id, region.total / regionsTotal];
        }).Concat($.Enumerable.From($scope.nationals).Select(function(national) {
            return [national.id, national.total / regionsTotal];
        })).ToArray();

        return pieData;
    }
}