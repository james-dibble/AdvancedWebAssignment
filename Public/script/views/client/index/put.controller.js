function PutFormController($scope, $http)
{
    $scope.region = null;
    $scope.area = null;
    $scope.crimeStatistics = [];
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
    
    $scope.put = function()
    {
        var baseUri = '/atwd/crimes/6-2013/put';
                
        $scope.requestUri = [baseUri, $scope.area.name.toLowerCase(), 'json'].join('/');
        
//        $http.get($scope.requestUri).success(function(data)
//        {
//            $scope.json = JSON.stringify(data, null, 4);
//        });
    };
    
   var getAreaStatistics = function(region)
   {
       var baseUri = '/atwd/crimes/6-2013';
       
       $(region.areas).each(function(index, area){
           var requestUri = [baseUri, region.name, area.name, 'json'].join('/');
           
            $http.get(requestUri).success(function(data)
            {
                $(data.response.statistics).each(function(index, elem)
                {
                });
            });
       });
   };
}