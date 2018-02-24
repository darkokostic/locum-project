var JobDetailsServices = angular.module('JobDetailsServices', [])
JobDetailsServices.factory('JobDetailsService', function($http,$q,toastr) {

	return{
        allOtherApplications: function(jobId) {
            var defer = $q.defer();
            $http({
                method: 'GET',
                url: 'api/v1/job/with-applications/'+jobId
            }).then(function successCallback(response) {
                    defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                    defer.reject(response);
            });
        return defer.promise;
        },

        paginate: function(url) {
            var defer = $q.defer();
            $http({
                method: 'GET',
                url: url
            }).then(function successCallback(response) {
                    defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                    defer.reject(response);
            });
            return defer.promise;
        },

        userWhoWon: function(userId) {
            var defer = $q.defer();
            $http({
                method: 'GET',
                url: 'api/v1/app/'+userId
            }).then(function successCallback(response) {
                    defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                    defer.reject(response);
            });
            return defer.promise;
        },

        getJob: function(jobId) {
            var defer = $q.defer();
            $http({
                method: 'GET',
                url: 'api/v1/job/'+jobId
            }).then(function successCallback(response) {
                    defer.resolve(response);
                    return response;
            }, function errorCallback(response) {
                    defer.reject(response);
            });
        return defer.promise;
        }
    }
});