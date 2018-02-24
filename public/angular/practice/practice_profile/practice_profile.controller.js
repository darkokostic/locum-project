var PracticeProfileControllers = angular.module('PracticeProfileControllers', ['ngFileUpload', 'ngMessages'])

.controller('PracticeProfileController', ['$scope','PracticeProfileService','$location','$rootScope','$window','$route','NgMap','Upload','$timeout','toastr','$cookies','UserService','PracticeMyDashboardService','$compile','$uibModal', function($scope,PracticeProfileService,$location,$rootScope,$window,$route,NgMap,Upload,$timeout,toastr,$cookies,UserService,PracticeMyDashboardService,$compile,$uibModal) {
	
	$scope.UserService = UserService;
	$rootScope.activeClassesForAccInformationPractice = ['active',''];
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
	$scope.activeApplicationTabJobs=true; 
	$scope.jobDetails=[];
	$scope.jobDetailsCalendar=[];
	$scope.allOtherApplications=[];
	$scope.allOtherApplicationsCalendar=[];
	$scope.userWhoWon=[];
	$scope.userWhoWonCalendar=[];
	$scope.calendar=[];
	$scope.allDates=[];
	$scope.idForDelete=null;
	$scope.dateFromFind=[];
	$scope.dateToFind=[];
	$scope.deleteDates=[];
	$scope.dateFromOrTo=[];
	$scope.practiceNameColor = [];
	$scope.responseFilter = [];
	$scope.AllOtherApplicationsFilterFrom = [];
    $scope.AllOtherApplicationsFilterTo=[];
    $scope.searchByPracticeName=[];
    $rootScope.currentUserId=null;
    $scope.day_rate;
	$scope.$location = $location;
    $scope.events=[];
    $scope.searchTerm=[];
    $scope.searchTerm.dateFromToSearch=null;
    $scope.searchTerm.dateToToSearch=null;
    $scope.searchTerm.locumName='';
    $scope.locumsToShow=[];
    $scope.feedback = [];
    $scope.feedback.maxSizeFeedback = 0;
	$scope.feedback.bigTotalItemsFeedback = 0;
	$scope.feedback.bigCurrentPageFeedback = 0;
	$scope.datas=[];
	$scope.singleLocum=[];
	$scope.showLoader=true;
	
    $scope.changePageView = function(job) {
        if ($scope.activeApplicationTabFeedback == true) {
        	$scope.jobDetails=job;
            var responseAllOtherApplications = PracticeProfileService.allOtherApplications(job.id);
            responseAllOtherApplications.then(function(response) {
                $scope.allOtherApplications = response.data.entity[0].applications;
            }, function(response) {
            });
            $scope.activeApplicationTabFeedback = false;
        } else {
            $scope.activeApplicationTabFeedback = true;
        }
    }

    function checkForUserWhoWonApplicationCalendar(application,idUser) {
		for (var i = 0; i < application.length; i++) {
			if(idUser==application[i].user.id) {
				$scope.userWhoWonCalendar=application[i];
			}
		}
	}

	function checkForUserWhoWonApplication(application,idUser) {
		for (var i = 0; i < application.length; i++) {
			if(idUser==application[i].user.id) {
				$scope.userWhoWonCalendar=application[i];
			}
		}
	}

	$scope.openModal = function(user) {
		$scope.userToSendMail=user;
	}

	$scope.acceptAndSendMail = function(mail) {
		PracticeMyDashboardService.acceptApplication($scope.userToSendMail.id,$scope.jobDetailsCalendar.id).then(function(response) {
  			$('#myModal').modal('hide');
	    },
	  	function(response){
	  	});
	  	PracticeMyDashboardService.sendMailPracticePost(mail,$scope.userToSendMail.id).then(function(response) {
  			$('#myModal').modal('hide');
	    },
	  	function(response){
	  	});
	}

    $scope.changePageViewCalendar = function(jobDetailsCalendar) {
		$scope.userWhoWonCalendar=null;
		if(!angular.isUndefined(jobDetailsCalendar)){
			jobDetailsCalendar.application_start = moment(jobDetailsCalendar.application_start).format('MMM DD YYYY')
			jobDetailsCalendar.application_end =  moment(jobDetailsCalendar.application_end).format('MMM DD YYYY');

			if($scope.activeApplicationTabJobs==true){
				var responseAllOtherApplications = PracticeProfileService.allOtherApplications(jobDetailsCalendar.id);
				responseAllOtherApplications.then(function(response){
					$scope.allOtherApplicationsCalendar=response.data.entity[0].applications;
					checkForUserWhoWonApplicationCalendar($scope.allOtherApplicationsCalendar,jobDetailsCalendar.user_id);
		  		},function(response){
		  		});
					$scope.jobDetailsCalendar=jobDetailsCalendar;
					$scope.activeApplicationTabJobs=false;
			}
			else{
				$scope.activeApplicationTabJobs=true;
			}
		}else{
		$scope.activeApplicationTabJobs=true;
		}
	}

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

    /* END Modal open */
    var getRandColor = function() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    $scope.set_color = function (color) {
	    return { backgroundColor: color }
	}
	$scope.open = function(data,event) {
		if(event.calendarEvent.jobDetails.user_id==null){
        var modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'onCalendarClick.html',
            size: 'lg',
            controller: function($scope) {
                $scope.data = data;
                $scope.event = event;
                $scope.newJob = $scope.event.calendarEvent.jobDetails;
                $scope.newJob.job_start=new Date($scope.event.calendarEvent.jobDetails.job_start);
                $scope.newJob.job_end=new Date($scope.event.calendarEvent.jobDetails.job_end);
                $scope.newJob.application_start=new Date($scope.event.calendarEvent.jobDetails.application_start);
                $scope.newJob.application_end=new Date($scope.event.calendarEvent.jobDetails.application_end);
                $scope.fromUpdate=$scope.event.calendarEvent.startsAt;
                $scope.toUpdate=$scope.event.calendarEvent.endsAt;
			    $scope.dateOptions = {
			        minDate: new Date()
			    };
            	$scope.requiredPayType={
			        'percentage' : true,
			        'day_rate' : true
			    }

			    $scope.checkForValidation = function() {
			    	if(moment($scope.newJob.job_start).format("YYYY-MM-DD")<moment($scope.newJob.job_end).format("YYYY-MM-DD")||moment($scope.newJob.job_start).format("YYYY-MM-DD")==moment($scope.newJob.job_end).format("YYYY-MM-DD")){
			            if(moment($scope.newJob.application_start).format("YYYY-MM-DD")<moment($scope.newJob.application_end).format("YYYY-MM-DD")||moment($scope.newJob.application_start).format("YYYY-MM-DD")==moment($scope.newJob.application_end).format("YYYY-MM-DD")){
			    	}else {
			                return true;
			            }
			        }else {
			            return true;
			        }
			        return false;
			    }

                $scope.editJob=function(from,to) {
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
			                
			                var responseEdit = PracticeProfileService.editAJob($scope.newJob);
			                responseEdit.then(function(response) {
	                            $scope.event.calendarEvent.jobDetails=$scope.newJob;
	                            $scope.event.calendarEvent.title=$scope.newJob.title;
	                            $scope.event.calendarEvent.startsAt=new Date($scope.newJob.job_start);
	                            $scope.event.calendarEvent.endsAt=new Date($scope.newJob.job_end);
	                            modalInstance.dismiss();
		                		// $scope.events[$scope.event.calendarEvent.calendarEventId]=$scope.event.calendarEvent;
			                },function(response) {

			                })
			            }else {
			                toastr.warning("Application cannot start after it finishes");
			            }
			        }else {
			            toastr.warning("Job cannot start after it finishes");
			        }
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
            }
        });
        modalInstance.result.then(function(selectedItem) {
        }, function() {
            console.info('Modal dismissed at: ' + new Date());
        });
    }else {
    	toastr.warning("You can't edit job if there is agreement between the Locum and the Practice");
    }
    };
    //These variables MUST be set as a minimum for the calendar to work
    $scope.datas.calendarView = 'month';
    $scope.datas.viewDate = new Date();
    $scope.initCalendar = function(){
    	$scope.locumsToShow=[];
    	$scope.events=[];
    	$scope.searchTerm.locumName='';
	    UserService.currentUser().then((user) => {
	    var responseDates = PracticeProfileService.getCalendar();
	            responseDates.then(function(response) {

	            	//These are locums and their availabilities
	                for (var i = 0; i <=response.data.entity.locums.length-1; i++) {
	                	if(response.data.entity.locums[i].calendars!=0){
	                	var locumColor=getRandColor();

	                	response.data.entity.locums[i].color=locumColor;
	                	$scope.locumsToShow.push(response.data.entity.locums[i]);

	                	for (var j = 0; j < response.data.entity.locums[i].calendars.length; j++) {
		                	if(response.data.entity.locums[i].calendars[j].start_date<response.data.entity.locums[i].calendars[j].end_date||response.data.entity.locums[i].calendars[j].start_date==response.data.entity.locums[i].calendars[j].end_date){
	                		
						    	var eventToPush={
						    		title:response.data.entity.locums[i].name,
						    		color:{ 
			                              primary: locumColor,
			                              secondary:'#FFA07A'
			                            },
						    		startsAt:new Date(response.data.entity.locums[i].calendars[j].start_date),
						    		endsAt:new Date(response.data.entity.locums[i].calendars[j].end_date),
						    		draggable: true,
						    		resizable: true,
                    				incrementsBadgeTotal: false,
						    		locumId:response.data.entity.locums[i].id
						    	}
						    	$scope.events.push(eventToPush);
						    	}
	            			}
	            		}
					}

					//These are your jobs
					for (var i = 0; i <=response.data.entity.jobs.length-1; i++) {
		                if(response.data.entity.jobs[i].job_start<response.data.entity.jobs[i].job_end||response.data.entity.jobs[i].job_start==response.data.entity.jobs[i].job_end){
		                var eventToPush={
		                    title:response.data.entity.jobs[i].title,
		                    color:{ 
		                      primary: '#FF0000',
		                      secondary:'#FFA07A'
		                    },
		                    startsAt: new Date(response.data.entity.jobs[i].job_start),
		                    endsAt:new Date(response.data.entity.jobs[i].job_end),
		                    draggable: true,
		                    resizable: true,
                    		incrementsBadgeTotal: false,
		                    jobDetails:response.data.entity.jobs[i],
		                    actions: [{
		                        label: '<i class=\'glyphicon glyphicon-pencil\'></i>',
		                        onClick: function(args) {
		                            $scope.open('Edited',args);
		                            // alert.show('Edited', args.calendarEvent);
		                        }
		                    }]
		                }
		                $scope.events.push(eventToPush);
		            }
		            }

	            }, function(response) {
	            });
	    });
	}

    $scope.search = function(searchTerm) {
    	if(moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")<moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")||moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")==moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")){
	    	$scope.disableSearch=true;
	        if(searchTerm.dateFromToSearch!=null && searchTerm.dateToToSearch!=null){
	            var momentDateFrom=moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD");
	            var momentDateTo=moment(searchTerm.dateToToSearch).format("YYYY-MM-DD");
	            searchTerm.dateFromToSearch=momentDateFrom;
	            searchTerm.dateToToSearch=momentDateTo;
	        }   
	        var responseSearch = PracticeProfileService.search(searchTerm);
	        responseSearch.then(function(response){
	    	$scope.locumsToShow=[];
	        $scope.disableSearch=false;
	            $scope.events=[];
	            for (var i = 0; i <=response.data.entity.locums.length-1; i++) {
	            	if(response.data.entity.locums[i].calendars!=0){
	                	var locumColor=getRandColor();

	                	response.data.entity.locums[i].color=locumColor;
	                	$scope.locumsToShow.push(response.data.entity.locums[i]);

	                	for (var j = 0; j < response.data.entity.locums[i].calendars.length; j++) {
		                	if(response.data.entity.locums[i].calendars[j].start_date<response.data.entity.locums[i].calendars[j].end_date||response.data.entity.locums[i].calendars[j].start_date==response.data.entity.locums[i].calendars[j].end_date){
	                		
					    	var eventToPush={
					    		title:response.data.entity.locums[i].name,
					    		color:{ 
		                              primary: locumColor,
		                              secondary:'#FFA07A'
		                            },
					    		startsAt:new Date(response.data.entity.locums[i].calendars[j].start_date),
					    		endsAt:new Date(response.data.entity.locums[i].calendars[j].end_date),
					    		draggable: true,
					    		resizable: true,
                    			incrementsBadgeTotal: false,
					    		locumId:response.data.entity.locums[i].id
					    	}
					    	$scope.events.push(eventToPush);
					    	}
	            		}
	            	}
				}
					//These are your jobs
				for (var i = 0; i <=response.data.entity.jobs.length-1; i++) {
	                if(response.data.entity.jobs[i].job_start<response.data.entity.jobs[i].job_end||response.data.entity.jobs[i].job_start==response.data.entity.jobs[i].job_end){
	                var eventToPush={
	                    title:response.data.entity.jobs[i].title,
	                    color:{ 
	                      primary: '#FF0000',
	                      secondary:'#FFA07A'
	                    },
	                    startsAt: new Date(response.data.entity.jobs[i].job_start),
	                    endsAt:new Date(response.data.entity.jobs[i].job_end),
	                    draggable: true,
	                    resizable: true,
	                    jobDetails:response.data.entity.jobs[i],
                    	incrementsBadgeTotal: false,
	                    actions: [{
	                        label: '<i class=\'glyphicon glyphicon-pencil\'></i>',
	                        onClick: function(args) {
	                            $scope.open('Edited',args);
	                            // alert.show('Edited', args.calendarEvent);
	                        }
	                    }]
	                }
	                $scope.events.push(eventToPush);
	            }
	            }
	            
	        }, function(response) {
	            $scope.disableSearch=false;
	        });
        }else {
            toastr.warning("Job cannot start after it finishes");
        }
    }
    $scope.datas.cellIsOpen = true;

    $scope.eventClicked = function(event) {
        if(event.locumId!=null){
        	$scope.viewLocum(event.locumId);
        }
        else if(event.jobDetails!=null) {
			$cookies.put('jobDetailsId',event.jobDetails.id);
			$location.path('/practice/job_details');
        }
    };
    $scope.eventEdited = function(event) {
    	console.log(event)
        $scope.open('Event Edited');
    };
    $scope.eventDeleted = function(event) {
        $scope.open('Event Deleted');
    };
    $scope.eventTimesChanged = function(event) {
        $scope.open('Event time changed');
    };
    $scope.toggle = function($event, field, event) {
        $event.preventDefault();
        $event.stopPropagation();
        event[field] = !event[field];
    };
    $scope.timespanClicked = function(date, cell) {
        if ($scope.datas.calendarView === 'month') {
            if (($scope.datas.cellIsOpen && moment(date).startOf('day').isSame(moment($scope.datas.viewDate).startOf('day'))) || cell.events.length === 0 || !cell.inMonth) {
                $scope.datas.cellIsOpen = false;
            } else {
                $scope.datas.cellIsOpen = true;
                $scope.datas.viewDate = date;
            }
        } else if ($scope.datas.calendarView === 'year') {
            if (($scope.datas.cellIsOpen && moment(date).startOf('month').isSame(moment($scope.datas.viewDate).startOf('month'))) || cell.events.length === 0) {
                $scope.datas.cellIsOpen = false;
            } else {
                $scope.datas.cellIsOpen = true;
                $scope.datas.viewDate = date;
            }
        }
    };

    $scope.uploadFiles = function(file, errFiles) {
        $scope.f = file;
        $scope.errFile = errFiles && errFiles[0];
        if(!angular.isUndefined($scope.errFile)){
		    if($scope.errFile.$error=='maxSize'){
		    	$scope.errFile.$error='File is too big, maximum size is 1MB!'
		    }
    	}
        if (file) {
            file.upload = Upload.upload({
            	method: 'POST',
                url: 'api/v1/practice/'+$rootScope.currentUser.practice.id,
                data: {files: file}
            });
            file.upload.then(function (response) {
            	$rootScope.currentUser.practice.avatar=response.data.entity.avatar;
                $timeout(function () {
                    file.result = response.data;
                });
            }, function (response) {
                if (response.status > 0)
                    $scope.errorMsg = response.status + ': ' + response.data;
            }, function (evt) {
                file.progress = Math.min(100, parseInt(100.0 * 
                                         evt.loaded / evt.total));
            });
        }   
    }
    $scope.showDate = function() {
		   $('#datetimepicker1 ').data("DateTimePicker").show();
		}
		$scope.showDate2 = function() {
		   $('#datetimepicker2 ').data("DateTimePicker").show();
		}

	$scope.dates = {
		start: '',
		end: ''
	};

	$scope.viewLocum=function(userId){
		if(userId!=null){
			$cookies.put('locumForViewId',userId);
		}
		$location.path('/view_locum');
	}

	UserService.currentUser().then((user) => {
		$rootScope.currentUser = user;
		$scope.showLoader=true;
		var responseFeedback = PracticeProfileService.getFeedback($rootScope.currentUser.practice.id);
			responseFeedback.then(function(response){

				$scope.feedbacks=response.data.entity.data;
				$scope.feedbacks.last_page=response.data.entity.last_page;
				$scope.feedbacks.next_page_url=response.data.entity.next_page_url;
				$scope.feedbacks.prev_page_url=response.data.entity.prev_page_url;

				$scope.feedback.maxSizeFeedback = response.data.entity.per_page;
				$scope.feedback.bigTotalItemsFeedback = response.data.entity.total;
				$scope.feedback.bigCurrentPageFeedback = response.data.entity.current_page;
	      	},
	      	function(response){
	      	});

	      	$scope.moment = function(date) {
		        return moment(date);
		    }
		    $scope.showLoader=false;
	});

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
		var responseFeedback = PracticeProfileService.paginateFeedback(url);
		responseFeedback.then(function(response) {
			$scope.feedbacks=[];
			$scope.feedbacks=response.data.entity.data;
			$scope.feedbacks.last_page=response.data.entity.last_page;
			$scope.feedbacks.next_page_url=response.data.entity.next_page_url;
			$scope.feedbacks.prev_page_url=response.data.entity.prev_page_url;

			$scope.feedback.maxSizeFeedback = response.data.entity.per_page;
			$scope.feedback.bigTotalItemsFeedback = response.data.entity.total;
			$scope.feedback.bigCurrentPageFeedback = response.data.entity.current_page;
			$rootScope.urlNow=$scope.url;
		},function(response){
		});
	}

	$scope.getNumber = function(num) {
			if(num==null) {
				return null;
			}
	    return new Array(num);   
	}

	var filterMultipleSelect = function(string,arrayForView) {
		var arrStr = string.split(/[,]/);
		for(var i=0; i<arrStr.length; i++){
			arrayForView[arrStr[i]]='fa fa-check-circle';
		}
	}
	
	var changeToBoolean = function(word) {
		if(word[1]!=''){
			$rootScope.currentUser.practice.handover_between=true;
		}
		else {
			$rootScope.currentUser.practice.handover_between=false;
		}
	}

	function changeFormatForDatabase(array) {
		var keys = [];
		for (var key in array) {
		    if(array[key]!=''){
			  	if (array.hasOwnProperty(key)) {
				    keys.push(key);
				  }
			}
		}
		array=keys;
		return createStringByArray(array);
	}

	function createStringByArray(array) {
		var isFirst=true;
	    var output = '';
	    angular.forEach(array, function (object) {
	    	if(isFirst==false)
	    	output+=",";
	    	isFirst=false;
	        angular.forEach(object, function (value, key) {
	            output += value ;
	        });
	    });
    return output;
	}
	
	var filterAnswer = function(string) {
		if(string==0){
			$scope.answer['0']='fa fa-check-circle';
		}else{
			$scope.answer['1']='fa fa-check-circle';
		}
	}

	$scope.changeSingleLocum=function(locum) {
        $scope.singleLocum=locum;
    }

    $scope.cancelChanges= function() {
		if($rootScope.currentUser.practice.practice_specialty !=null) {
			$scope.practiceSpecialty=[];
			filterMultipleSelect($rootScope.currentUser.practice.practice_specialty,$scope.practiceSpecialty);
		}else {
			$scope.practiceSpecialty=[];
		}
		if($rootScope.currentUser.practice.specialist_equipment !=null) {
			$scope.specialistEquipment=[];
			filterMultipleSelect($rootScope.currentUser.practice.specialist_equipment,$scope.specialistEquipment);
		}else {
			$scope.specialistEquipment=[];
		}
		if($rootScope.currentUser.practice.practice_management_system !=null){
			$scope.practiceManagementSystem=[];
			filterMultipleSelect($rootScope.currentUser.practice.practice_management_system,$scope.practiceManagementSystem);
		}else {
			$scope.practiceManagementSystem=[];
		}
		if($rootScope.currentUser.practice.lens_product_affiliation !=null) {
			$scope.lensProductAffiliation=[];
			filterMultipleSelect($rootScope.currentUser.practice.lens_product_affiliation,$scope.lensProductAffiliation);
		}else {
			$scope.lensProductAffiliation=[];
		}
		if($rootScope.currentUser.practice.contact_lens_specialty !=null) {
			$scope.contactLensSpecialty=[];
			filterMultipleSelect($rootScope.currentUser.practice.contact_lens_specialty,$scope.contactLensSpecialty);
		}else {
			$scope.contactLensSpecialty=[];
		}
		if($rootScope.currentUser.practice.average_full_exam_time !=null) {
			$scope.avgExamTime=[];
			filterMultipleSelect($rootScope.currentUser.practice.average_full_exam_time,$scope.avgExamTime);
		}else {
			$scope.avgExamTime=[];
		}
		if($rootScope.currentUser.practice.handover_between !=null) {
			if($rootScope.currentUser.practice.handover_between==1) {
				$scope.answer['1']='fa fa-check-circle';
				$scope.answer['0']='';
			}
			if($rootScope.currentUser.practice.handover_between==0) {
				$scope.answer['0']='fa fa-check-circle';
				$scope.answer['1']='';
			}
		}
		if($rootScope.currentUser.practice.patient_booking_preference !=null) {
			$scope.patientBookingPreference=[];
			filterMultipleSelect($rootScope.currentUser.practice.patient_booking_preference,$scope.patientBookingPreference);
		}else {
			$scope.patientBookingPreference=[];
		}
		if($rootScope.currentUser.practice.pretest_equipment !=null) {
			$scope.pretestEquipment=[];
			filterMultipleSelect($rootScope.currentUser.practice.pretest_equipment,$scope.pretestEquipment);
		}else {
			$scope.pretestEquipment=[];
		}
		if($rootScope.currentUser.practice.experience_requirement !=null) {
			$scope.experienceRequirements=[];
			filterMultipleSelect($rootScope.currentUser.practice.experience_requirement,$scope.experienceRequirements);
		}else {
			$scope.experienceRequirements=[];
		}
		$scope.UserService.currentUser().then((result) => {
    		$rootScope.currentUser = result;
    	});
    	$rootScope.clickToChangeActiveTabOnYourAccountPractice(0);
    }
		$scope.viewJobDetails = function(id) {
			$cookies.put('jobDetailsId',id);
			$location.path('/practice/job_details');
		}

	$rootScope.clickToChangeActiveTabOnYourAccountPractice = function (argument) {
		if (argument == 0) { 
			$rootScope.activeClassesForAccInformationPractice[0]='active';
			$rootScope.activeClassesForAccInformationPractice[1]='';
			$rootScope.activeClassesForAccInformationPractice[2]='';
			$rootScope.activeClassesForAccInformationPractice[3]='';
			$rootScope.tabPagesPracticeYourAcc.page = 'profile';
			$cookies.put('activeTabAccountPractice', 'profile');
		}else if(argument == 1){
			$rootScope.activeClassesForAccInformationPractice[1]='active';
			$rootScope.activeClassesForAccInformationPractice[0]='';
			$rootScope.activeClassesForAccInformationPractice[2]='';
			$rootScope.activeClassesForAccInformationPractice[3]='';
			$rootScope.tabPagesPracticeYourAcc.page = 'feedback';
			$cookies.put('activeTabAccountPractice', 'feedback');
		}else if(argument == 2) {
			$rootScope.activeClassesForAccInformationPractice[2]='active';
			$rootScope.activeClassesForAccInformationPractice[0]='';
			$rootScope.activeClassesForAccInformationPractice[1]='';
			$rootScope.activeClassesForAccInformationPractice[3]='';
			$rootScope.tabPagesPracticeYourAcc.page = 'availability';
			$cookies.put('activeTabAccountPractice', 'availability');
		}else if(argument == 3){
			$rootScope.activeClassesForAccInformationPractice[2]='';
			$rootScope.activeClassesForAccInformationPractice[1]='';
			$rootScope.activeClassesForAccInformationPractice[0]='';
			$rootScope.activeClassesForAccInformationPractice[3]='active';
			$rootScope.tabPagesPracticeYourAcc.page = 'edit';
			$cookies.put('activeTabAccountPractice', 'edit');
		}
	}
	$scope.saveChanges = function() {
		changeToBoolean($scope.answer);
		$rootScope.currentUser.practice.specialist_equipment = changeFormatForDatabase($scope.specialistEquipment);
		$rootScope.currentUser.practice.practice_specialty = changeFormatForDatabase($scope.practiceSpecialty);
		$rootScope.currentUser.practice.practice_management_system = changeFormatForDatabase($scope.practiceManagementSystem);
		$rootScope.currentUser.practice.lens_product_affiliation = changeFormatForDatabase($scope.lensProductAffiliation);
		$rootScope.currentUser.practice.average_full_exam_time = changeFormatForDatabase($scope.avgExamTime);
		$rootScope.currentUser.practice.patient_booking_preference = changeFormatForDatabase($scope.patientBookingPreference);
		$rootScope.currentUser.practice.contact_lens_specialty = changeFormatForDatabase($scope.contactLensSpecialty);
		$rootScope.currentUser.practice.pretest_equipment = changeFormatForDatabase($scope.pretestEquipment);
		$rootScope.currentUser.practice.experience_requirement = changeFormatForDatabase($scope.experienceRequirements);
		PracticeProfileService.updatePractice($rootScope.currentUser.practice);
		$rootScope.clickToChangeActiveTabOnYourAccountPractice(0);
	}
    $scope.UserService.currentUser().then((result) => {
    	$rootScope.currentUser = result;
    	if($rootScope.currentUser.role=='ROLE_OWNER'){
			if($rootScope.currentUser.practice.practice_specialty !=null) {
				filterMultipleSelect($rootScope.currentUser.practice.practice_specialty,$scope.practiceSpecialty);
			}
			if($rootScope.currentUser.practice.specialist_equipment !=null) {
				filterMultipleSelect($rootScope.currentUser.practice.specialist_equipment,$scope.specialistEquipment);
			}
			if($rootScope.currentUser.practice.practice_management_system !=null){
				filterMultipleSelect($rootScope.currentUser.practice.practice_management_system,$scope.practiceManagementSystem);
			}
			if($rootScope.currentUser.practice.lens_product_affiliation !=null) {
				filterMultipleSelect($rootScope.currentUser.practice.lens_product_affiliation,$scope.lensProductAffiliation);
			}
			if($rootScope.currentUser.practice.contact_lens_specialty !=null) {
				filterMultipleSelect($rootScope.currentUser.practice.contact_lens_specialty,$scope.contactLensSpecialty);
			}
			if($rootScope.currentUser.practice.average_full_exam_time !=null) {
				filterMultipleSelect($rootScope.currentUser.practice.average_full_exam_time,$scope.avgExamTime);
			}
			if($rootScope.currentUser.practice.handover_between !=null) {
				filterAnswer($rootScope.currentUser.practice.handover_between);
			}
			if($rootScope.currentUser.practice.patient_booking_preference !=null) {
				filterMultipleSelect($rootScope.currentUser.practice.patient_booking_preference,$scope.patientBookingPreference);
			}
			if($rootScope.currentUser.practice.pretest_equipment !=null) {
				filterMultipleSelect($rootScope.currentUser.practice.pretest_equipment,$scope.pretestEquipment);
			}
			if($rootScope.currentUser.practice.experience_requirement !=null) {
				filterMultipleSelect($rootScope.currentUser.practice.experience_requirement,$scope.experienceRequirements);
			}
			if($cookies.get('activeTabAccountPractice')=='profile'){
	    	$rootScope.clickToChangeActiveTabOnYourAccountPractice(0);
		    }else if($cookies.get('activeTabAccountPractice')=='feedback'){
		    	$rootScope.clickToChangeActiveTabOnYourAccountPractice(1);
		    }else if($cookies.get('activeTabAccountPractice')=='availability'){
		    	$rootScope.clickToChangeActiveTabOnYourAccountPractice(2);
		    }else if($cookies.get('activeTabAccountPractice')=='edit'){
		    	$rootScope.clickToChangeActiveTabOnYourAccountPractice(3);
		    }
		}
    });
		
	
    NgMap.getMap().then(function(map) {
	 	map.setOptions({streetViewControl: false});
  	});
  	
	$scope.getpos = function(event) {
    	$cookies.getObject('practice').lat=event.latLng.lat();
    	$cookies.getObject('practice').lng=event.latLng.lng();    	
	};

	$rootScope.tabPagesPracticeYourAcc = {
		page: 'profile'
	}

	$scope.disabledInput1= function() {
		$scope.disabled1 = true;
		$scope.disabled2 = false;
	}

	$scope.disabledInput2= function() {
		$scope.disabled2 = true;
		$scope.disabled1 = false;
	}

	$scope.getRandColor = function() {
		var letters = '0123456789ABCDEF';
	    var color = '#';
	    for (var i = 0; i < 6; i++ ) {
	        color += letters[Math.floor(Math.random() * 16)];
	    }
	    return color;
		}
		$scope.legendJobs = []
		$scope.practiceNameColor = function(practice) {
			$scope.legendJobs=practice;
	}

	$scope.countries = [
  		"Alberta (AB)",
        "British Columbia (BC)",
        "Manitoba (MB)",
        'New Brunswick (NB)',
        "Newfoundland and Labrador (NL)",
        "Northwest Territories (NT)",
        "Nova Scotia (NS)",
        "Nunavut (NU)",
        "Ontario (ON)",
        "Prince Edward Island (PE)",
        "Quebec (QC)",
        "Saskatchewan (SK)",
        "Yukon (YT)"
    ];

    $scope.liveSearch = function (name) {
        return PracticeProfileService.liveSearch(name);

    }
    $scope.moment = function(date) {
        return moment(date);
    }

}]);




