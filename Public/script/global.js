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
        updateCache: function() {
            var requestUri = apiService.baseApiRequest() + '/locations/region/json';

            $http.get(requestUri).success(function(data)
            {
                $store.set('regions', data.response.location);
            });
        }
    };

    service.updateCache();

    return service;
});