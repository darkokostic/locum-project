var PracticeProfileServices = angular.module('PracticeProfileServices', [])
PracticeProfileServices.factory('PracticeProfileService', ['$http', '$q', 'toastr', '$cookies', function($http, $q, toastr, $cookies) {
    return {
        updatePractice: function(practice, $scope) {
            $http({
                method: 'POST',
                data: {
                    'practice_name': practice.practice_name,
                    'practice_email': practice.practice_email,
                    'practice_address1': practice.practice_address1,
                    'practice_address2': practice.practice_address2,
                    'practice_city': practice.practice_city,
                    'practice_province': practice.practice_province,
                    'practice_postal_code': practice.practice_postal_code,
                    'practice_phone': practice.practice_phone,
                    'practice_website': practice.practice_website,
                    'practice_facebook': practice.practice_facebook,
                    'day_rate': practice.day_rate,
                    'specialist_equipment': practice.specialist_equipment,
                    'pretest_equipment': practice.pretest_equipment,
                    'experience_requirement': practice.experience_requirement,
                    'practice_specialty': practice.practice_specialty,
                    'practice_management_system': practice.practice_management_system,
                    'lens_product_affiliation': practice.lens_product_affiliation,
                    'contact_lens_specialty': practice.contact_lens_specialty,
                    'average_full_exam_time': practice.average_full_exam_time,
                    'no_of_exam_lanes': practice.no_of_exam_lanes,
                    'no_of_staff': practice.no_of_staff,
                    'sq_ft': practice.sq_ft,
                    'handover_between': practice.handover_between,
                    'patient_booking_preference': practice.patient_booking_preference,
                    'avatar': null,
                    'overview': practice.overview,
                    'lat': practice.lat,
                    'lng': practice.lng,
                    'radius': 'dada',
                    'practice_visible': practice.practice_visible
                },
                url: 'api/v1/practice/'+practice.id
            }).then(function successCallback(response) {
                var currUser = {};
                toastr.success("Successfully edited practice");
            }, function errorCallback(response) {
                toastr.warning("One or more fields are invalid");
            });
        },
        editAJob: function(newJob){
            console.log(newJob)
            var defer = $q.defer();
                $http({
                method: 'PATCH',
                data: {
                    'practice_id' : newJob.practice_id,
                    'user_id' : newJob.user_id,
                    'title' :  newJob.title,
                    'desc' : newJob.desc,
                    'day_rate' : newJob.day_rate,
                    'percentage': newJob.percentage,
                    'application_start' : newJob.application_start,
                    'application_end' :  newJob.application_end,
                    'job_start' : newJob.job_start,
                    'job_end' : newJob.job_end,
                    'working_time_from' :  newJob.working_time_from,
                    'working_time_to' : newJob.working_time_to
                },
                url: 'api/v1/job/'+newJob.id
                }).then(function successCallback(response) {
                    defer.resolve(response);
                    console.log(response)
                    toastr.success(response.data.message);
                    return response;
                }, function errorCallback(response) {
                    defer.reject(response);
                    console.log(response)
                    toastr.warning(response.data.message);
                });
            return defer.promise;
        },

        getFeedback: function(practiceId) {
            var defer = $q.defer();
            $http({
                method: 'GET',
                data: {},
                url: 'api/v1/feedback/practice/show/' + practiceId
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
                url: 'api/v1/job/with-applications/' + jobId
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        calendarGetPractice: function(userId) {
            var defer = $q.defer();
            $http({
                method: 'GET',
                data: {},
                url: 'api/v1/calendar/locum/' + userId
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        getCalendar: function() {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'start_date': null,
                    'end_date': null,
                    'locum_name': null
                },
                url: 'api/v1/calendar/practice/filter'
            }).then(function successCallback(response) {
                defer.resolve(response);
                console.log(response)
                if (response.data.entity.locums.length == 0) {
                    toastr.warning("No locums for this search");
                } else {
                    toastr.success("Successfully get locums");
                }
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
                toastr.warning(response.data.message);
            });
            return defer.promise;
        },

        calendarFilterPracticeAvailability: function(dateFromOrTo) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'start_date': dateFromOrTo.dateFromFind,
                    'end_date': dateFromOrTo.dateFromTo,
                    'locum_name': dateFromOrTo.searchByPracticeName
                },
                url: 'api/v1/calendar/practice/filter'
            }).then(function successCallback(response) {
                defer.resolve(response);
                toastr.success("Successfully get calendars");
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
                toastr.warning(response.data.message);
            });
            return defer.promise;
        },

        search : function(searchTerm) {
            var defer = $q.defer();
            $http({
            method: 'POST',
            data:{
                'start_date' : searchTerm.dateFromToSearch,
                'end_date' : searchTerm.dateToToSearch,
                'locum_name': searchTerm.locumName
            },
            url: 'api/v1/calendar/practice/filter'
            }).then(function successCallback(response) {
                defer.resolve(response);
                console.log(response)
                toastr.success("Successfully get calendars");
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
                toastr.warning(response.data.message);
            });
            return defer.promise;
        },

        liveSearch : function (name) {
            return $http({
                method: 'GET',
                url: 'api/v1/search/locum/'+name
            }).then(function successCallback(response) {
                return response.data.entity.map(function(item){
                    return item.name;
                });
            }, function errorCallback(response) {
                toastr.warning("Time for application has run out");
            });
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
    }
}]);