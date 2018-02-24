var LocumFindAJobControllers = angular.module('LocumFindAJobControllers', []);

LocumFindAJobControllers.controller('LocumFindAJobController', ['$scope','LocumFindAJobService','$location','$rootScope','toastr','$cookies','UserService','$timeout','$routeParams', function($scope,LocumFindAJobService,$location,$rootScope,toastr,$cookies,UserService,$timeout,$routeParams) {

	$scope.jobForSearch=[];
	$scope.jobResults=[];
	$scope.result="Search results";
	$scope.message="";
	$scope.jobDetails;
	$scope.activeApplicationTab=true;
	$scope.allOtherApplications=[];
	$scope.emptyTable = false;
	$scope.application=[];
	$scope.jobForApplication=[];
	$scope.$location = $location;
	$scope.UserService = UserService;
	$scope.searchFlag=false;
	$scope.searchTerm=[];
	$scope.searchTerm.name='';
	$scope.searchTerm.city='';
	$scope.disableSlideRight=true;
	$scope.disableSlideLeft=false;
	$scope.job=[];
	$scope.jobResults.number=0;
	$scope.job.maxSizeJob = 0;
	$scope.job.bigTotalItemsJob = 0;
	$scope.job.bigCurrentPageJob = 0;
	$scope.disableSlideRightBack = false;
	$scope.disableSlideLeftBack = false;
	$scope.showLoader = true;

	$scope.getNumber = function(num) {
	    return new Array(num);   
	}

	$scope.pageChangedJob = function() {	
		var url=$scope.jobResults.next_page_url;
	   	if($scope.jobResults.next_page_url==null) {
			url=$scope.jobResults.prev_page_url;
		}
		var numberToSlice =url;
		var number =numberToSlice.slice(-2);
		if(number>9) {
			var urlToReturn = url.slice(0, -2);
			urlToReturn=urlToReturn+$scope.job.bigCurrentPageJob;
	   		$scope.paginate(urlToReturn)
		}else {
			var urlToReturn = url.slice(0, -1);
			urlToReturn=urlToReturn+$scope.job.bigCurrentPageJob;
	   		$scope.paginate(urlToReturn)
		}
	};

	var response = LocumFindAJobService.getJobs();
	response.then(function(response) {
		$rootScope.urlNow=1;
		$scope.disableSlide=false;
		$scope.jobResults=response.data.entity.data;
		for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
			$scope.jobResults[i-1].number=i;
		};
		
		$scope.jobResults.last_page=response.data.entity.last_page;
		$scope.jobResults.next_page_url=response.data.entity.next_page_url;
		$scope.jobResults.prev_page_url='';

		$scope.job.maxSizeJob = response.data.entity.per_page;
		$scope.job.bigTotalItemsJob = response.data.entity.total;
		$scope.job.bigCurrentPageJob = response.data.entity.current_page;
		$scope.showLoader = false;
	},function(response){
		$scope.showLoader = false;
	});

	$scope.reload=function() {
		$scope.disableSlideRight=false;
		$scope.searchTerm=[];
		$scope.searchTerm.name='';
		$scope.searchTerm.city='';
		var response = LocumFindAJobService.getJobs();
			response.then(function(response) {
			$scope.disableSlideRight=true;

			$scope.jobResults=response.data.entity.data;
			$scope.jobResults.last_page=response.data.entity.last_page;
			$scope.jobResults.next_page_url=response.data.entity.next_page_url;

			$scope.job.maxSizeJob = response.data.entity.per_page;
			$scope.job.bigTotalItemsJob = response.data.entity.total;
			$scope.job.bigCurrentPageJob = response.data.entity.current_page;

			var iterator=0;
			for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
				$scope.jobResults[iterator].number=i;
				iterator++;
			};

			},function(response){

			});
	}

	$scope.search = function(searchTerm) {
		if(moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")<moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")||moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")==moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")){
			if(searchTerm.dateFromToSearch!=null && searchTerm.dateToToSearch!=null){
				var momentDateFrom=moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD");
		        var momentDateTo=moment(searchTerm.dateToToSearch).format("YYYY-MM-DD");
		        searchTerm.dateFromToSearch=momentDateFrom;
		        searchTerm.dateToToSearch=momentDateTo;
	    	}
			var responseBooked = LocumFindAJobService.searchJobs(searchTerm);
			responseBooked.then(function(response) {

				$scope.jobResults=response.data.entity.data;
				$scope.jobResults.last_page=response.data.entity.last_page;
				$scope.jobResults.next_page_url=response.data.entity.next_page_url;
				$scope.jobResults.prev_page_url='';

				$scope.job.maxSizeJob = response.data.entity.per_page;
				$scope.job.bigTotalItemsJob = response.data.entity.total;
				$scope.job.bigCurrentPageJob = response.data.entity.current_page;
				var iterator=0;
	        	for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
					$scope.jobResults[iterator].number=i;
					iterator++;
				};

		},function(response){
			$scope.searchTerm=[];
			$scope.jobResults=[];
		});
		}else {
            toastr.warning("Job cannot start after it finishes");
        }
	}

	$scope.paginate = function(url) {
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
				var response = LocumFindAJobService.paginate(url,$scope.searchTerm);
				response.then(function(response) {
					if ($scope.disableSlideLeft==true) {
						$timeout(function() {
							$scope.disableSlideLeft=false;	
							$scope.disableSlideRight=true;
							$scope.disableSlideRightBack=false;
							$scope.disableSlideLeftBack=false;
						}, 100);
						
					}
					if($scope.disableSlideRightBack ==true) {
						$timeout(function() {
							$scope.disableSlideRight=false;
							$scope.disableSlideLeft=true;
							$scope.disableSlideRightBack=false;	
							$scope.disableSlideLeftBack=false;
						}, 100);
					}
					
					$scope.jobResults=response.data.entity.data;
					$scope.jobResults.last_page=response.data.entity.last_page;
					$scope.jobResults.next_page_url=response.data.entity.next_page_url;
					$scope.jobResults.prev_page_url=response.data.entity.prev_page_url;

					$scope.job.maxSizeJob = response.data.entity.per_page;
					$scope.job.bigTotalItemsJob = response.data.entity.total;
					$scope.job.bigCurrentPageJob = response.data.entity.current_page;
					$rootScope.urlNow=$scope.url;
					var iterator = 0;
					for (var i = response.data.entity.from; i <=response.data.entity.to; i++) {
						$scope.jobResults[iterator].number=i;
						iterator++;
					};
			},function(response){
			});
			}
		}

	$scope.redirectToJobDetails = function(job) {
		$cookies.put('jobDetailsId',job.id);
		$location.path('/locum/job_details');
	}
	
	$scope.applyForAJob=function(job_id) {
		$scope.jobForApplication.job_id=job_id;
		LocumFindAJobService.applyForAJob($scope.jobForApplication);
		$scope.jobForApplication.description=null;
        $('#appJobModal').modal('hide');
	}
	$scope.viewLocum=function(locumId){
		$cookies.put('locumForViewId',JSON.stringify(locumId));
		$location.path('/view_locum');
	}

	$scope.viewPractice=function(practiceId){
		$cookies.put('practiceForViewId',JSON.stringify(practiceId));
		$location.path('/view_practice');
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