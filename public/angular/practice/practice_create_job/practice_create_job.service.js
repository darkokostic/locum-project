var PracticeCreateJobServices = angular.module('PracticeCreateJobServices', [])
PracticeCreateJobServices.factory('PracticeCreateJobService', ['$http','$q','toastr','$location', function($http,$q,toastr,$location) {
	return{
        createAJob: function(newJob){
        	$http({
            method: 'POST',
            data: {
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
            url: 'api/v1/job'
    	    }).then(function successCallback(response) {
                $location.path('/practice/practice_all_jobs');
                toastr.success(response.data.message);
    	    }, function errorCallback(response) {
                toastr.warning(response.data.message);
    	  	});
        }
	}
}]);