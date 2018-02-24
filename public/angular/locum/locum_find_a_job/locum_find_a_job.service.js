var LocumFindAJobServices = angular.module('LocumFindAJobServices', [])
LocumFindAJobServices.factory('LocumFindAJobService', function ($http, $q, toastr) {

    return {
        getJobs: function () {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'searchTerm': null,
                    'job_start': null,
                    'job_end': null
                },
                url: 'api/v1/search/jobs/findJob'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        searchJobs: function (requestSearch) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'practice_name': requestSearch.name,
                    'practice_city': requestSearch.city,
                    'job_start': requestSearch.dateFromToSearch,
                    'job_end': requestSearch.dateToToSearch
                },
                url: 'api/v1/search/jobs/findJob'
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

        paginate: function (url, searchTerm) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'practice_name': searchTerm.name,
                    'practice_city': searchTerm.city,
                    'job_start': searchTerm.dateFromToSearch,
                    'job_end': searchTerm.dateToToSearch
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

        allOtherApplications: function (jobId) {
            var defer = $q.defer();
            $http({
                method: 'GET',
                url: 'api/v1/job/with-applications/' + jobId
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        applyForAJob: function (application) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'job_id': application.job_id,
                    'desc': application.description
                },
                url: 'api/v1/application'
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
});