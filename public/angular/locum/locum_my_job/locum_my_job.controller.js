var LocumMyJobControllers = angular.module('LocumMyJobControllers', ['ngMessages']);

LocumMyJobControllers.controller('LocumMyJobController', ['$scope','LocumMyJobService','$location','$rootScope','PracticeMyDashboardService','toastr','$cookies','UserService','$log','$timeout', function($scope,LocumMyJobService,$location,$rootScope,PracticeMyDashboardService,toastr,$cookies,UserService,$log,$timeout) {
	UserService.currentUser().then((user) => {
        $rootScope.currentUser = user;
        $scope.allApplicatedJobs();
    });
	$scope.activeApplicationTab=true; 
	$scope.activeBookedTab=false;
	$scope.activeCompletedTab=false;
	$scope.applicatedJobs;	
	$scope.bookedJobs=[];
	$scope.bookedJobs.last_page=1;
	$scope.completedJobs=[];
	$scope.iterationLimit=1;
	$scope.jobDetails;
	$scope.jobForSearch=[];
	$scope.jobResults=[];
	$scope.allOtherApplications=[];
	$scope.nextPageExistApplication=false;
	$scope.nextPageUrlApp = null;
	$scope.emptyTable=false;
	$scope.ratePractice=[];
	$scope.$location = $location;
	$rootScope.activeClassesForMyJobs = ['active','','',''];
	$scope.UserService = UserService;
	$scope.searchFlag=false;
	$scope.disabledScroll=false;
	$scope.searchTerm=[];
	$scope.searchTerm.name='';
	$scope.searchTerm.city='';
	$scope.searchTermCompleted=[];
	$scope.searchTermCompleted.name='';
	$scope.searchTermCompleted.city='';
	$scope.booked=[];
	$scope.booked.maxSizeBooked = 0;
	$scope.booked.bigTotalItemsBooked = 0;
	$scope.booked.bigCurrentPageBooked = 0;
	$scope.completed=[];
	$scope.completed.maxSizeCompleted = 5;
	$scope.completed.bigTotalItemsCompleted = 0;
	$scope.completed.bigCurrentPageCompleted = 0;
	
	$scope.moment = function(date) {
        return moment(date);
    }

	$scope.pageChangedBooked = function() {
		var url=$scope.bookedJobs.next_page_url;
	   if($scope.bookedJobs.next_page_url==null) {
			url=$scope.bookedJobs.prev_page_url;
		}
		var numberToSlice =url;
		var number =numberToSlice.slice(-2);
		if(number>9) {
			var urlToReturn = url.slice(0, -2);
			urlToReturn=urlToReturn+$scope.booked.bigCurrentPageBooked;
	   		$scope.paginateBooked(urlToReturn)
		}else {
			var urlToReturn = url.slice(0, -1);
			urlToReturn=urlToReturn+$scope.booked.bigCurrentPageBooked;
	   		$scope.paginateBooked(urlToReturn)
		}
	};

	$scope.searchTerm=[];
	$scope.searchTerm.name='';
	$scope.searchTerm.city='';
	$rootScope.urlNow=1;
	if(!$scope.activeBookedTab) {
		var responseBooked = LocumMyJobService.bookedJobs(null,null,null);
		responseBooked.then(function(response) {
			$scope.disableSlideRight=true;
			$scope.bookedJobs=response.data.entity.data;
			$scope.bookedJobs.last_page=response.data.entity.last_page;
			$scope.bookedJobs.next_page_url=response.data.entity.next_page_url;
			$scope.bookedJobs.prev_page_url='';

			$scope.booked.maxSizeBooked = response.data.entity.per_page;
			$scope.booked.bigTotalItemsBooked = response.data.entity.total;
			$scope.booked.bigCurrentPageBooked = response.data.entity.current_page;
			for (var i = 0; i < $scope.bookedJobs.length; i++) {
				if($scope.bookedJobs[i].completed==1){
					$scope.bookedJobs[i].completed='completed';
				}
				else {
					$scope.bookedJobs[i].completed='uncompleted';
				}
			}
			var iterator=0;
			for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
				$scope.bookedJobs[iterator].number=i;
				iterator++;
			};
		},function(response){
		});
	}

	$scope.reloadBooked=function() {
		$scope.searchTerm=[];
		$scope.searchTerm.name='';
		$scope.searchTerm.city='';
		var responseBooked = LocumMyJobService.bookedJobs(null,null,null);
			responseBooked.then(function(response) {

			$scope.bookedJobs=response.data.entity.data;
			$scope.bookedJobs.last_page=response.data.entity.last_page;
			$scope.bookedJobs.next_page_url=response.data.entity.next_page_url;
			$scope.bookedJobs.prev_page_url='';

			$scope.booked.maxSizeBooked = response.data.entity.per_page;
			$scope.booked.bigTotalItemsBooked = response.data.entity.total;
			$scope.booked.bigCurrentPageBooked = response.data.entity.current_page;
			var iterator=0;
			for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
				$scope.bookedJobs[iterator].number=i;
				iterator++;
			};

			for (var i = 0; i < $scope.bookedJobs.length; i++) {
				if($scope.bookedJobs[i].completed==1){
					$scope.bookedJobs[i].completed='completed';
				}
				else {
					$scope.bookedJobs[i].completed='uncompleted';
				}
			}
			},function(response){
			});
	}

	$scope.searchBooked = function(searchTerm) {
		if(moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")<moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")||moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")==moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")){
			if(searchTerm.dateFromToSearch!=null && searchTerm.dateToToSearch!=null){
				var momentDateFrom=moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD");
		        var momentDateTo=moment(searchTerm.dateToToSearch).format("YYYY-MM-DD");
		        searchTerm.dateFromToSearch=momentDateFrom;
		        searchTerm.dateToToSearch=momentDateTo;
	    	}
			var responseBooked = LocumMyJobService.searchBooked(searchTerm);
			responseBooked.then(function(response) {

				$scope.bookedJobs=response.data.entity.data;
				$scope.bookedJobs.last_page=response.data.entity.last_page;
				$scope.bookedJobs.next_page_url=response.data.entity.next_page_url;
				$scope.bookedJobs.prev_page_url='';

				$scope.booked.maxSizeBooked = response.data.entity.per_page;
				$scope.booked.bigTotalItemsBooked = response.data.entity.total;
				$scope.booked.bigCurrentPageBooked = response.data.entity.current_page;

				var iterator=0;
				for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
					$scope.bookedJobs[iterator].number=i;
					iterator++;
				};

				for (var i = 0; i < $scope.bookedJobs.length; i++) {
					if($scope.bookedJobs[i].completed==1){
						$scope.bookedJobs[i].completed='completed';
					}
					else {
						$scope.bookedJobs[i].completed='uncompleted';
					}
				}
		},function(response){
			$scope.bookedJobs=[];
		});
		}else {
            toastr.warning("Job cannot start after it finishes");
        }
	}

	$scope.paginateBooked = function(url) {
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
		if(url!=null){
			var responseBooked = LocumMyJobService.paginateBooked(url,$scope.searchTerm);
			responseBooked.then(function(response) {
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
				$scope.bookedJobs=response.data.entity.data;
				$scope.bookedJobs.last_page=response.data.entity.last_page;
				$scope.bookedJobs.next_page_url=response.data.entity.next_page_url;
				$scope.bookedJobs.prev_page_url=response.data.entity.prev_page_url;

				$scope.booked.maxSizeBooked = response.data.entity.per_page;
				$scope.booked.bigTotalItemsBooked = response.data.entity.total;
				$scope.booked.bigCurrentPageBooked = response.data.entity.current_page;
				$rootScope.urlNow=$scope.url;

				for (var i = 0; i < $scope.bookedJobs.length; i++) {
					if($scope.bookedJobs[i].completed==1){
						$scope.bookedJobs[i].completed='completed';
					}
					else {
						$scope.bookedJobs[i].completed='uncompleted';
					}
				}
				var iterator=0;
				for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
					$scope.bookedJobs[iterator].number=i;
					iterator++;
				};

			},function(response){
			});
		}
	
	}

	$scope.pageChangedCompleted = function() {
		var url=$scope.completedJobs.next_page_url;
	   if($scope.completedJobs.next_page_url==null) {
			url=$scope.completedJobs.prev_page_url;
		}
		var numberToSlice =url;
		var number =numberToSlice.slice(-2);
		if(number>9) {
			var urlToReturn = url.slice(0, -2);
			urlToReturn=urlToReturn+$scope.completed.bigCurrentPageCompleted;
	   		$scope.paginateCompleted(urlToReturn)
		}else {
			var urlToReturn = url.slice(0, -1);
			urlToReturn=urlToReturn+$scope.completed.bigCurrentPageCompleted;
	   		$scope.paginateCompleted(urlToReturn)
		}
	};

	$rootScope.urlNow=1;
	$scope.searchTermCompleted=[];
	$scope.searchTermCompleted.name='';
	$scope.searchTermCompleted.city='';
	if (!$scope.activeCompletedTab) {
		var responseCompleted = LocumMyJobService.completedJobs(null,null,null);
		responseCompleted.then(function(response) {
			$scope.disableSlideRight=true;
			$scope.completedJobs=response.data.entity.data;
			$scope.completedJobs.last_page=response.data.entity.last_page;
			$scope.completedJobs.next_page_url=response.data.entity.next_page_url;
			$scope.completedJobs.prev_page_url='';

			$scope.completed.maxSizeCompleted = response.data.entity.per_page;
			$scope.completed.bigTotalItemsCompleted = response.data.entity.total;
			$scope.completed.bigCurrentPageCompleted = response.data.entity.current_page;

			var iterator=0;
			for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
				$scope.completedJobs[iterator].number=i;
				iterator++;
			};

			for (var i = 0; i < $scope.completedJobs.length; i++) {
				$scope.completedJobs[i].completed='completed';
			}

		},function(response){

		});
	};

	$scope.reloadCompleted=function() {
		$scope.searchTermCompleted=[];
		$scope.searchTermCompleted.name='';
		$scope.searchTermCompleted.city='';
		var responseCompleted = LocumMyJobService.completedJobs(null,null,null);
			responseCompleted.then(function(response) {

			$scope.completedJobs=response.data.entity.data;
			$scope.completedJobs.last_page=response.data.entity.last_page;
			$scope.completedJobs.next_page_url=response.data.entity.next_page_url;
			$scope.completedJobs.prev_page_url='';

			$scope.completed.maxSizeCompleted = response.data.entity.per_page;
			$scope.completed.bigTotalItemsCompleted = response.data.entity.total;
			$scope.completed.bigCurrentPageCompleted = response.data.entity.current_page;

			var iterator=0;
			for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
				$scope.completedJobs[iterator].number=i;
				iterator++;
			};

			for (var i = 0; i < $scope.completedJobs.length; i++) {
				$scope.completedJobs[i].completed='completed';
			}

			},function(response){
			});
	}

	$scope.searchCompleted = function(searchTerm) {
		if(moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")<moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")||moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")==moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")){
			if(searchTerm.dateFromToSearch!=null && searchTerm.dateToToSearch!=null){
				var momentDateFrom=moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD");
		        var momentDateTo=moment(searchTerm.dateToToSearch).format("YYYY-MM-DD");
		        searchTerm.dateFromToSearch=momentDateFrom;
		        searchTerm.dateToToSearch=momentDateTo;
	        }

			var responseCompleted = LocumMyJobService.searchCompleted(searchTerm);
			responseCompleted.then(function(response) {
				$scope.completedJobs=response.data.entity.data;
				$scope.completedJobs.last_page=response.data.entity.last_page;
				$scope.completedJobs.next_page_url=response.data.entity.next_page_url;
				$scope.completedJobs.prev_page_url='';

				$scope.completed.maxSizeCompleted = response.data.entity.per_page;
				$scope.completed.bigTotalItemsCompleted = response.data.entity.total;
				$scope.completed.bigCurrentPageCompleted = response.data.entity.current_page;

				var iterator=0;
				for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
					$scope.completedJobs[iterator].number=i;
					iterator++;
				};

				for (var i = 0; i < $scope.completedJobs.length; i++) {
						$scope.completedJobs[i].completed='completed';
					
				}
			},function(response){
				$scope.completedJobs=[];
			});
		}else {
            toastr.warning("Job cannot start after it finishes");
        }
	}

	$scope.paginateCompleted = function(url) {
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
		if(url!=null){
			var responseCompleted = LocumMyJobService.paginateCompleted(url,$scope.searchTermCompleted);
			responseCompleted.then(function(response) {
				if ($scope.disableSlideLeft==true) {
					$timeout(function() {
						$scope.disableSlideLeft=false;	
						$scope.disableSlideRight=true;
						$scope.disableSlideRightBack=false;
						$scope.disableSlideLeftBack=false;
					}, 1);
					
				}
				if($scope.disableSlideRightBack ==true) {
					$timeout(function() {
						$scope.disableSlideRight=false;
						$scope.disableSlideLeft=true;
						$scope.disableSlideRightBack=false;	
						$scope.disableSlideLeftBack=false;
					}, 1);
					
				}
				$scope.completedJobs=response.data.entity.data;
				$scope.completedJobs.last_page=response.data.entity.last_page;
				$scope.completedJobs.next_page_url=response.data.entity.next_page_url;
				$scope.completedJobs.prev_page_url=response.data.entity.prev_page_url;

				$scope.completed.maxSizeCompleted = response.data.entity.per_page;
				$scope.completed.bigTotalItemsCompleted = response.data.entity.total;
				$scope.completed.bigCurrentPageCompleted = response.data.entity.current_page;
				$rootScope.urlNow=$scope.url;

				var iterator=0;
				for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
					$scope.completedJobs[iterator].number=i;
					iterator++;
				};

				for (var i = 0; i < $scope.completedJobs.length; i++) {
					$scope.completedJobs[i].completed='completed';
				}
			},function(response){
			});
			}
		}
	
	$scope.giveFeedback = function() {
		LocumMyJobService.giveFeedback($scope.ratePractice);
		$scope.ratePractice=[];
		$scope.reloadCompleted();
	}

	$scope.redirectToJobDetails = function(job) {
		$cookies.put('jobDetailsId',job.id);
		$location.path('/locum/job_details');
	}

	$scope.viewPractice=function(practiceId){
		$cookies.put('practiceForViewId',JSON.stringify(practiceId));
		$location.path('/view_practice');
	}

	$scope.viewLocum=function(locumId){
		$cookies.put('locumForViewId',JSON.stringify(locumId));
		$location.path('/view_locum');
	}

	// Izvlacenje svih jobova na koje je user aplicirao
	$scope.showLoader=true;
	$scope.allApplicatedJobs = function(){
		$scope.showLoader=true;
			var responseUser = LocumMyJobService.allApplicatedJobs($rootScope.currentUser.id);
			responseUser.then(function(response){
				$scope.applicatedJobs=response.data.entity.data;
				for (var i = 0; i < $scope.applicatedJobs.length; i++) {
					if($scope.applicatedJobs[i].job.day_rate!=null) {
						$scope.applicatedJobs[i].job.day_rate=response.data.entity.data[i].job.day_rate.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					}
				}
				if(response.data.entity.next_page_url!=null) {
					$scope.nextPageUrlApp = response.data.entity.next_page_url;
					$scope.nextPageExistApplication=true;
				}else {
					$scope.nextPageExistApplication=false;
				}
				$scope.showLoader=false;
	  		},

	  		function(response){
	  			$scope.showLoader=false;
	  		});
	}

	$rootScope.tabPagesMyJobs = {
		page: 'applications'
	}

	$scope.getNextApplications=function(url){
		$scope.disabledScroll=true;
		PracticeMyDashboardService.getNextDashboardData(url).then(function(response){
			$scope.disabledScroll=false;
			$scope.nextPageUrlApp=response.data.entity.next_page_url;
			if(response.data.entity.next_page_url!=null) {
				$scope.nextPageExistApplication=true;
				$scope.applicatedJobs.next_page_url=response.data.entity.next_page_url;
			}else {
				$scope.nextPageExistApplication=false;
			}
			for (var i = 0; i<=response.data.entity.data.length-1; i++) {
				if(response.data.entity.data[i].job.day_rate!=null) {
					response.data.entity.data[i].job.day_rate=response.data.entity.data[i].job.day_rate.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
				}
				$scope.applicatedJobs.push(response.data.entity.data[i]);
			}
      	},
      	function(response){
      		$scope.disabledScroll=false;
      	});
	}

	$rootScope.clickToChangeActiveTabOnMyJobs = function (argument) {
		if (argument == 0) { 
			$cookies.put('activeTabJob', 'applications');
			$rootScope.activeClassesForMyJobs[0]='active';
			$rootScope.activeClassesForMyJobs[1]='';
			$rootScope.activeClassesForMyJobs[2]='';
			$rootScope.activeClassesForMyJobs[3]='';
			$rootScope.tabPagesMyJobs.page='applications';
		}else if(argument == 1){
			$cookies.put('activeTabJob', 'bookedJobs');
			$rootScope.activeClassesForMyJobs[1]='active';
			$rootScope.activeClassesForMyJobs[0]='';
			$rootScope.activeClassesForMyJobs[2]='';
			$rootScope.activeClassesForMyJobs[3]='';
			$rootScope.tabPagesMyJobs.page='bookedJobs';
		}else if(argument == 2){
			$cookies.put('activeTabJob', 'completed');
			$rootScope.activeClassesForMyJobs[2]='active';
			$rootScope.activeClassesForMyJobs[1]='';
			$rootScope.activeClassesForMyJobs[0]='';
			$rootScope.activeClassesForMyJobs[3]='';
			$rootScope.tabPagesMyJobs.page='completed';
		}
	}

	if($cookies.get('activeTabJob')=='applications'){
		$rootScope.clickToChangeActiveTabOnMyJobs(0);
    }else if($cookies.get('activeTabJob')=='bookedJobs'){
		$rootScope.clickToChangeActiveTabOnMyJobs(1);
    }else if($cookies.get('activeTabJob')=='completed'){
		$rootScope.clickToChangeActiveTabOnMyJobs(2);
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

    $scope.open3 = function() {
	    if($scope.popup3.opened==false){
	        $scope.popup3.opened = true;
	    }
	    else {
	        $scope.popup3.opened = false;
	    }
	};

	$scope.popup3 = {
	    opened: false
	};

	$scope.open4 = function() {
	    if($scope.popup4.opened==false){
	        $scope.popup4.opened = true;
	    }
	    else {
	        $scope.popup4.opened = false;
	    }
	};

	$scope.popup4 = {
	    opened: false
	};
}]);
