var PracticeBillingServices = angular.module('PracticeBillingServices', [])
PracticeBillingServices.factory('PracticeBillingService', function($http,$q,toastr) {

	return{
		getBilling: function(){
            var defer = $q.defer();
        	$http({
            method: 'POST',
            url: 'api/v1/invoice/practice'
    	    }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
    	    }, function errorCallback(response) {
                defer.reject(response);
    	  	});
            return defer.promise;
        },

        requestPDF: function(invoiceId){
            var defer = $q.defer();
            $http({
            method: 'POST',
            data:{
                'id':invoiceId
            },
            url: 'api/v1/storage/invoice'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },
        paginate: function(url,searchTerm){
            
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

        search: function(searchTerm){
            var defer = $q.defer();
            $http({
            method: 'POST',
            data: {
                'job_start':searchTerm.dateFromToSearch,
                'job_end':searchTerm.dateToToSearch,
                'paid_status':searchTerm.paid_status,
                'locum_name':searchTerm.locum_name
            },
            url: 'api/v1/invoice/practice/'
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