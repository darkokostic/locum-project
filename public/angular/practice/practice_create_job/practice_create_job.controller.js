var PracticeCreateJobControllers = angular.module('PracticeCreateJobControllers', ['ngMessages'])

.controller('PracticeCreateJobController', ['$scope','PracticeCreateJobService','$location','UserService','toastr', function($scope,PracticeCreateJobService,$location,UserService,toastr) {
	$scope.newJob = [];
    $scope.newJob.application_start=null;
    $scope.arrayOfTime = [];
    $scope.$location = $location;
    $scope.UserService = UserService;
    $scope.dateOptions = {
        minDate: new Date()
    };

    $scope.requiredPayType={
        'percentage' : true,
        'day_rate' : true
    }

 	$(function() {
    	$('#datetimepicker5').datetimepicker({
    		format: 'LT'
    });

    $("#datetimepicker5").on("dp.change", function() {
        $scope.selecteddate = $("#working-time-from").val();
        $scope.newJob.working_time_from=$scope.selecteddate;
    });
 	});

 	$(function() {
    	$('#datetimepicker6').datetimepicker({
    		format: 'LT'
    });

    $("#datetimepicker6").on("dp.change", function() {
        $scope.selecteddate = $("#working-time-to").val();
        $scope.newJob.working_time_to=$scope.selecteddate;
    });

    $("#d5input").on("dp.change", function() {
        $scope.selecteddate = $("#working-time-to").val();
        $scope.newJob.working_time_to=$scope.selecteddate;
    });
    });  

    $scope.submitCreateAJob = function(data) {
        if(moment($scope.newJob.job_start).format("YYYY-MM-DD")<moment($scope.newJob.job_end).format("YYYY-MM-DD")||moment($scope.newJob.job_start).format("YYYY-MM-DD")==moment($scope.newJob.job_end).format("YYYY-MM-DD")){
            if(moment($scope.newJob.application_start).format("YYYY-MM-DD")<moment($scope.newJob.application_end).format("YYYY-MM-DD")||moment($scope.newJob.application_start).format("YYYY-MM-DD")==moment($scope.newJob.application_end).format("YYYY-MM-DD")){
                var momentDateFrom=moment($scope.newJob.job_start).format("YYYY-MM-DD");
                $scope.newJob.job_start=momentDateFrom;

                var momentDateTo=moment($scope.newJob.job_end).format("YYYY-MM-DD");
                $scope.newJob.job_end=momentDateTo;

                var momentDateAppTo=moment($scope.newJob.application_end).format("YYYY-MM-DD");
                $scope.newJob.application_end=momentDateAppTo;
                
                var momentDateAppFrom=moment($scope.newJob.application_start).format("YYYY-MM-DD");
                $scope.newJob.application_start=momentDateAppFrom;
                
                PracticeCreateJobService.createAJob($scope.newJob);
            }else {
                toastr.warning("Application cannot start after it finishes");
            }
        }else {
            toastr.warning("Job cannot start after it finishes");
        }
    };

    $scope.open2 = function() {
        if($scope.popup2.opened==false){
            $scope.popup2.opened = true;
        }
        else {
            $scope.popup2.opened = false;
        }
    };

    $scope.popup2 = {
        opened: false
    };

    $scope.open1 = function() {
        if($scope.popup1.opened==false){
            $scope.popup1.opened = true;
        }
        else {
            $scope.popup1.opened = false;
        }
    };

    $scope.popup1 = {
        opened: false
    };

    $scope.open5 = function() {
        if($scope.popup5.opened==false){
            $scope.popup5.opened = true;
        }
        else {
            $scope.popup5.opened = false;
        }
    };

    $scope.popup5 = {
        opened: false
    };

    $scope.open6 = function() {
        if($scope.popup6.opened==false){
            $scope.popup6.opened = true;
        }
        else {
            $scope.popup6.opened = false;
        }
    };

    $scope.popup6 = {
        opened: false
    };

    $scope.showDate5 = function() {
       $('#datetimepicker5 ').data("DateTimePicker").show();
    }
    
    $scope.showDate6 = function() {
       $('#datetimepicker6 ').data("DateTimePicker").show();
    }

}]);
