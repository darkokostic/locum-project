var ViewPracticeServices = angular.module('ViewPracticeServices', [])
ViewPracticeServices.factory('ViewPracticeService', function($http,$q,toastr) {

	return{
        getFeedback: function(practiceId){
            var defer = $q.defer();
            $http({
            method: 'GET',
            data:{
            },
            url: 'api/v1/feedback/practice/show/'+practiceId
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
        return defer.promise;
        },

        showPractice: function(practiceId){
            var defer = $q.defer();
            $http({
                method: 'GET',
                url: 'api/v1/practice/'+practiceId
            }).then(function successCallback(response) {
                if(response.data.entity.practice_visible==0) {
                    defer.reject(response)
                }else{
                defer.resolve(response);
                }
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

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
        },

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
        }
    }
});