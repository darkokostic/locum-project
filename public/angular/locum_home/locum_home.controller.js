var LocumHomeControllers = angular.module('LocumHomeControllers', []).controller('LocumHomeController', ['$scope', 'LocumHomeService', '$location', '$rootScope', '$window', 'HomeService', 'UserService','$cookies', function($scope, LocumHomeService, $location, $rootScope, $window, HomeService, UserService,$cookies) {
    UserService.currentUser().then((user) => {
        $rootScope.currentUser = user;
    });
    $scope.$location = $location;
    $scope.vacActive = false;
    $scope.showLoader = true;

    $scope.goToRegistrationLocum = function() {
        $location.path('/registration-locum');
    };

    $scope.moment = function(date) {
        return moment(date);
    }

    LocumHomeService.getNewsLocum('news').then(function(response) {
        $scope.vacanciesNews = response.data.entity;
        if (response.data.entity==null) {
            $scope.haveVacancies = false;
        }else {
            $scope.haveVacancies = true;
        }
        LocumHomeService.getVacanciesLocum().then(function(response) {
            $scope.vacancies = response.data.entity;
            $scope.showLoader = false;
        }, function(response) {$scope.showLoader = false;});
    }, function(response) {
        LocumHomeService.getVacanciesLocum().then(function(response) {
            $scope.vacancies = response.data.entity;
            $scope.showLoader = false;
        }, function(response) {$scope.showLoader = false;});
        $scope.showLoader = false;
    });

    $scope.setCurrentVac = function(vac) {
        $scope.currentVacancy = vac;
        $scope.vacActive = true;
    };

    $scope.vacActiveFalse = function() {
        $scope.vacActive = false;
    };

    $scope.viewPractice = function(jobID) {
        UserService.currentUser().then((result) => {
        console.log($scope.user);
        $scope.user = result;
        if($scope.user!=null) {
            if($scope.user.role=="ROLE_USER") {
                $cookies.put('jobDetailsId', jobID);
                $location.path('/locum/job_details');
            }else {
                $cookies.put('jobDetailsId', jobID);
                $location.path('/job_details');
            }
        }else {
            $cookies.put('jobDetailsId', jobID);
            $location.path('/job_details');
        }
        });
    }
}]);