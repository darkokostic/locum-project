var BillingServices = angular.module('BillingServices', [])
BillingServices.factory('BillingService', ['$http', '$q', 'toastr', '$location', function ($http, $q, toastr, $location) {

    return {
        getBilling: function () {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'job_start': null,
                    'job_end': null,
                    'paid_status': null,
                    'practice_name': null
                },
                url: 'api/v1/user/invoice'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        paginate: function (url, searchTerm) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'job_start': null,
                    'job_end': null,
                    'paid_status': null,
                    'practice_name': null
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

        search: function (searchTerm) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'job_start': searchTerm.dateFromToSearch,
                    'job_end': searchTerm.dateToToSearch,
                    'paid_status': searchTerm.paid_status,
                    'practice_name': searchTerm.practice_name
                },
                url: 'api/v1/user/invoice/'
            }).then(function successCallback(response) {
                toastr.success(response.data.message);
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                toastr.warning(response.data.message);
                defer.reject(response);
            });
            return defer.promise;
        },

        requestPDF: function (invoiceId) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'id': invoiceId
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

        finishBill: function (bill) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {},
                url: 'api/v1/user/invoice/' + bill
            }).then(function successCallback(response) {
                toastr.success(response.data.message);
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                toastr.warning(response.data.message);
                defer.reject(response);
            });
            return defer.promise;
        }
    }
}]);