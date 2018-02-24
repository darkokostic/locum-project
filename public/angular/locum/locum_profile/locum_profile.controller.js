var LocumProfileControllers = angular.module('LocumProfileControllers', ['ngFileUpload', 'ngMessages']).controller('LocumProfileController', ['$scope', 'LocumProfileService', '$location', '$route', '$rootScope', '$cookies', 'LoginService', '$window', 'NgMap', 'LocumMyJobService', 'ViewPracticeService', 'LocumFindAJobService', 'toastr', 'Upload', '$timeout', 'UserService', '$compile', '$uibModal', function($scope, LocumProfileService, $location, $route, $rootScope, $cookies, LoginService, $window, NgMap, LocumMyJobService, ViewPracticeService, LocumFindAJobService, toastr, Upload, $timeout, UserService, $compile, $uibModal) {
    UserService.currentUser().then((user) => {
        $scope.currentUser = user;
    });
    $rootScope.activeClassesForAccInformation = ['active', '', '', ''];
    $rootScope.activeClassesForNavbar = ['active', '', '', ''];
    $rootScope.style2 = "profile";
    $scope.specialistEquipment = [];
    $scope.locumSpecialty = [];
    $scope.practiceManagementSystem = [];
    $scope.lensProductKnowledge = [];
    $scope.contactLensSpecialty = [];
    $scope.avgExamTime = [];
    $scope.answer = [];
    $scope.patientBookingPreference = [];
    $scope.calendar = [];
    $scope.idForDelete = null;
    $scope.dateFromFind = [];
    $scope.dateToFind = [];
    $scope.dateFromOrTo = [];
    $scope.practiceNameColor = [];
    $scope.responseFilter = [];
    $scope.AllOtherApplicationsFilterFrom = [];
    $scope.AllOtherApplicationsFilterTo = [];
    $scope.searchByPracticeName = [];
    $scope.deleteDates = [];
    $scope.jobDetails = [];
    $scope.allOtherApplications = [];
    $scope.currPracticeId;
    $scope.activeApplicationTab = true;
    $scope.idForShowJob = null;
    $scope.jobForApplication = [];
    $scope.openModal = false;
    $scope.$location = $location;
    $scope.UserService = UserService;
    $scope.disableAddButton=false;
    $scope.disableSearch=false;
    $scope.newTaskFrom=new Date();
    $scope.newTaskTo=new Date();
    $scope.searchTerm=[];
    $scope.searchTerm.dateFromToSearch=null;
    $scope.searchTerm.dateToToSearch=null;
    $scope.searchTerm.practiceName='';
    $rootScope.events=[];
    $scope.practicesToShow=[];
    $scope.singlePractice=[];
    $scope.feedback=[];
    $scope.feedback.maxSizeFeedback = 0;
    $scope.feedback.bigTotalItemsFeedback = 0;
    $scope.feedback.bigCurrentPageFeedback = 0;
    $scope.data=[];
    $scope.showLoader = true;
    $scope.format = 'yyyy/MM/dd';
    $scope.currentUser=[];
    $scope.dateOptions = {
        minDate: new Date()
    };


    $scope.changeSinglePractice=function(practice) {
        $scope.singlePractice=practice
    }

    $scope.modalHide = function() {
        $('#jobDetails').modal('hide');
    }

    var getRandColor = function() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    //These variables MUST be set as a minimum for the calendar to work
    $scope.data.calendarView = 'month';
    $scope.data.viewDate = new Date();
    
    /* START Modal open */
    $scope.open = function(data,event) {
        var modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'onCalendarClick.html',
            size: 'lg',
            controller: function($scope) {
                $scope.data = data;
                $scope.event = event;
                $scope.dateOptions = {
                    minDate: new Date()
                };
                $scope.fromUpdate=$scope.event.calendarEvent.startsAt;
                $scope.toUpdate=$scope.event.calendarEvent.endsAt;

                $scope.editEvent=function(from,to) {
                    if(moment(from).format("YYYY-MM-DD")<moment(to).format("YYYY-MM-DD")||moment(from).format("YYYY-MM-DD")==moment(to).format("YYYY-MM-DD")){
                        var responseEdit = LocumProfileService.calendarEditLocum(moment(from).format("YYYY-MM-DD"),moment(to).format("YYYY-MM-DD"),$scope.event.calendarEvent.availabilityId)
                        responseEdit.then(function(response) {
                            $scope.event.calendarEvent.startsAt=new Date(from);
                            $scope.event.calendarEvent.endsAt=new Date(to);
                            $rootScope.events[$scope.event.calendarEvent.calendarEventId]=$scope.event.calendarEvent;

                        }, function() {
                            console.info('Modal dismissed at: ' + new Date());
                        });
                    }else {
                        toastr.warning("Availability cannot start after it finishes");
                    }

                }

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
            }
        });
        modalInstance.result.then(function(selectedItem) {
        }, function() {
            console.info('Modal dismissed at: ' + new Date());
        });
    };
    /* END Modal open */
    $scope.initCalendar=function() {
        $rootScope.events=[];
        $scope.searchTerm=[];
        $scope.searchTerm.dateFromToSearch=null;
        $scope.searchTerm.dateToToSearch=null;
        $scope.searchTerm.practiceName='';
        $scope.practicesToShow=[];
        var responseDates = LocumProfileService.getCalendars();
        responseDates.then(function(response) {
            for (var i = 0; i <=response.data.entity.calendars.length-1; i++) {
                if(response.data.entity.calendars[i].start_date<response.data.entity.calendars[i].end_date ||response.data.entity.calendars[i].start_date==response.data.entity.calendars[i].end_date){
                var eventToPush={
                    title:"Your vacancy",
                    color:{ 
                      primary: '#FF0000',
                      secondary:'#FFA07A'
                    },
                    startsAt: new Date(response.data.entity.calendars[i].start_date),
                    endsAt:new Date(response.data.entity.calendars[i].end_date),
                    draggable: true,
                    resizable: true,
                    availabilityId:response.data.entity.calendars[i].id,
                    incrementsBadgeTotal: false,
                    actions: [{
                        label: '<i class=\'glyphicon glyphicon-pencil\'></i>',
                        onClick: function(args) {
                            $scope.open('Edited',args);
                            // alert.show('Edited', args.calendarEvent);
                        }
                    }, {
                        label: '<i class=\'glyphicon glyphicon-remove\'></i>',
                        onClick: function(args) {
                            LocumProfileService.calendarDeleteLocum(args.calendarEvent.availabilityId);
                            $rootScope.events.splice(args.calendarEvent.calendarEventId,1);
                        }
                    }]
                }
                $rootScope.events.push(eventToPush);
            }
            }
            Object.keys(response.data.entity.practices).forEach(function(key) {
                var practiceColor=getRandColor();
                response.data.entity.practices[key].color=practiceColor;
                $scope.practicesToShow.push(response.data.entity.practices[key]);
                    response.data.entity.practices[key].jobs.forEach(function(job) {
                    if(job.job_start<job.job_end||job.job_start==job.job_end){
                        
                        var eventToPush={
                            title:response.data.entity.practices[key].practice_name,
                            color:{ 
                                  primary: practiceColor,
                                  secondary:'#FFA07A'
                                },
                            startsAt:new Date(job.job_start),
                            endsAt:new Date(job.job_end),
                            draggable: true,
                            resizable: true,
                            jobId:job.id,
                            incrementsBadgeTotal: false,
                            practiceId:response.data.entity.practices[key].id
                        }
                        $rootScope.events.push(eventToPush);
                        }
                });
            });
            $scope.showLoader = false;
        },function(response){
            $scope.showLoader = false;
        });
    }

    $scope.search = function(searchTerm) {
        if(moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")<moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")||moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")==moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")){
            $scope.practicesToShow=[];
            $rootScope.events=[];
            $scope.disableSearch=true;
            if(searchTerm.dateFromToSearch!=null && searchTerm.dateToToSearch!=null){
                var momentDateFrom=moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD");
                var momentDateTo=moment(searchTerm.dateToToSearch).format("YYYY-MM-DD");
                searchTerm.dateFromToSearch=momentDateFrom;
                searchTerm.dateToToSearch=momentDateTo;
            }   
            var responseSearch = LocumProfileService.calendarFilterLocumAvailability(searchTerm);
            responseSearch.then(function(response) {
                console.log(response)
                $scope.disableSearch=false;
                for (var i = 0; i <=response.data.entity.calendars.length-1; i++) {
                    if(response.data.entity.calendars[i].start_date<response.data.entity.calendars[i].end_date ||response.data.entity.calendars[i].start_date==response.data.entity.calendars[i].end_date){
                    var eventToPush={
                        title:"Your vacancy",
                        color:{ 
                          primary: '#FF0000',
                          secondary:'#FFA07A'
                        },
                        startsAt: new Date(response.data.entity.calendars[i].start_date),
                        endsAt:new Date(response.data.entity.calendars[i].end_date),
                        draggable: true,
                        resizable: true,
                        availabilityId:response.data.entity.calendars[i].id,
                        incrementsBadgeTotal: false,
                        actions: [{
                            label: '<i class=\'glyphicon glyphicon-pencil\'></i>',
                            onClick: function(args) {
                                $scope.open('Edited',args);
                            }
                        }, {
                            label: '<i class=\'glyphicon glyphicon-remove\'></i>',
                            onClick: function(args) {
                                LocumProfileService.calendarDeleteLocum(args.calendarEvent.availabilityId);
                                $rootScope.events.splice(args.calendarEvent.calendarEventId,1);
                            }
                        }]
                    }
                    $rootScope.events.push(eventToPush);
                }
                }

                response.data.entity.practices.forEach(function(element){

                    var practiceColor=getRandColor();
                    element.color=practiceColor;
                    var jobs=[];
                    element.jobs.forEach(function(job) {
                        if(job.user_id==null){
                            jobs.push(job);
                        }
                    });
                    element.jobs=jobs;
                    $scope.practicesToShow.push(element);

                    element.jobs.forEach(function(job) {
                        if(job.user_id==null){
                            if(job.job_start<job.job_end||job.job_start==job.job_end){
                                var eventToPush={
                                    title:element.practice_name,
                                    color:{ 
                                          primary: practiceColor,
                                          secondary:'#FFA07A'
                                        },
                                    startsAt:new Date(job.job_start),
                                    endsAt:new Date(job.job_end),
                                    draggable: true,
                                    resizable: true,
                                    jobId:job.id,
                                    incrementsBadgeTotal: false,
                                    practiceId:element.id
                                }
                                $rootScope.events.push(eventToPush);
                            }
                        }
                    });

                });

            },function(response) {
                $scope.disableSearch=false;
            });
        }else {
            toastr.warning("Job cannot start after it finishes");
        }
    }

    $scope.set_color = function (color) {
        return { backgroundColor: color }
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

    $scope.data.cellIsOpen = true;
    $scope.addEvent = function(from,to) {
        $scope.disableAddButton=true;
        if(moment(from).format("YYYY-MM-DD")<moment(to).format("YYYY-MM-DD")||moment(from).format("YYYY-MM-DD")==moment(to).format("YYYY-MM-DD")){
            var responsePost = LocumProfileService.calendarPostLocum(moment(from).format("YYYY-MM-DD"),moment(to).format("YYYY-MM-DD"));
                responsePost.then(function(response) {
                    $scope.disableAddButton=false;
                    $rootScope.events.push({
                        title:"Your vacancy",
                        startsAt: from,
                        endsAt: to,
                        color:{ 
                                primary: '#FF0000',
                                secondary:'#FFA07A'
                                },
                        draggable: true,
                        resizable: true,
                        availabilityId:response.data.entity.id,
                        incrementsBadgeTotal: false,
                        actions:[{
                                label: '<i class=\'glyphicon glyphicon-pencil\'></i>',
                                onClick: function(args) {
                            $scope.open('Edited',args);
                                }
                            }, {
                                label: '<i class=\'glyphicon glyphicon-remove\'></i>',
                                onClick: function(args) {
                                    LocumProfileService.calendarDeleteLocum(args.calendarEvent.availabilityId);
                                    $rootScope.events.splice(args.calendarEvent.calendarEventId,1);
                                }
                            }]
                    });
                }, function(response) {
                    $scope.disableAddButton=false;
                });
        }
        else{
            $scope.disableAddButton=false;
            toastr.warning("Availability cannot start after it finishes")
        }
    };

    $scope.eventClicked = function(event) {
        if(event.jobId!=null){
            $scope.redirectToJobDetails(event.jobId);
        }
    };

    $scope.redirectToJobDetails = function(job) {
        $cookies.put('jobDetailsId',job);
        $location.path('/locum/job_details');
    }

    $scope.eventEdited = function(event) {
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
        if ($scope.data.calendarView === 'month') {
            if (($scope.data.cellIsOpen && moment(date).startOf('day').isSame(moment($scope.data.viewDate).startOf('day'))) || cell.events.length === 0 || !cell.inMonth) {
                $scope.data.cellIsOpen = false;
            } else {
                $scope.data.cellIsOpen = true;
                $scope.data.viewDate = date;
            }
        } else if ($scope.data.calendarView === 'year') {
            if (($scope.data.cellIsOpen && moment(date).startOf('month').isSame(moment($scope.data.viewDate).startOf('month'))) || cell.events.length === 0) {
                $scope.data.cellIsOpen = false;
            } else {
                $scope.data.cellIsOpen = true;
                $scope.data.viewDate = date;
            }
        }
    }

    $scope.uploadFiles = function(file, errFiles) {
        $scope.f = file;
        $scope.errFile = errFiles && errFiles[0];
        if (!angular.isUndefined($scope.errFile)) {
            if ($scope.errFile.$error == 'maxSize') {
                $scope.errFile.$error = 'File is too big, maximum size is 1MB!'
            }
        }
        if (file) {
            file.upload = Upload.upload({
                method: 'POST',
                url: 'api/v1/locum/' + $scope.currentUser.id,
                data: {
                    files: file
                }
            });
            file.upload.then(function(response) {
                $scope.currentUser.avatar = response.data.entity.avatar;
                $timeout(function() {
                    file.result = response.data;
                });
            }, function(response) {
                if (response.status > 0) $scope.errorMsg = response.status + ': ' + response.data;
            }, function(evt) {
                file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }
    }
    try {
        if ($scope.currentUser.role == "ROLE_USER") {
            $scope.$watch('currentUser.city', function() {
                if (!angular.isUndefined($scope.currentUser.city)) {
                    if (!isNaN($scope.currentUser.city.substring($scope.currentUser.city.length - 1))) {
                        $scope.currentUser.city = $scope.currentUser.city.substring(0, $scope.currentUser.city.length - 1);
                    }
                }
            })
        }
    } catch (e) {}
    $scope.dates = {
        start: '',
        end: ''
    };
    
    $scope.changePageView = function(idForShowJob) {
        if ($scope.activeApplicationTab == true) {
            var responseAllOtherApplications = LocumMyJobService.allOtherApplications(idForShowJob);
            responseAllOtherApplications.then(function(response) {
                $scope.allOtherApplications = response.data.entity[0].applications;
            }, function(response) {
            });
            $scope.activeApplicationTab = false;
        } else {
            $scope.activeApplicationTab = true;
        }
    }

    $scope.showPractice = function(practiceId) {
        var responsePracticeForView = ViewPracticeService.showPractice(practiceId);
        responsePracticeForView.then(function(response) {
            $scope.jobDetails.practice = response.data.entity;
        }, function(response) {
            $scope.jobDetails.practice = response.data.entity;
        });
    }

    $scope.viewPractice = function(practiceId) {
        $cookies.put('practiceForViewId', JSON.stringify(practiceId));
        $cookies.put('activeCalLoc', "active");
        $location.path('/view_practice');
    }

    $scope.viewLocum = function(locumId) {
        $cookies.put('locumForViewId', JSON.stringify(locumId));
        $cookies.put('activeCalLoc', "active");
        $location.path('/view_locum');
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

    $scope.initFeedback = function() {
        UserService.currentUser().then((user) => {
        $scope.currentUser = user;
            var responseFeedback = LocumProfileService.getFeedback($scope.currentUser.id);
            responseFeedback.then(function(response) {
                $scope.feedbacks = response.data.entity.data;
                $scope.feedbacks.last_page=response.data.entity.last_page;
                $scope.feedbacks.next_page_url=response.data.entity.next_page_url;
                $scope.feedbacks.prev_page_url=response.data.entity.prev_page_url;

                $scope.feedback.maxSizeFeedback = response.data.entity.per_page;
                $scope.feedback.bigTotalItemsFeedback = response.data.entity.total;
                $scope.feedback.bigCurrentPageFeedback =response.data.entity.current_page;

                $scope.moment = function(date) {
                    return moment(date);
                }
                $scope.showLoader = false;
            }, function(response) { $scope.showLoader = false;});
        });
    }

    $scope.paginateFeedback = function(url) {
        if(url!=null){
            var responseFeedback = LocumProfileService.paginateFeedback(url,$scope.searchTerm);
            responseFeedback.then(function(response) {

                $scope.feedbacks=response.data.entity.data;
                $scope.feedbacks.last_page=response.data.entity.last_page;
                $scope.feedbacks.next_page_url=response.data.entity.next_page_url;
                $scope.feedbacks.prev_page_url=response.data.entity.prev_page_url;

                $scope.feedback.maxSizeFeedback = response.data.entity.per_page;
                $scope.feedback.bigTotalItemsFeedback = response.data.entity.total;
                $scope.feedback.bigCurrentPageFeedback =response.data.entity.current_page;
            },function(response){
            });
        }
    }

    $scope.getNumber = function(num) {
        if (num == null) {
            return null;
        }
        return new Array(num);
    }

    $scope.saveChanges = function() {
        $scope.currentUser.radius=$scope.dataSelect.selectedOption.value;
        $scope.currentUser.radi=$scope.dataSelect.selectedOption.value;
        $scope.openModal = false;
        $('#myModal').modal('hide');
        changeToBoolean($scope.answer);
        $scope.currentUser.specialist_equipment = changeFormatForDatabase($scope.specialistEquipment);
        $scope.currentUser.locum_specialty = changeFormatForDatabase($scope.locumSpecialty);
        $scope.currentUser.practice_management_system = changeFormatForDatabase($scope.practiceManagementSystem);
        $scope.currentUser.lens_product_knowledge = changeFormatForDatabase($scope.lensProductKnowledge);
        $scope.currentUser.average_full_exam_time = changeFormatForDatabase($scope.avgExamTime);
        $scope.currentUser.patient_booking_preference = changeFormatForDatabase($scope.patientBookingPreference);
        $scope.currentUser.contact_lens_specialty = changeFormatForDatabase($scope.contactLensSpecialty);
        LocumProfileService.updateLocum($scope.currentUser);
        $rootScope.clickToChangeActiveTabOnYourAccount(0);
    }

    var changeToBoolean = function(word) {
        if (word[1] != '') {
            $scope.currentUser.handover_between_dr_patient_dispenser = true;
        } else {
            $scope.currentUser.handover_between_dr_patient_dispenser = false;
        }
    }

    function changeFormatForDatabase(array) {
        var keys = [];
        for (var key in array) {
            if (array[key] != '') {
                if (array.hasOwnProperty(key)) {
                    keys.push(key);
                }
            }
        }
        array = keys;
        return createStringByArray(array);
    }

    function createStringByArray(array) {
        var isFirst = true;
        var output = '';
        angular.forEach(array, function(object) {
            if (isFirst == false) output += ",";
            isFirst = false;
            angular.forEach(object, function(value, key) {
                output += value;
            });
        });
        return output;
    }

    var filterAnswer = function(string) {
        if (string == 0) {
            $scope.answer['0'] = 'fa fa-check-circle';
        } else {
            $scope.answer['1'] = 'fa fa-check-circle';
        }
    }

    var filterMultipleSelect = function(string, arrayForView) {
        var arrStr = string.split(/[,]/);
        for (var i = 0; i < arrStr.length; i++) {
            arrayForView[arrStr[i]] = 'fa fa-check-circle';
        }
    }

    $scope.cancelChanges = function() {
        if ($scope.currentUser.locum_specialty != null) {
            $scope.locumSpecialty = [];
            filterMultipleSelect($scope.currentUser.locum_specialty, $scope.locumSpecialty);
        } else {
            $scope.locumSpecialty = [];
        }
        if ($scope.currentUser.specialist_equipment != null) {
            $scope.specialistEquipment = [];
            filterMultipleSelect($scope.currentUser.specialist_equipment, $scope.specialistEquipment);
        } else {
            $scope.specialistEquipment = [];
        }
        if ($scope.currentUser.practice_management_system != null) {
            $scope.practiceManagementSystem = [];
            filterMultipleSelect($scope.currentUser.practice_management_system, $scope.practiceManagementSystem);
        } else {
            $scope.practiceManagementSystem = [];
        }
        if ($scope.currentUser.lens_product_knowledge != null) {
            $scope.lensProductKnowledge = [];
            filterMultipleSelect($scope.currentUser.lens_product_knowledge, $scope.lensProductKnowledge);
        } else {
            $scope.lensProductKnowledge = [];
        }
        if ($scope.currentUser.contact_lens_specialty != null) {
            $scope.contactLensSpecialty = [];
            filterMultipleSelect($scope.currentUser.contact_lens_specialty, $scope.contactLensSpecialty);
        } else {
            $scope.contactLensSpecialty = [];
        }
        if ($scope.currentUser.average_full_exam_time != null) {
            $scope.avgExamTime = [];
            filterMultipleSelect($scope.currentUser.average_full_exam_time, $scope.avgExamTime);
        } else {
            $scope.avgExamTime = [];
        }
        if ($scope.currentUser.handover_between != null) {
            if ($scope.currentUser.handover_between == 1) {
                $scope.answer['1'] = 'fa fa-check-circle';
                $scope.answer['0'] = '';
            }
            if ($scope.currentUser.handover_between == 0) {
                $scope.answer['0'] = 'fa fa-check-circle';
                $scope.answer['1'] = '';
            }
        }
        if ($scope.currentUser.patient_booking_preference != null) {
            $scope.patientBookingPreference = [];
            filterMultipleSelect($scope.currentUser.patient_booking_preference, $scope.patientBookingPreference);
        } else {
            $scope.patientBookingPreference = [];
        }
        UserService.currentUser().then((result) => {
            $scope.currentUser = result;
        });
        $rootScope.clickToChangeActiveTabOnYourAccount(0);
    }

    $scope.checkForAddressToShow = function() {
        if ($scope.currentUser.address2 != null || $scope.currentUser.address2 != '') {
            return true
        } else {
            return false
        }
    }

    $scope.showModal = function() {
        $scope.openModal = true;
        NgMap.getMap("map").then(function(map) {
            google.maps.event.trigger(map, "resize");
            map.setOptions({
                streetViewControl: false
            });
        });
    }

    $scope.closeModal = function() {
        $scope.openModal = false;
    }

    $scope.getpos = function(event) {
        $scope.currentUser.lat = event.latLng.lat();
        $scope.currentUser.lng = event.latLng.lng();
        toastr.success("Location changed,please Save changes");
    };
    if ($location.path() == "/locum/locum_find_a_job") {
        $rootScope.style = "find_a_job";
    }
    if ($location.path() == "/locum/locum_my_job") {
        $rootScope.style = "myJob";
    }
    $rootScope.tabPages = {
        page: 'profile'
    }
    $rootScope.tabPagesMyJobs = {
        page: 'applications'
    }

    $rootScope.clickToChangeActiveTabOnYourAccount = function(argument) {
        if (argument == 0) {
            $rootScope.activeClassesForAccInformation[0] = 'active';
            $rootScope.activeClassesForAccInformation[1] = '';
            $rootScope.activeClassesForAccInformation[2] = '';
            $rootScope.activeClassesForAccInformation[3] = '';
            $rootScope.tabPages.page = 'profile';
            $cookies.put('activeTabAccount', 'profile');
        } else if (argument == 1) {
            $rootScope.activeClassesForAccInformation[1] = 'active';
            $rootScope.activeClassesForAccInformation[0] = '';
            $rootScope.activeClassesForAccInformation[2] = '';
            $rootScope.activeClassesForAccInformation[3] = '';
            $rootScope.tabPages.page = 'availability';
            $cookies.put('activeTabAccount', 'availability');
        } else if (argument == 2) {
            $rootScope.activeClassesForAccInformation[2] = 'active';
            $rootScope.activeClassesForAccInformation[1] = '';
            $rootScope.activeClassesForAccInformation[0] = '';
            $rootScope.activeClassesForAccInformation[3] = '';
            $rootScope.tabPages.page = 'feedback'
            $cookies.put('activeTabAccount', 'feedback');
        } else if (argument == 3) {
            $rootScope.activeClassesForAccInformation[2] = '';
            $rootScope.activeClassesForAccInformation[1] = '';
            $rootScope.activeClassesForAccInformation[0] = '';
            $rootScope.activeClassesForAccInformation[3] = 'active';
            $rootScope.tabPages.page = 'edit'
            $cookies.put('activeTabAccount', 'edit');
        }
    }

    UserService.currentUser().then((user) => {
        $scope.currentUser = user;

        if ($cookies.get('activeTabAccount') == 'profile') {
            $rootScope.clickToChangeActiveTabOnYourAccount(0);
        } else if ($cookies.get('activeTabAccount') == 'availability') {
            $rootScope.clickToChangeActiveTabOnYourAccount(1);
        } else if ($cookies.get('activeTabAccount') == 'feedback') {
            $rootScope.clickToChangeActiveTabOnYourAccount(2);
        } else if ($cookies.get('activeTabAccount') == 'edit') {
            $rootScope.clickToChangeActiveTabOnYourAccount(3);
        }
        if ($scope.currentUser.locum_specialty != null) {
            filterMultipleSelect($scope.currentUser.locum_specialty, $scope.locumSpecialty);
        }
        if ($scope.currentUser.specialist_equipment != null) {
            filterMultipleSelect($scope.currentUser.specialist_equipment, $scope.specialistEquipment);
        }
        if ($scope.currentUser.practice_management_system != null) {
            filterMultipleSelect($scope.currentUser.practice_management_system, $scope.practiceManagementSystem);
        }
        if ($scope.currentUser.lens_product_knowledge != null) {
            filterMultipleSelect($scope.currentUser.lens_product_knowledge, $scope.lensProductKnowledge);
        }
        if ($scope.currentUser.contact_lens_specialty != null) {
            filterMultipleSelect($scope.currentUser.contact_lens_specialty, $scope.contactLensSpecialty);
        }
        if ($scope.currentUser.average_full_exam_time != null) {
            filterMultipleSelect($scope.currentUser.average_full_exam_time, $scope.avgExamTime);
        }
        if ($scope.currentUser.handover_between != null) {
            filterAnswer($scope.currentUser.handover_between);
        }
        if ($scope.currentUser.patient_booking_preference != null) {
            filterMultipleSelect($scope.currentUser.patient_booking_preference, $scope.patientBookingPreference);
        }

        $scope.selectedOption={};
        if($scope.currentUser.radius==10) {
            var name='10 Miles'
            $scope.selectedOption.id='1';
            $scope.selectedOption.name=name;
            $scope.selectedOption.value=10;
        }else if($scope.currentUser.radius==25){
            var name='25 Miles'
            $scope.selectedOption.id='2';
            $scope.selectedOption.name=name;
            $scope.selectedOption.value=25;
        }else if($scope.currentUser.radius==50){
            var name='50 Miles'
            $scope.selectedOption.id='3';
            $scope.selectedOption.name=name;
            $scope.selectedOption.value=50;
        }else {
            var name='No Restriction';
            $scope.selectedOption.id='4';
            $scope.selectedOption.name=name;
            $scope.selectedOption.value=0;
        }
        $scope.dataSelect = {
        availableOptions: [
          {id: '1', name: '10 Miles', value:10},
          {id: '2', name: '25 Miles', value:25},
          {id: '3', name: '50 Miles', value:50},
          {id: '4', name: 'No Restriction', value:0}
        ],
        selectedOption: $scope.selectedOption //This sets the default value of the select in the ui
        };
    });

    $scope.legendJobs = []
    $scope.practiceNameColor = function(practice) {
        $scope.legendJobs = practice;
    }

    $scope.countries = ["Alberta (AB)", "British Columbia (BC)", "Manitoba (MB)", 'New Brunswick (NB)', "Newfoundland and Labrador (NL)", "Northwest Territories (NT)", "Nova Scotia (NS)", "Nunavut (NU)", "Ontario (ON)", "Prince Edward Island (PE)", "Quebec (QC)", "Saskatchewan (SK)", "Yukon (YT)"];

    $scope.liveSearch = function (name) {
        return LocumProfileService.liveSearch(name);
    }

    $scope.moment = function(date) {
        return moment(date);
    }

}]);