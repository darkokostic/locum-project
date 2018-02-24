var RegistrationLocumServices = angular.module('RegistrationLocumServices', [])
RegistrationLocumServices.factory('RegistrationLocumService', ['$http','$q','toastr','$cookies', function($http,$q,toastr,$cookies) {
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

        registerLocum: function(user){
            var defer = $q.defer();
        	$http({
            method: 'POST',
            data: {
                'name' :  user.name,
                'password' : user.password,
                'email' : user.email,
                'address1' :  user.address1,
                'address2' : user.address2,
                'city' : user.city,
                'province' :  user.province,
                'postal_code' : user.postal_code,
                'phone' : user.phone,
                'website' :  user.website,
                'graduated_year' : user.graduated_year,
                'day_rate' :  "200",
                'patient_booking_preference' : "Other",
                'lat' : user.lat,
                'lng' : user.lng,
                'role' : 'ROLE_USER',
                'radius' : "50",
                'visible' : true
            },
            url: 'api/v1/locum'
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
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        }
    }
}]);