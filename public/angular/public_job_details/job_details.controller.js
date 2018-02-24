var PublicJobDetailsControllers = angular.module('PublicJobDetailsControllers', ['ngFileUpload'])

.controller('PublicJobDetailsController', ['PublicJobDetailsService','$scope','$location','toastr','$rootScope','$cookies','UserService', function(PublicJobDetailsService,$scope,$location,toastr,$rootScope,$cookies,UserService) {
    $scope.jobDetails=[];
    $scope.allOtherApplications=[];
    $scope.userWhoWon=[];
    $scope.$location = $location;
    $scope.acceptFlag=false;
    $scope.nextPageURL='';
    $scope.disabledScroll=false;
    $rootScope.currentUser = [];
    UserService.currentUser().then((result) => {
        $scope.user = result;
    });
    var responseJobDetails = PublicJobDetailsService.getJob($cookies.get('jobDetailsId'));
    responseJobDetails.then(function(response){
        $scope.jobDetails=response.data.entity;
        $rootScope.currentUser = $scope.jobDetails;
        if(response.data.entity.user_id){
            var responseWon=PublicJobDetailsService.userWhoWon(response.data.entity.user_id);
            responseWon.then(function(response) {
                $scope.userWhoWon=response.data.entity;
            },function(response) {
            });
        }
        $scope.disabledScroll=true;
        var responseAllOtherApplications = PublicJobDetailsService.allOtherApplications($scope.jobDetails.id);
        responseAllOtherApplications.then(function(response){
            $scope.disabledScroll=false;
            $scope.nextPageURL=response.data.entity.next_page_url;
            $scope.allOtherApplications=response.data.entity.data;
        },
        function(response){
            $scope.disabledScroll=true;
        });

    },
    function(response){
    });

    $scope.viewLocum=function(locumId){
        $rootScope.locumForViewId=locumId;
        $cookies.put('locumForViewId',JSON.stringify(locumId));
        $location.path('/view_locum');
    }

    $scope.nearestDoctorId = function(doctor) {
        $scope.id=doctor.id;
        $scope.nameOfDoctor=doctor.name
    }

    $scope.activeApplication = function(userId) {
        $scope.userToSendMailId=userId;
    }

    $scope.acceptAndSendMail = function(doctor) {
        $scope.disabledScroll=true;
        $scope.acceptFlag=true;
        PublicJobDetailsService.acceptApplication($scope.userToSendMailId,$scope.jobDetails.id).then(function(response) {
            var responseWon=PublicJobDetailsService.userWhoWon($scope.id);
            responseWon.then(function(response) {
                $scope.userWhoWon=response.data.entity;
            },function(response) {
            });
            $('#myModal').modal('hide');
        },
        function(response){
            $scope.acceptFlag=false;
            $('#myModal').modal('hide');
        });
        PublicJobDetailsService.sendMailPracticePost(doctor,$scope.id).then(function(response) {
            $('#myModal').modal('hide');
        },
        function(response){
            $scope.acceptFlag=false;
            $('#myModal').modal('hide');
        });
    }

    $scope.paginate=function() {
        $scope.disabledScroll=true;
        PublicJobDetailsService.paginate($scope.nextPageURL).then(function(response) {
            $scope.disabledScroll=false;
            $scope.nextPageURL=response.data.entity.next_page_url;
            for(var i=0;i<response.data.entity.data.length;i++){
                $scope.allOtherApplications.push(response.data.entity.data[i]);
            }

        },function(response){
            $scope.disabledScroll=false;

        });
    }

    $scope.moment = function(date) {
        return moment(date);
    }

}]);