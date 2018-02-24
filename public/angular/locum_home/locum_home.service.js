var LocumHomeServices = angular.module('LocumHomeServices', [])
LocumHomeServices.factory('LocumHomeService', ['$http','$q','toastr','$location', function($http,$q,toastr,$location) {
	return{
		getVacanciesLocum: function(userId){
	        var defer = $q.defer();
	        $http({
	        method: 'GET',
	        data:{
	        },
	        url: 'api/v1/job/locumVacancies'
	        }).then(function successCallback(response) {
	            defer.resolve(response);
	            return response;
	        }, function errorCallback(response) {
	            defer.reject(response);
	        });
	        return defer.promise;
	    },

	    getNewsLocum: function(userId){
	        var defer = $q.defer();
	        $http({
	        method: 'GET',
	        data:{
	        },
	        url: 'api/v1/news/locum/last_six'
	        }).then(function successCallback(response) {
	            defer.resolve(response);
	            return response;
	        }, function errorCallback(response) {
	            defer.reject(response);
	        });
	        return defer.promise;
	    },
	}
}]);