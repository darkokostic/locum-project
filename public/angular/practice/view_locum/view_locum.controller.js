var ViewLocumControllers = angular.module('ViewLocumControllers', [])

.controller('ViewLocumController', ['$scope','ViewLocumService','$location','$route','$rootScope','$cookies','$window','$templateCache','UserService', function($scope,ViewLocumService,$location,$route,$rootScope,$cookies,$window,$templateCache,UserService) {
		
    	$scope.UserService = UserService;
		UserService.currentUser().then((user) => {
	        $scope.currentUser = user;
    	});
		$scope.specialistEquipment=[];
		$scope.locumSpecialty=[];
		$scope.practiceManagementSystem=[];
		$scope.lensProductKnowledge=[];
		$scope.contactLensSpecialty=[]; 
		$scope.avgExamTime=[]; 
		$scope.answer=[]; 
		$scope.patientBookingPreference=[]; 
		$scope.isProfileActive=true;
		$scope.feedbacks=[];
		$scope.currUser=[];
		$scope.feedback = [];
		$scope.feedback.maxSizeFeedback = 0;
		$scope.feedback.bigTotalItemsFeedback = 0;
		$scope.feedback.bigCurrentPageFeedback = 0;

		$scope.changeProfileActive=function() {
			if($scope.isProfileActive==true){
				$scope.isProfileActive=false;
			}
			else{ 
				$scope.isProfileActive=true;
			}
		}

		$scope.initFeedback = function() {
			var responseFeedback = ViewLocumService.getFeedback($scope.currUser.id);
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
            var responseFeedback = ViewLocumService.paginateFeedback(url);
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

		var responseUserForView = ViewLocumService.showLocum($cookies.get('locumForViewId'));
		responseUserForView.then(function(response){
			$scope.currUser=response.data.entity;
			if($scope.currUser.locum_specialty !=null) {
				filterMultipleSelect($scope.currUser.locum_specialty,$scope.locumSpecialty);
			}
			if($scope.currUser.specialist_equipment !=null) {
				filterMultipleSelect($scope.currUser.specialist_equipment,$scope.specialistEquipment);
			}
			if($scope.currUser.practice_management_system !=null){
				filterMultipleSelect($scope.currUser.practice_management_system,$scope.practiceManagementSystem);
			}
			if($scope.currUser.lens_product_knowledge !=null) {
				filterMultipleSelect($scope.currUser.lens_product_knowledge,$scope.lensProductKnowledge);
			}
			if($scope.currUser.contact_lens_specialty!=null) {
				filterMultipleSelect($scope.currUser.contact_lens_specialty,$scope.contactLensSpecialty);
			}
			if($scope.currUser.average_full_exam_time!=null) {
				filterMultipleSelect($scope.currUser.average_full_exam_time,$scope.avgExamTime);
			}
			if($scope.currUser.handover_between!=null) {
				filterAnswer($scope.currUser.handover_between);
			}
			if($scope.currUser.patient_booking_preference !=null) {
				filterMultipleSelect($scope.currUser.patient_booking_preference,$scope.patientBookingPreference);
			}
      	},
      	function(response){
			$scope.currUser.visible=0;
      	});

		$scope.moment = function(date) {
	        return moment(date);
	    }

}]);

