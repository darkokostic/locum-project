var PracticeSessionsServices = angular.module('PracticeSessionsServices', [])
PracticeSessionsServices.factory('PracticeSessionsService', ['$http','$q','toastr','$cookies', function($http,$q,toastr,$cookies,$rootScope) {
	return{
        getCurrentLocums: function(){
        	var defer = $q.defer();
            $http({
            method: 'POST',
            data:{
            	'completed':false
            },
            url: 'api/v1/session/practice'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
        return defer.promise;   
        },

        getCurrentLocumsSearch: function(search){
            var defer = $q.defer();
            $http({
                method: 'POST',
                data:{
                    'completed':false,
                    'locum_name':search.title,
                    'job_start':search.dateFromToSearch,
                    'job_end':search.dateToToSearch
                },
                url: 'api/v1/session/practice'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        paginate: function(url,search){
            var defer = $q.defer();
            $http({
                method: 'POST',
                data:{
                    'completed':false,
                    'locum_name':search.title,
                    'job_start':search.dateFromToSearch,
                    'job_end':search.dateToToSearch
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

        getLocumsWhoCompleted: function() {
        	var defer = $q.defer();
            $http({
            method: 'POST',
            data:{
            	'completed':true
            },
            url: 'api/v1/session/practice'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        }, 
        giveFeedback: function(feedback,id){
            var userId=id;
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'job_id' :  feedback.id,
                    'content' : feedback.content,
                    'rating' : feedback.rating
                },
                url: 'api/v1/feedback/create/'+userId
            }).then(function successCallback(response) {
                defer.resolve(response);
                toastr.success("Successfully given feedback!");
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },  
        finishJob: function(jobId){
            var defer = $q.defer();
            $http({
                method: 'PATCH',
                data: {
                    'completed' : 1
                },
                url: 'api/v1/job/'+jobId
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },
        
        sendAmount: function(percId) {
            var defer = $q.defer();
            $http({
                method: 'GET',
                url: 'api/v1/percentages/'+percId
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
        return defer.promise;
        },

        declineAmount: function(percId) {
            var defer = $q.defer();
            $http({
                method: 'GET',
                url: 'api/v1/percentages/decline/'+percId
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
        return defer.promise;
        }
}
}]);