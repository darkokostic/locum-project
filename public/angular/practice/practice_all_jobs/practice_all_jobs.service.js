var PracticeProfileServices = angular.module('PracticeAllJobsServices', [])
PracticeProfileServices.factory('PracticeAllJobsService', function($http,$q,toastr) {
	return {
		getAllJobs: function(){
            var defer = $q.defer();
            $http({
            method: 'POST',
            data:{
            },
            url: 'api/v1/practice/my_jobs'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
        return defer.promise;
        },

        searchAllJobs: function(searchTerm){
            var defer = $q.defer();
            $http({
            method: 'POST',
            data:{
                'title' :  searchTerm.title,
                'job_start' : searchTerm.dateFromToSearch,
                'job_end' :  searchTerm.dateToToSearch
            },
            url: 'api/v1/practice/my_jobs'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                toastr.warning(response.data.message);
                defer.reject(response);
            });
        return defer.promise;
        },

        paginateAllJobs: function(url,searchTerm){
            var defer = $q.defer();
            $http({
                method: 'POST',
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
        },
	}
});