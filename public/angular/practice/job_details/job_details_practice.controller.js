var PracticeJobDetailsControllers = angular.module('PracticeJobDetailsControllers', ['ngFileUpload'])

.controller('PracticeJobDetailsController', ['PracticeJobDetailsService','$scope','$location','toastr','$rootScope','$cookies','UserService', function(PracticeJobDetailsService,$scope,$location,toastr,$rootScope,$cookies,UserService) {
    $scope.jobDetails=[];
    $scope.allOtherApplications=[];
    $scope.userWhoWon=[];
    $scope.$location = $location;
    $scope.acceptFlag=false;
    $scope.nextPageURL='';
    $scope.disabledScroll=false;
    $scope.disableSendButton=false;
    UserService.currentUser().then((result) => {
        $rootScope.currentUser = result;
    });

    var responseJobDetails = PracticeJobDetailsService.getJob($cookies.get('jobDetailsId'));
    responseJobDetails.then(function(response){
        $scope.jobDetails=response.data.entity;
        if(response.data.entity.user_id){
            var responseWon=PracticeJobDetailsService.userWhoWon(response.data.entity.user_id);
            responseWon.then(function(response) {
                $scope.userWhoWon=response.data.entity;
            },function(response) {
            });
        }
        $scope.disabledScroll=true;
        var responseAllOtherApplications = PracticeJobDetailsService.allOtherApplications($scope.jobDetails.id);
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
        $scope.disableSendButton=true;
        $scope.disabledScroll=true;
        $scope.acceptFlag=true;

        PracticeJobDetailsService.sendMailPracticePost(doctor,$scope.userToSendMailId).then(function(response) {

            PracticeJobDetailsService.accept($scope.userToSendMailId,$scope.jobDetails.id).then(function (rett) {
                window.location.href = rett.data.entity;
            });
        },
        function(response){
            $scope.disableSendButton=false;
            $scope.acceptFlag=false;
        });
    }

    $scope.paginate=function() {
        $scope.disabledScroll=true;
        PracticeJobDetailsService.paginate($scope.nextPageURL).then(function(response) {
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