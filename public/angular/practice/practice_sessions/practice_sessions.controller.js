var PracticeSessionsControllers = angular.module('PracticeSessionsControllers', [])

.controller('PracticeSessionsController', ['$scope','PracticeSessionsService','$rootScope','$location','$cookies','UserService','toastr', function($scope,PracticeSessionsService,$rootScope,$location,$cookies,UserService,toastr) {
	$scope.currentSessions=[];
	$scope.finishedSessions=[];
	$rootScope.locumForViewId=null;
	$scope.rateLocum=[];
	$scope.percs=[];
	$scope.$location = $location;
    $scope.UserService = UserService;
    $scope.currentUrl='';
    $scope.sessions = [];
    $scope.sessions.maxSize = 0;
    $scope.sessions.bigTotalItems = 0;
    $scope.sessions.bigCurrentPage = 0;
    $scope.showLoader = true;
    $scope.searchTerm=[];
    $scope.UserService.currentUser().then((user) => {
        $scope.currentUser = user;
    });

    $scope.moment = function(date) {
		return moment(date);
	}

	$scope.showPercs=function(percs){
		for (var i = 0; i < percs.percentages.length; i++) {
			
			var startDate = new Date(percs.percentages[i].day); 
				var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
				  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
				];
				var newStartDate = monthNames[startDate.getMonth()] + ", " + startDate.getDate() + ", " + startDate.getFullYear();
				percs.percentages[i].day = newStartDate;

		}
		$scope.percs=percs;
	};

    $scope.pageChanged = function() {
        var url=$scope.currentSessions.next_page_url;
        if($scope.currentSessions.next_page_url==null) {
            url=$scope.currentSessions.prev_page_url;
        }
        var numberToSlice =url;
        var number =numberToSlice.slice(-2);
        if(number>9) {
            var urlToReturn = url.slice(0, -2);
            urlToReturn=urlToReturn+$scope.sessions.bigCurrentPage;
            $scope.currentUrl=urlToReturn;
            $scope.paginate(urlToReturn)
        }else {
            var urlToReturn = url.slice(0, -1);
            urlToReturn=urlToReturn+$scope.sessions.bigCurrentPage;
            $scope.currentUrl=urlToReturn;
            $scope.paginate(urlToReturn)
        }
    };

    $scope.reload=function() {
        var responseActiveLocums = PracticeSessionsService.getCurrentLocums();
        responseActiveLocums.then(function(response){
        $scope.searchTerm=[];
            $scope.enabled=true;
            $scope.currentSessions = response.data.entity.data;

            $scope.currentSessions.last_page=response.data.entity.last_page;
            $scope.currentSessions.next_page_url=response.data.entity.next_page_url;
            $scope.currentSessions.prev_page_url='';

            $scope.sessions.maxSize = response.data.entity.per_page;
            $scope.sessions.bigTotalItems = response.data.entity.total;
            $scope.sessions.bigCurrentPage = response.data.entity.current_page;
        },
        function(response){
            $scope.currentSessions = null;
        });
    }

	var responseActiveLocums = PracticeSessionsService.getCurrentLocums();
	responseActiveLocums.then(function(response){
            $scope.enabled=true;
			$scope.currentSessions = response.data.entity.data;

            $scope.currentSessions.last_page=response.data.entity.last_page;
            $scope.currentSessions.next_page_url=response.data.entity.next_page_url;
            $scope.currentSessions.prev_page_url='';

            $scope.sessions.maxSize = response.data.entity.per_page;
            $scope.sessions.bigTotalItems = response.data.entity.total;
            $scope.sessions.bigCurrentPage = response.data.entity.current_page;
		},
		function(response){
            $scope.currentSessions = null;
		});

    $scope.paginate = function(url) {
         $scope.enabled=false;
        if(url!=null){
            var responseActiveLocums = PracticeSessionsService.paginate(url,$scope.searchTerm);
            responseActiveLocums.then(function(response){
                $scope.enabled=true;
                $scope.currentSessions = response.data.entity.data;

                $scope.currentSessions.last_page=response.data.entity.last_page;
                $scope.currentSessions.next_page_url=response.data.entity.next_page_url;
                $scope.currentSessions.prev_page_url=response.data.entity.prev_page_url;;

                $scope.sessions.maxSize = response.data.entity.per_page;
                $scope.sessions.bigTotalItems = response.data.entity.total;
                $scope.sessions.bigCurrentPage = response.data.entity.current_page;
            },
            function(response){
                $scope.currentSessions = null;
            });
        }
    }

	$scope.accept = function(perc) {
		document.getElementById(perc.id).style.display='none';
		document.getElementById('D'+perc.id).style.display='none';
		PracticeSessionsService.sendAmount(perc.id);
	}

	$scope.declineAmount = function(perc) {
        document.getElementById(perc.id).style.display='none';
        document.getElementById('D'+perc.id).style.display='none';
		PracticeSessionsService.declineAmount(perc.id);
		
	}

    $scope.showLoader = true;
	var responseFinishedLocums = PracticeSessionsService.getLocumsWhoCompleted();
	responseFinishedLocums.then(function(response){
		$scope.finishedSessions=response.data.entity;
        $scope.showLoader = false;
		},
        
		function(response){
            $scope.showLoader = false;
		});

	$scope.viewLocum=function(locumId){
		$rootScope.locumForViewId=locumId;
		$cookies.put('locumForViewId',JSON.stringify(locumId));
		$location.path('/view_locum');
	}

    $scope.openModal=function(session) {
        $scope.rateLocum=session;
    }

	$scope.giveFeedback = function() {
		var responseFeedback = PracticeSessionsService.giveFeedback($scope.rateLocum, $scope.currentUser.id);
        responseFeedback.then(function(response){
            if($scope.currentUrl!=''){
                $scope.paginate($scope.currentUrl);
            }else {
                $scope.reload();
            }
        },function(response){

        });
		var responseFinish = PracticeSessionsService.finishJob($scope.rateLocum.id);
        responseFinish.then(function(response){

        },function(response){

        });
	}

	$scope.search = function (search_key) {
        if(moment(search_key.dateFromToSearch).format("YYYY-MM-DD")<moment(search_key.dateToToSearch).format("YYYY-MM-DD")||moment(search_key.dateFromToSearch).format("YYYY-MM-DD")==moment(search_key.dateToToSearch).format("YYYY-MM-DD")){
            if(search_key.dateFromToSearch!=null && search_key.dateToToSearch!=null){
                var momentDateFrom=moment(search_key.dateFromToSearch).format("YYYY-MM-DD");
                var momentDateTo=moment(search_key.dateToToSearch).format("YYYY-MM-DD");
                search_key.dateFromToSearch=momentDateFrom;
                search_key.dateToToSearch=momentDateTo;
            }
            $scope.enabled = false;
            var responseActiveLocums = PracticeSessionsService.getCurrentLocumsSearch(search_key);
            responseActiveLocums.then(function(response){
                $scope.searchTerm=[];
                $scope.enabled=true;
                $scope.currentSessions = response.data.entity.data;

                $scope.currentSessions.last_page=response.data.entity.last_page;
                $scope.currentSessions.next_page_url=response.data.entity.next_page_url;
                $scope.currentSessions.prev_page_url='';

                $scope.sessions.maxSize = response.data.entity.per_page;
                $scope.sessions.bigTotalItems = response.data.entity.total;
                $scope.sessions.bigCurrentPage = response.data.entity.current_page;
            },
            function(response){
                $scope.searchTerm=[];
                $scope.currentSessions = null;
            });
        }else {
            toastr.warning("Job cannot start after it finishes");
        }

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

    $scope.status = {
        isopen: false
    };

}]);