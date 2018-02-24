var HomeServices = angular.module('HomeServices', [])
HomeServices.factory('HomeService', function($http,$q) {
	return {
		getVacancies: function(userId){
	        var defer = $q.defer();
	        $http({
	        method: 'GET',
	        data:{
	        },
	        url: 'api/v1/job/vacancies'
	        }).then(function successCallback(response) {
	            defer.resolve(response);
	            return response;
	        }, function errorCallback(response) {
	            defer.reject(response);
	        });
	        return defer.promise;
	    },
	    
	    getLocumVac: function() {
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

	    getPracticeVac: function() {
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

	    httpGetNewsHome: function() {
			var defer = $q.defer();
        	$http({
                method: 'GET',
                url: 'api/v1/news/lastSix'
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
 