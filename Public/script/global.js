var atwd = angular.module('atwd', ['localStorage']);

atwd.factory('apiService', function() {
    var service = {
        baseApiRequest: function() {
            var baseUri = '/~j3-dibble/atwd';

            return baseUri;
        }
    };

    return service;
});

atwd.service('cacheService', function($http, $store, apiService) {
    var service = {
        bindRegions: function(scope, varName, callback) {
            return $store.bind(scope, varName, [], callback);
        },
        bindRegionStatistics: function(scope, varName, callback){
            return $store.bind(scope, varName, [], callback);
        },
        updateRegionCache: function() {
            var requestUri = apiService.baseApiRequest() + '/locations/region/json';

            $http.get(requestUri).success(function(data)
            {
                $store.set('regions', data.response.location);
            });
        },
        updateRegionStatisticsCache: function(){
            var requestUri = apiService.baseApiRequest() + '/crimes/6-2013/json';
            
            $http.get(requestUri).success(function(data)
            {
                $store.set('regionStatistics', data.response.crimes);
            });
        }
    };

    service.updateRegionCache();

    return service;
});