var ViewLocumServices = angular.module('ViewLocumServices', [])
ViewLocumServices.factory('ViewLocumService', function($http,$q,toastr) {

	return{
        getFeedback: function(userId){
            var defer = $q.defer();
            $http({
            method: 'GET',
            data:{
            },
            url: 'api/v1/feedback/locum/show/'+userId
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        showLocum: function(locumId){
            var defer = $q.defer();
            $http({
                method: 'GET',
                url: 'api/v1/locum/'+locumId
            }).then(function successCallback(response) {
                if(response.data.entity.visible==0) {
                    defer.reject(response)
                }else{
                defer.resolve(response);
                }
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        paginateFeedback: function(url){
            var defer = $q.defer();
            $http({
                method: 'GET',
                data: {
                },
                url: url
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