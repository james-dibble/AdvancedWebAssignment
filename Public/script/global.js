var atwd = angular.module("atwd", []);

atwd.factory('apiService', function() {
    var service = {
        baseApiRequest: function() {
            var baseUri = '/~j3-dibble/atwd';
            
            return baseUri;
        }
    };

    return service;
});