var LocumProfileServices = angular.module('LocumProfileServices', []);
LocumProfileServices.factory('LocumProfileService', function($http,$q,toastr,$cookies) {

	return{
        updateLocum: function(user,$scope) {
        	$http({
            method: 'POST',
            data: {
                'name' :  user.name,
                'password' : user.password,
                'email' : user.email,
                'address1' :  user.address1,
                'address2' : user.address2,
                'overview' : user.overview,
                'city' : user.city,
                'province' :  user.province,
                'postal_code' : user.postal_code,
                'phone' : user.phone,
                'website' :  user.website,
                'linkedin' : user.linkedin,
                'graduated_year' : user.graduated_year,
                'day_rate' :  user.day_rate,
                'specialist_equipment' : user.specialist_equipment,
                'locum_specialty' : user.locum_specialty,
                'practice_management_system' :  user.practice_management_system,
                'lens_product_knowledge' : user.lens_product_knowledge,
                'contact_lens_specialty' : user.contact_lens_specialty,
                'average_full_exam_time' :  user.average_full_exam_time,
                'handover_between' : user.handover_between_dr_patient_dispenser,
                'patient_booking_preference' : user.patient_booking_preference,
                'avatar' : null,
                'lat' : user.lat,
                'lng' : user.lng,
                'role' : 'ROLE_USER',
                'radius' : user.radi,
                'visible' : user.visible
            },
            url: 'api/v1/locum/'+user.id
    	    }).then(function successCallback(response) {
                var currUser = {};
                toastr.success(response.data.message);
    	    }, function errorCallback(response) {
                toastr.warning(response.data.message);
    	  	});
        },

        getFeedback: function(userId){
            var defer = $q.defer();
            $http({
            method: 'GET',
            data:{
            },
            url: 'api/v1/feedback/locum/show/'+userId
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
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

        isTokenExpired: function(){
            var defer = $q.defer();
            $http({
            method: 'GET',
            data:{

            },
            url: 'api/v1/token/check'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },
         
        calendarPostLocum: function(from,to) {
            var defer = $q.defer();
            $http({
            method: 'POST',
            data:{
                'start_date' : from,
                'end_date' : to
            },
            url: 'api/v1/calendar'
            }).then(function successCallback(response) {
                defer.resolve(response);
                toastr.success(response.data.message);
                return response;
            }, function errorCallback(response) {
                toastr.warning(response.data.message);
                defer.reject(response);
            });
            return defer.promise;
        },

        calendarDeleteLocum: function(calendarId){
            var defer = $q.defer();
            $http({
            method: 'DELETE',
            url: 'api/v1/calendar/'+calendarId
            }).then(function successCallback(response) {
                toastr.success(response.data.message);
                return response;
            }, function errorCallback(response) {
                toastr.warning(response.data.message);
            });
            return defer.promise;
        },

        calendarGetPractice: function(userId) {
            var defer = $q.defer();
            $http({
            method: 'GET',
            data:{

            },
            url: 'api/v1/calendar/locum/'+userId
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        getAllJobs: function(requestSearch){
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'searchTerm' :  requestSearch.practiceName,
                    'job_start' : requestSearch.dateFrom,
                    'job_end' :  requestSearch.dateTo
                },
                url: 'api/v1/job/search-by-practice-name'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        getCalendars: function(){
            var defer = $q.defer();
            $http({
            method: 'POST',
            data:{
                'start_date' :null,
                'end_date' : null,
                'practice_name': null
            },
            url: 'api/v1/calendar/locum/filter'
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        calendarFilterLocumAvailability: function(searchTerm){
            var defer = $q.defer();
            $http({
            method: 'POST',
            data:{
                'start_date' : searchTerm.dateFromToSearch,
                'end_date' : searchTerm.dateToToSearch,
                'practice_name': searchTerm.practiceName
            },
            url: 'api/v1/calendar/locum/filter'
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
        
        calendarEditLocum: function(from,to,calId) {
            var defer = $q.defer();
            $http({
            method: 'PATCH',
            data:{
                'title': "available days",
                'desc': "job",
                'start_date' : from,
                'end_date' : to
            },
            url: 'api/v1/calendar/'+calId
            }).then(function successCallback(response) {
                defer.resolve(response);
                toastr.success("Successfully updated calendar");
                return response;
            }, function errorCallback(response) {
                toastr.warning("Error in update calendar");
                defer.reject(response);
            });
            return defer.promise;
        },

        applyForAJob: function(application){
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'job_id' :  application.job_id,
                    'desc': application.description
                },
                url: 'api/v1/application'
            }).then(function successCallback(response) {
                toastr.success("Successfully applied for a job");
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                toastr.warning("Time for application has run out");
                defer.reject(response);
            });
            return defer.promise;
        },

        liveSearch : function (name) {

            return $http({
                method: 'GET',

                url: 'api/v1/search/practice/'+name
            }).then(function successCallback(response) {
                    return response.data.entity.map(function(item){
                    return item.practice_name;
                });
            }, function errorCallback(response) {
                toastr.warning("Time for application has run out");
            });

        }
}
});