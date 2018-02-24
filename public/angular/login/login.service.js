var LoginServices = angular.module('LoginServices', [])
LoginServices.factory('LoginService', function($http,$q,$cookies,$rootScope,toastr) {
	return{
        loginLocum: function(user){
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'email' :  user.email,
                    'password' : user.password
                },
                url: 'api/v1/locum/login'
            }).then(function successCallback(response) {
                var userCookie = {
                    role: response.data.entity.role,
                    token: response.data.entity.token,
                };
                var today = new Date();
                var expiresValue = new Date(today);
                //Set 'expires' option in 4 hours
                expiresValue.setMinutes(today.getMinutes() + 240);  
                $cookies.putObject('userCookie', userCookie,{expires:expiresValue});
                $http.defaults.headers.common.Authorization = 'Bearer ' + userCookie.token;
                toastr.success(response.data.message);
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        loginPractice: function(user){
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'email' :  user.email,
                    'password' : user.password
                },
                contentType: "application/json",
                url: 'api/v1/practice/login'
            }).then(function successCallback(response) {
                var userCookie = {
                    role: response.data.entity.role,
                    token: response.data.entity.token,
                };
                var today = new Date();
                var expiresValue = new Date(today);
                //Set 'expires' option in 4 hours
                expiresValue.setMinutes(today.getMinutes() + 240);  
                $cookies.putObject('userCookie', userCookie,{expires:expiresValue});
                $http.defaults.headers.common.Authorization = 'Bearer ' + userCookie.token;
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        loginAdmin: function(user){
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'email' :  user.email,
                    'password' : user.password
                },
                url: 'api/v1/locum/login'
            }).then(function successCallback(response) {
                var userCookie = {
                    role: response.data.entity.role,
                    token: response.data.entity.token,
                };
                var today = new Date();
                var expiresValue = new Date(today);
                //Set 'expires' option in 4 hours
                expiresValue.setMinutes(today.getMinutes() + 240);  
                $cookies.putObject('userCookie', userCookie,{expires:expiresValue});
                $http.defaults.headers.common.Authorization = 'Bearer ' + response.data.entity.token;
                toastr.success(response.data.message);
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        }
    }
});