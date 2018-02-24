var JobDetailsControllers = angular.module('JobDetailsControllers', ['ngMessages']);

JobDetailsControllers.controller('JobDetailsController', ['$scope','JobDetailsService','$location','$rootScope','toastr','$cookies','UserService','LocumMyJobService','LocumFindAJobService', function($scope,JobDetailsService,$location,$rootScope,toastr,$cookies,UserService,LocumMyJobService,LocumFindAJobService) {

	$scope.jobDetails=[];
	$scope.allOtherApplications=[];
	$scope.application=[];
    $scope.jobForApplication = [];
	$scope.$location = $location;
	$scope.UserService = UserService;
	$scope.disabledApply=false;
    $scope.nextPageURL='';
    $scope.disabledScroll=false;
    $scope.showLoader = true;

 	var responseJobDetails = JobDetailsService.getJob($cookies.get('jobDetailsId'));
    responseJobDetails.then(function(response){
        if(response.data.entity.user_id){
            var responseWon=JobDetailsService.userWhoWon(response.data.entity.user_id);
            responseWon.then(function(response) {
                $scope.userWhoWon=response.data.entity;
            },function(response) {
            });
        }
        $scope.disabledScroll=true;
        $scope.jobDetails=response.data.entity;
        var responseAllOtherApplications = JobDetailsService.allOtherApplications($scope.jobDetails.id);
        responseAllOtherApplications.then(function(response){
            $scope.disabledScroll=false;
            $scope.nextPageURL=response.data.entity.next_page_url;
            $scope.allOtherApplications=response.data.entity.data;
        },
        function(response){
            $scope.disabledScroll=true;
        });
        $scope.showLoader = false;
    },
    function(response){
        $scope.showLoader = false;
    });

	$scope.check = function(percId,amount,index) {
	   var box= confirm("Send $"+amount+" for approval?");
	    if (box===true){   // yes sure
	    	var responseSent = LocumMyJobService.sendAmount(percId,amount);
	    	responseSent.then(function() {
	    		$scope.jobDetails.percentages[index].isSent=1;
	    	},function(response) {

	    	});
	        return true;
	    }
	  };

	$scope.paginate=function() {
        $scope.disabledScroll=true;
        JobDetailsService.paginate($scope.nextPageURL).then(function(response) {
            $scope.disabledScroll=false;
            $scope.nextPageURL=response.data.entity.next_page_url;
            for(var i=0;i<response.data.entity.data.length;i++){
                $scope.allOtherApplications.push(response.data.entity.data[i]);
            }

        },function(response){
            $scope.disabledScroll=false;

        });
    }

	$scope.checkForLength=function(number,index) {
		if(number!=null){
			if (number.toString().length >=9) {
				$scope.jobDetails.percentages[index].amount=number.toString().slice(0,-1);
				$scope.jobDetails.percentages[index].amount=parseInt($scope.jobDetails.percentages[index].amount);
	    	}
    	}
	}

	$scope.viewLocum=function(locumId){
		$cookies.put('locumForViewId',locumId);
		$location.path('/view_locum');
	}

	$scope.viewPractice=function(practiceId){
		$cookies.put('practiceForViewId',practiceId);
		$location.path('/view_practice');
	}

	$scope.applyForAJob=function(job_id) {
		$scope.disabledApply=true;
		$scope.jobForApplication.job_id=job_id;
		var responseApply = LocumFindAJobService.applyForAJob($scope.jobForApplication);
		responseApply.then(function(response){
            $scope.nextPageURL=response.data.entity.next_page_url;
            $scope.allOtherApplications.push(response.data.entity);
            $scope.jobDetails.isApplied=true;
		},function(response){

		});
		$scope.jobForApplication.description=null;
        $('#appJobModal').modal('hide');
	}
	
	$scope.moment = function(date) {
		return moment(date);
	}

}]);