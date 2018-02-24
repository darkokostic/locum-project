var LocumMyJobServices = angular.module('LocumMyJobServices', [])

LocumMyJobServices.factory('LocumMyJobService', function ($http, $q, toastr, $cookies, $rootScope) {
    return {
        allApplicatedJobs: function (userId) {
            var defer = $q.defer();
            $http({
                method: 'GET',
                url: 'api/v1/job/job-with-my-applications/' + userId
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        sendAmount: function (percId, amount) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'amount': amount,
                    'id': percId
                },
                url: 'api/v1/percentages'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        bookedJobs: function (searchTerm, job_start, job_end) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'practice_name': null,
                    'practice_city': null,
                    'job_start': job_start,
                    'job_end': job_end
                },
                url: 'api/v1/search/jobs/booked'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        searchBooked: function (searchTerm) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'practice_name': searchTerm.name,
                    'practice_city': searchTerm.city,
                    'job_start': searchTerm.dateFromToSearch,
                    'job_end': searchTerm.dateToToSearch
                },
                url: 'api/v1/search/jobs/booked'
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

        paginateBooked: function (url, searchTerm) {
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

        paginateCompleted: function (url, searchTerm) {
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

        completedJobs: function (searchTerm, job_start, job_end) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'practice_name': null,
                    'practice_city': null,
                    'job_start': job_start,
                    'job_end': job_end
                },
                url: 'api/v1/search/jobs/completed'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        searchCompleted: function (searchTerm) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'practice_name': searchTerm.name,
                    'practice_city': searchTerm.city,
                    'job_start': searchTerm.dateFromToSearch,
                    'job_end': searchTerm.dateToToSearch
                },
                url: 'api/v1/search/jobs/completed'
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
        getNextApplicationData: function (url) {
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
        giveFeedback: function (feedback) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'job_id': feedback.job_id,
                    'content': feedback.content,
                    'rating': feedback.rating
                },
                url: 'api/v1/feedback/create/' + $rootScope.currentUser.id
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