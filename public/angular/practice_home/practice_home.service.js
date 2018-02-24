var PracticeHomeServices = angular.module('PracticeHomeServices', [])
PracticeHomeServices.factory('PracticeHomeService', function($http,$q,toastr) {
	return{
		getVacanciesPractice: function(userId){
	        var defer = $q.defer();
	        $http({
	        method: 'GET',
	        data:{
	        },
	        url: 'api/v1/job/practiceVacancies'
	        }).then(function successCallback(response) {
	            defer.resolve(response);
	            return response;
	        }, function errorCallback(response) {
	            defer.reject(response);
	        });
	        return defer.promise;
	    },
	    
	    getNewsPractice: function(userId){
	        var defer = $q.defer();
	        $http({
	        method: 'GET',
	        data:{
	        },
	        url: 'api/v1/news/practice/last_six'
	        }).then(function successCallback(response) {
	            defer.resolve(response);
	            return response;
	        }, function errorCallback(response) {
	            defer.reject(response);
	        });
	        return defer.promise;
	    },
    }
});