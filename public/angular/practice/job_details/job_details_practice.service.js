var PracticeJobDetailsServices = angular.module('PracticeJobDetailsServices', [])
PracticeJobDetailsServices.factory('PracticeJobDetailsService', function($http,$q,toastr) {
	return {
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
        },

        sendMailPracticePost: function(nearestDoctor,idUser){
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'mail_subject' : nearestDoctor.description,
                    'mail_content' : nearestDoctor.subject,
                    'user_id' : idUser 
                },
                url: 'api/v1/mail/send'
            }).then(function successCallback(response) {
                defer.resolve(response);
                toastr.success(response.data.message);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
                toastr.warning(response.data.message);
            });
            return defer.promise;
        },

        accept: function(userId,jobId){//Ovde Toast
            console.log(userId, jobId);
            var defer = $q.defer();
            $http({
                method: 'GET',
                data: {
                    'user_id' : userId
                },
                url: 'api/v1/pay-pal-job/'+jobId+'/'+userId
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        acceptApplication: function(userId,jobId){//Ovde Toast
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'user_id' : userId,
                    'job_id' : jobId
                },
                url: 'api/v1/mail/contract/send'
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