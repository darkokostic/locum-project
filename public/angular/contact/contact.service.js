var ContactServices = angular.module('ContactServices', [])
ContactServices.factory('ContactService', function($http,$q,toastr) {
	return {
        sendContactForm: function(data) {
	        var defer = $q.defer();
	        $http({
	        method: 'POST',
	        data: {
	        	'user': data
	        },
	        url: 'api/v1/contact/mail'
	        }).then(function successCallback(response) {
	            defer.resolve(response);
	            toastr.success('Email sent!');
	            return response;
	        }, function errorCallback(response) {
	        	toastr.warning('Email not sent, try again!');
	            defer.reject(response);
	        });
	        return defer.promise;
	    },
    }
});