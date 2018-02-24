var RegistrationServices = angular.module('RegistrationServices', [])
RegistrationServices.factory('RegistrationService', ['$http','$q','toastr','$cookies', function($http,$q,toastr,$cookies) {
	return{
        checkRegisterLocum: function(user){
            var defer = $q.defer();
            $http({
            method: 'POST',
            data: {
                'name' :  user.name,
                'password' : user.password,
                'email' : user.email
            },
            url: 'api/v1/locum'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.resolve(response);
                return response;
            });
            return defer.promise;
        },

        registerPractice: function(user){
            var defer = $q.defer();
            $http({
            method: 'POST',
            data: {
                'name' :  user.name,
                'password' : user.password,
                'email' : user.email,
                'postal_code' : user.postal_code,
                'city' : user.city,
                'practice_address1' :  user.practice_address1,
                'practice_address2' :  user.practice_address2,
                'practice_city' : user.practice_city,
                'practice_province' :  user.practice_province,
                'practice_postal_code' : user.practice_postal_code,
                'practice_phone' : user.practice_phone,
                'practice_name' : user.practice_name,
                'no_of_staff' : user.practice_no_of_staff,
                'practice_email' : user.practice_email,
                'lat' : user.lat,
                'lng' : user.lng,
                'practice_visible' : true
            },
            url: 'api/v1/practice'
            }).then(function successCallback(response) {
                defer.resolve(response);
                toastr.success("Successfully registered");
                return response;
            }, function errorCallback(response) {
                toastr.warning(response.data.message);
                defer.reject(response);
            });
            return defer.promise;
        },

        getGeolocation: function() {
            var defer = $q.defer();
            $http({
                method: 'POST',
                url: 'https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyBnICk37tkvyjby446VXMfe1c0-A34AUHU'
            }).then(function successCallback(response) {
                    defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                    defer.reject(response);
            });
         return defer.promise;
        },

        getAddress: function(lat,long) {
             var defer = $q.defer();
            $http({
                method: 'GET',
                url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+long+'&key=AIzaSyBnICk37tkvyjby446VXMfe1c0-A34AUHU'
            }).then(function successCallback(response) {
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
        }
    }
}]);