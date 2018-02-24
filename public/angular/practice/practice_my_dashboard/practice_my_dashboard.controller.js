var PracticeMyDashboardControllers = angular.module('PracticeMyDashboardControllers', ['ngMessages'])

.controller('PracticeMyDashboardController', ['$scope','PracticeMyDashboardService','$rootScope','$location','$cookies','UserService', function($scope,PracticeMyDashboardService,$rootScope,$location,$cookies,UserService) {
	UserService.currentUser().then((result) => {
    	$rootScope.currentUser = result;
    });
	$scope.dashboard = [];
	$scope.nextPageExist=false;
	$scope.nextPageExistDoctors=false;
	$scope.jobInfo=[];
	$scope.allOtherApplications=[];
	$scope.activeApplicationTabFeedback=true; 
	$scope.userWhoWon=[];
	$scope.jobDetails=[];
	$scope.nameOfDoctor='';
	$scope.userToSendMailId;
    $scope.$location = $location;
    $scope.UserService = UserService;
    $scope.nearestDoctor=[];
    $scope.disabledScroll=false;
    $scope.nextPageURL='';
    $scope.disabledScrollDoctors=false;
    $scope.isDisabled = false;
    $scope.showSpinner = false;
    $scope.haveActivity = true;
    $scope.showLoader=true;

	$scope.viewJobDetails = function(id) {
		$cookies.put('jobDetailsId',id);
		$location.path('/practice/job_details');
	}

	$scope.viewLocum=function(locumId){
		$rootScope.locumForViewId=locumId;
		$cookies.put('locumForViewId',JSON.stringify(locumId));
		$location.path('/view_locum');
	}

	function checkForUserWhoWonApplication(application,idUser) {
		for (var i = 0; i < application.length; i++) {
			if(idUser==application[i].user.id) {
				$scope.userWhoWon=application[i];
			}
		}
	}

	$scope.initDashboard=function(){
		var responseDashboard = PracticeMyDashboardService.getDashboardData();
		responseDashboard.then(function(response){
			for (var i = 0; i < response.data.activities.data.length; i++) {
			    var startDate = new Date(response.data.activities.data[i].job_start); 
				var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
				  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
				];
				var newStartDate = monthNames[startDate.getMonth()] + ", " + startDate.getDate() + ", " + startDate.getFullYear();
				response.data.activities.data[i].job_start = newStartDate;
				var endDate = new Date(response.data.activities.data[i].job_end); 
				var newEndDate = monthNames[endDate.getMonth()] + ", " + endDate.getDate() + ", " + endDate.getFullYear();
				response.data.activities.data[i].job_end = newEndDate;
			}
			$scope.dashboard=response.data;
			if(response.data.activities.next_page_url!=null) {
				$scope.nextPageExist=true;
			}else {
				$scope.nextPageExist=false;
			}
			$scope.showLoader=false;
      	},
      	function(response){
      		$scope.showLoader=false;
      	});
	}

	$scope.setJobInfo=function(activity) {
		$scope.jobInfo=activity;
	}

	$scope.getNextDashboardData=function(url){
    	$scope.disabledScroll=true;
		var responseDashboard = PracticeMyDashboardService.getNextDashboardData(url);
		responseDashboard.then(function(response){
    	$scope.disabledScroll=false;
			$scope.dashboard.activities.data=$scope.dashboard.activities.data.concat(response.data.activities.data);
			if(response.data.activities.next_page_url!=null) {
				$scope.nextPageExist=true;
				$scope.dashboard.activities.next_page_url=response.data.activities.next_page_url;
			}else {
				$scope.nextPageExist=false;
			}
      	},
      	function(response){
    	$scope.disabledScroll=false;
      	});
	}

	$scope.changeToCreateJob = function() {
		$location.path('/practice/practice_create_job');
	}

	var responseNearestDoctors = PracticeMyDashboardService.getNearestDoctors();
	responseNearestDoctors.then(function(response){
		$scope.nearestDoctors=response.data.entity.data;

		if(response.data.entity.next_page_url!=null){
			$scope.nextPageExistDoctors=true;
			$scope.nextPageURL=response.data.entity.next_page_url;
		}else {
			$scope.nextPageExistDoctors=false;
		}
  	},
  	function(response){
  	});

  	$scope.getMoreDoctors = function() {
    	$scope.disabledScrollDoctors=true;
  		var responseNearestDoctors = PracticeMyDashboardService.paginate($scope.nextPageURL);
		responseNearestDoctors.then(function(response){
    		$scope.disabledScrollDoctors=false;
    		for (var i = 0; i < response.data.entity.data.length; i++) {
    			$scope.nearestDoctors.push(response.data.entity.data[i]);
    		}
    		
    		if(response.data.entity.next_page_url!=null){
				$scope.nextPageExistDoctors=true;
				$scope.nextPageURL=response.data.entity.next_page_url;
    		}else {
				$scope.nextPageExistDoctors=false;
    		}
	  	},
	  	function(response){
    		$scope.disabledScrollDoctors=false;
	  	});
  	}

  	$scope.nearestDoctorId = function(doctor) {
  		$scope.id=doctor.id;
  		$scope.nameOfDoctor=doctor.name
  	}

	$scope.activeApplication = function(userId) {
		$scope.userToSendMailId=userId;
	}

	$scope.acceptAndSendMail = function(nearestDoctor) {
		PracticeMyDashboardService.acceptApplication($scope.userToSendMailId,$scope.jobDetails.id).then(function(response) {
  			$('#myModal2').modal('hide');
	    },
	  	function(response){
	  	});
	  	PracticeMyDashboardService.sendMailPracticePost(nearestDoctor,$scope.id).then(function(response) {
  			$('#myModal2').modal('hide');
	    },
	  	function(response){
	  	});
	}

  	$scope.sendMailPractice = function(nearestDoctor) {
  		$scope.isDisabled = true;
  		$scope.showSpinner = true;
  		PracticeMyDashboardService.sendMailPracticePost(nearestDoctor,$scope.id).then(function(response) {
  			$('#myModal').modal('hide');
  			$scope.nearestDoctor=[];
  			$scope.isDisabled = false;
  			$scope.showSpinner = false;
	    },
	  	function(response){
	  		$scope.isDisabled = false;
	  		$scope.nearestDoctor=[];
	  		$scope.showSpinner = false;
	  	});
  	}

}]);