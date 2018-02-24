var PracticeProfileControllers = angular.module('PracticeAllJobsControllers', ['ngFileUpload'])
.controller('PracticeAllJobsController', ['PracticeAllJobsService','$scope','$location','toastr','PracticeMyDashboardService','UserService','$rootScope','$cookies', function(PracticeAllJobsService,$scope,$location,toastr,PracticeMyDashboardService,UserService,$rootScope,$cookies) {
	
	$scope.allJobs = [];
	$scope.activeApplicationTabJobs=true;
	$scope.allOtherApplications=[];
	$scope.jobDetails=[];
	$scope.userWhoWon;
	$scope.$location = $location;
	$scope.UserService = UserService;
	$scope.disableForSearch=false;
	$scope.searchTerm=[];
	$scope.jobs = [];
	$scope.jobs.maxSizeAllJobs = 0;
	$scope.jobs.bigTotalItemsAllJobs = 0;
	$scope.jobs.bigCurrentPageAllJobs = 0;
	$scope.showLoader = true;
	UserService.currentUser().then((result) => {
    	$rootScope.currentUser = result;
    });

	$scope.viewJobDetails = function(id) {
		$cookies.put('jobDetailsId',id);
		$location.path('/practice/job_details');
	}

	$scope.viewLocum=function(locumId){
		$rootScope.locumForViewId=locumId;
		$cookies.put('locumForViewId',JSON.stringify(locumId));
		$location.path('/view_locum');
	}

	$scope.initAllJobs = function() {
		$scope.searchTerm=[];
		var responseAllJobs = PracticeAllJobsService.getAllJobs();
		responseAllJobs.then(function(response){
			$rootScope.urlNow=1;
			$scope.allJobs = response.data.entity.data;
			$scope.allJobs.last_page=response.data.entity.last_page;
			$scope.allJobs.next_page_url=response.data.entity.next_page_url;
			$scope.allJobs.prev_page_url=response.data.entity.prev_page_url;

			$scope.jobs.maxSizeAllJobs = response.data.entity.per_page;
			$scope.jobs.bigTotalItemsAllJobs = response.data.entity.total;
			$scope.jobs.bigCurrentPageAllJobs = response.data.entity.current_page;

			for (var i = response.data.entity.from; i <= response.data.entity.to; i++) {
				$scope.allJobs[i-1].index=i;
			};
			for (var i = 0; i <= response.data.entity.data.length -1; i++) {
				if ($scope.allJobs[i].completed) {
					$scope.allJobs[i].completed = 'Completed';
				}
				else if (!$scope.allJobs[i].completed) {
					$scope.allJobs[i].completed = 'Uncompleted';
				};
			}
			$scope.showLoader = false;
      	},
      	function(response){
			$scope.allJobs = [];
			$scope.showLoader = false;
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
  			$('#myModal').modal('hide');
	    },
	  	function(response){
	  	});
	  	PracticeMyDashboardService.sendMailPracticePost(nearestDoctor,$scope.id).then(function(response) {
  			$('#myModal').modal('hide');
	    },
	  	function(response){
	  	});
	}

  	$scope.searchAllJobs = function(searchTerm) {
  		if(moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")<moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")||moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")==moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")){
	  		if(searchTerm.dateFromToSearch!=null && searchTerm.dateToToSearch!=null){
				var momentDateFrom=moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD");
		        var momentDateTo=moment(searchTerm.dateToToSearch).format("YYYY-MM-DD");
		        searchTerm.dateFromToSearch=momentDateFrom;
		        searchTerm.dateToToSearch=momentDateTo;
	    	}
	  		$scope.disableForSearch=true;
			var responseSearchAllJobs = PracticeAllJobsService.searchAllJobs(searchTerm);
				responseSearchAllJobs.then(function(response){
					$scope.searchTerm=[];
					$scope.disableForSearch=false;
					$scope.allJobs = response.data.entity.data;
					$scope.allJobs.last_page=response.data.entity.last_page;
					$scope.allJobs.next_page_url=response.data.entity.next_page_url;
					$scope.allJobs.prev_page_url=response.data.entity.prev_page_url;

					$scope.jobs.maxSizeAllJobs = response.data.entity.per_page;
					$scope.jobs.bigTotalItemsAllJobs = response.data.entity.total;
					$scope.jobs.bigCurrentPageAllJobs = response.data.entity.current_page;
					if (!response.data.entity.data[0]) {
						toastr.warning('No Results');
						$scope.jobResults = true;
					}
					else {
						toastr.success('Successfully get jobs!');
						$scope.jobResults = false;
					}
					for (var i = 0; i <= response.data.entity.data.length -1; i++) {
						if ($scope.allJobs[i].completed) {
							$scope.allJobs[i].completed = 'Completed';
						}
						else if (!$scope.allJobs[i].completed) {
							$scope.allJobs[i].completed = 'Uncompleted';
						};
					}
					var iterator=0;
					for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
						$scope.allJobs[iterator].index=i;
						iterator++;
					};
		      	},
		      	function(response){
					$scope.allJobs = [];
					$scope.disableForSearch=false;
		      	});
      	}else {
            toastr.warning("Job cannot start after it finishes");
        }
  	}

  	$scope.pageChangedAllJobs = function() {
		var url=$scope.allJobs.next_page_url;
	   if($scope.allJobs.next_page_url==null) {
			url=$scope.allJobs.prev_page_url;
		}
		var numberToSlice =url;
		var number =numberToSlice.slice(-2);
		if(number>9) {
			var urlToReturn = url.slice(0, -2);
			urlToReturn=urlToReturn+$scope.jobs.bigCurrentPageAllJobs;
	   		$scope.paginateAllJobs(urlToReturn)
		}else {
			var urlToReturn = url.slice(0, -1);
			urlToReturn=urlToReturn+$scope.jobs.bigCurrentPageAllJobs;
	   		$scope.paginateAllJobs(urlToReturn)
		}
	};

  	$scope.paginateAllJobs = function(url) {
  		$scope.url = url.split("=")[1];
		$scope.url=parseInt($scope.url);
		if ($scope.url > $rootScope.urlNow) {
			$scope.disableSlideLeft=true;	
			$scope.disableSlideRight=false;
			$scope.disableSlideRightBack=false;
			$scope.disableSlideLeftBack=true;
		};
		if($scope.url < $rootScope.urlNow) {
			$scope.disableSlideLeft=false;	
			$scope.disableSlideRight=false;
			$scope.disableSlideRightBack=true;
			$scope.disableSlideLeftBack=false;
		}
		var responseAllJobs = PracticeAllJobsService.paginateAllJobs(url,$scope.searchTerm);
		responseAllJobs.then(function(response) {
			$scope.allJobs=response.data.entity.data;

			for (var i = 0; i <=response.data.entity.data.length-1; i++) {
				if ($scope.allJobs[i].completed) {
					$scope.allJobs[i].completed = 'Completed';
				}
				else if (!$scope.allJobs[i].completed) {
					$scope.allJobs[i].completed = 'Uncompleted';
				};
			}
			if ($scope.disableSlideLeft==true) {
					$scope.disableSlideLeft=false;	
					$scope.disableSlideRight=true;
					$scope.disableSlideRightBack=false;
					$scope.disableSlideLeftBack=false;					
				}
				if($scope.disableSlideRightBack ==true) {
					$scope.disableSlideRight=false;
					$scope.disableSlideLeft=true;
					$scope.disableSlideRightBack=false;	
					$scope.disableSlideLeftBack=false;
				}
			$scope.allJobs.last_page=response.data.entity.last_page;
			$scope.allJobs.next_page_url=response.data.entity.next_page_url;
			$scope.allJobs.prev_page_url=response.data.entity.prev_page_url;

			$scope.jobs.maxSizeAllJobs = response.data.entity.per_page;
			$scope.jobs.bigTotalItemsAllJobs = response.data.entity.total;
			$scope.jobs.bigCurrentPageAllJobs = response.data.entity.current_page;
			$rootScope.urlNow=$scope.url;

			var iterator=0;
			for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
				$scope.allJobs[iterator].index=i;
				iterator++;
			};

		},function(response){
		});
	}

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

    $scope.moment = function(date) {
        return moment(date);
    }
}]);

