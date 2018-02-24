var ViewPracticeControllers = angular.module('ViewPracticeControllers', [])

.controller('ViewPracticeController', ['$scope','ViewPracticeService','$location','$route','$rootScope','$cookies','$window','$templateCache','UserService', function($scope,ViewPracticeService,$location,$route,$rootScope,$cookies,$window,$templateCache,UserService) {
	UserService.currentUser().then((user) => {
    	$scope.LoggedUser = user;
	})
	$scope.currentUser=[];
	$scope.specialistEquipment=[];
	$scope.practiceSpecialty=[];
	$scope.practiceManagementSystem=[];
	$scope.lensProductAffiliation=[];
	$scope.contactLensSpecialty=[]; 
	$scope.avgExamTime=[]; 
	$scope.answer=[]; 
	$scope.patientBookingPreference=[]; 
	$scope.pretestEquipment=[];
	$scope.experienceRequirements=[];
	$scope.feedbacks=[];
	$scope.activeApplicationTabFeedback=true; 
	$scope.jobDetails=[];
	$scope.allOtherApplications=[];
	$scope.userWhoWon=[];
	$scope.feedback = [];
	$scope.feedback.maxSizeFeedback = 0;
	$scope.feedback.bigTotalItemsFeedback = 0;
	$scope.feedback.bigCurrentPageFeedback = 0;
    $scope.nextPageURL='';
    $scope.disabledScroll=false;
	$scope.isProfileActive=true;
	$scope.UserService = UserService;

	$scope.changePageView = function(jobDetails) {
		$scope.jobDetails=jobDetails;
		if($scope.activeApplicationTabFeedback==true){
			if(jobDetails.user_id){
	            var responseWon=ViewPracticeService.userWhoWon(jobDetails.user_id);
	            responseWon.then(function(response) {
	                $scope.userWhoWon=response.data.entity;
	            },function(response) {
	            });
        	}
        	$scope.disabledScroll=true;
	        var responseAllOtherApplications = ViewPracticeService.allOtherApplications(jobDetails.id);
	        responseAllOtherApplications.then(function(response){
	            $scope.disabledScroll=false;
	            $scope.nextPageURL=response.data.entity.next_page_url;
	            $scope.allOtherApplications=response.data.entity.data;
	        },
	        function(response){
	            $scope.disabledScroll=true;
	        });
				$scope.activeApplicationTabFeedback=false;
			}
		else{
			$scope.activeApplicationTabFeedback=true;
		}
	}

	$scope.paginate=function(nextPageURL) {
        $scope.disabledScroll=true;
        ViewPracticeService.paginate($scope.nextPageURL).then(function(response) {
            $scope.disabledScroll=false;
            $scope.nextPageURL=response.data.entity.next_page_url;
            for(var i=0;i<response.data.entity.data.length;i++){
                $scope.allOtherApplications.push(response.data.entity.data[i]);
            }

        },function(response){
            $scope.disabledScroll=false;
        });
	}

	$scope.viewLocum=function(locumId){
		$rootScope.locumForViewId=locumId;
		$cookies.put('locumForViewId',JSON.stringify(locumId));
		$location.path('/view_locum');
	}

	$scope.changeProfileActive=function() {
		if($scope.isProfileActive==true){
			$scope.isProfileActive=false;
		}
		else{ 
			$scope.isProfileActive=true;
		}
	}

	$scope.initFeedback = function() {
		var responseFeedback = ViewPracticeService.getFeedback($scope.currentUser.practice.id);
		responseFeedback.then(function(response){
			$scope.feedbacks=response.data.entity.data;

            $scope.feedbacks.last_page=response.data.entity.last_page;
            $scope.feedbacks.next_page_url=response.data.entity.next_page_url;
            $scope.feedbacks.prev_page_url=response.data.entity.prev_page_url;

            $scope.feedback.maxSizeFeedback = response.data.entity.per_page;
            $scope.feedback.bigTotalItemsFeedback = response.data.entity.total;
            $scope.feedback.bigCurrentPageFeedback = response.data.entity.current_page;

			for (var i = 0; i < $scope.feedbacks.length; i++) {
			var startDate = new Date($scope.feedbacks[i].job_start); 
				var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
				  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
				];
				var newStartDate = monthNames[startDate.getMonth()] + ", " + startDate.getDate() + ", " + startDate.getFullYear();
				$scope.feedbacks[i].job_start = newStartDate;
				var endDate = new Date($scope.feedbacks[i].job_end); 
				var newEndDate = monthNames[endDate.getMonth()] + ", " + endDate.getDate() + ", " + endDate.getFullYear();
				$scope.feedbacks[i].job_end = newEndDate;
			}
      	},
      	function(response){
      	});
	}

    $scope.pageChangedFeedback = function() {
        var url=$scope.feedbacks.next_page_url;
        if($scope.feedbacks.next_page_url==null) {
            url=$scope.feedbacks.prev_page_url;
        }
        var numberToSlice =url;
        var number =numberToSlice.slice(-2);
        if(number>9) {
            var urlToReturn = url.slice(0, -2);
            urlToReturn=urlToReturn+$scope.feedback.bigCurrentPageFeedback;
            $scope.paginateFeedback(urlToReturn)
        }else {
            var urlToReturn = url.slice(0, -1);
            urlToReturn=urlToReturn+$scope.feedback.bigCurrentPageFeedback;
            $scope.paginateFeedback(urlToReturn)
        }
    };

    $scope.paginateFeedback = function(url) {
        var responseFeedback = ViewPracticeService.paginateFeedback(url);
        responseFeedback.then(function(response){
            $scope.feedbacks=response.data.entity.data;
            $scope.feedbacks.last_page=response.data.entity.last_page;
            $scope.feedbacks.next_page_url=response.data.entity.next_page_url;
            $scope.feedbacks.prev_page_url=response.data.entity.prev_page_url;

            $scope.feedback.maxSizeFeedback = response.data.entity.per_page;
            $scope.feedback.bigTotalItemsFeedback = response.data.entity.total;
            $scope.feedback.bigCurrentPageFeedback = response.data.entity.current_page;

            for (var i = 0; i < $scope.feedbacks.length; i++) {
                var startDate = new Date($scope.feedbacks[i].job_start);
                var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                ];
                var newStartDate = monthNames[startDate.getMonth()] + ", " + startDate.getDate() + ", " + startDate.getFullYear();
                $scope.feedbacks[i].job_start = newStartDate;
                var endDate = new Date($scope.feedbacks[i].job_end);
                var newEndDate = monthNames[endDate.getMonth()] + ", " + endDate.getDate() + ", " + endDate.getFullYear();
                $scope.feedbacks[i].job_end = newEndDate;
            }
        },
        function(response){
        });
    }
	
	$scope.getNumber = function(num) {
		if(num==null) {
			return null;
		}
    	return new Array(num);   
	}
	
	var filterAnswer = function(string) {
		if(string==0){
			$scope.answer['0']='fa fa-check-circle';
		}else{
			$scope.answer['1']='fa fa-check-circle';
		}
	}

	var filterMultipleSelect = function(string,arrayForView) {
		var arrStr = string.split(/[,]/);
		for(var i=0; i<arrStr.length; i++){
			arrayForView[arrStr[i]]='fa fa-check-circle';
		}
	}	

	var responsePracticeForView = ViewPracticeService.showPractice(JSON.parse($cookies.get('practiceForViewId')));
	responsePracticeForView.then(function(response){
		$scope.currentUser=[];
		$scope.currentUser.practice=response.data.entity;
		if($scope.currentUser.practice.practice_specialty !=null) {
			filterMultipleSelect($scope.currentUser.practice.practice_specialty,$scope.practiceSpecialty);
		}
		if($scope.currentUser.practice.specialist_equipment !=null) {
			filterMultipleSelect($scope.currentUser.practice.specialist_equipment,$scope.specialistEquipment);
		}
		if($scope.currentUser.practice.practice_management_system !=null){
			filterMultipleSelect($scope.currentUser.practice.practice_management_system,$scope.practiceManagementSystem);
		}
		if($scope.currentUser.practice.lens_product_affiliation !=null) {
			filterMultipleSelect($scope.currentUser.practice.lens_product_affiliation,$scope.lensProductAffiliation);
		}
		if($scope.currentUser.practice.contact_lens_specialty !=null) {
			filterMultipleSelect($scope.currentUser.practice.contact_lens_specialty,$scope.contactLensSpecialty);
		}
		if($scope.currentUser.practice.average_full_exam_time !=null) {
			filterMultipleSelect($scope.currentUser.practice.average_full_exam_time,$scope.avgExamTime);
		}
		if($scope.currentUser.practice.handover_between !=null) {
			filterAnswer($scope.currentUser.practice.handover_between);
		}
		if($scope.currentUser.practice.patient_booking_preference !=null) {
			filterMultipleSelect($scope.currentUser.practice.patient_booking_preference,$scope.patientBookingPreference);
		}
		if($scope.currentUser.practice.pretest_equipment !=null) {
			filterMultipleSelect($scope.currentUser.practice.pretest_equipment,$scope.pretestEquipment);
		}
		if($scope.currentUser.practice.experience_requirement !=null) {
			filterMultipleSelect($scope.currentUser.practice.experience_requirement,$scope.experienceRequirements);
		}
  	},
  	function(response){
  		$scope.currentUser=[];
  		$scope.currentUser.practice=response.data.entity;
  	});

	$scope.moment = function(date) {
        return moment(date);
    }
}]);

