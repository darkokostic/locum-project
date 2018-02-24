var PracticeHomeControllers = angular.module('PracticeHomeControllers', []).controller('PracticeHomeController', ['$scope', 'PracticeHomeService', '$location', '$rootScope', '$window', 'HomeService', 'UserService','$cookies', function($scope, PracticeHomeService, $location, $rootScope, $window, HomeService, UserService,$cookies) {
    UserService.currentUser().then((user) => {
        $rootScope.currentUser = user;
    });
    $scope.$location = $location;
    $scope.vacActive = false;
    $scope.showLoader=true;

    $scope.goToRegistrationPractice = function() {
        $location.path('/registration');
    };

    PracticeHomeService.getNewsPractice('news').then(function(response) {
        $scope.vacanciesNews = response.data.entity;
        if (response.data.entity==null) {
            $scope.haveVacancies = false;
        }else {
            $scope.haveVacancies = true;
        }
        PracticeHomeService.getVacanciesPractice().then(function(response) {
            $scope.vacancies = response.data.entity;
            $scope.showLoader = false;
        }, function(response) {$scope.showLoader = false;});
    }, function(response) {
        PracticeHomeService.getVacanciesPractice().then(function(response) {
            $scope.vacancies = response.data.entity;
            $scope.showLoader = false;
        }, function(response) {$scope.showLoader = false;});
        $scope.showLoader = false;
    });

    $scope.moment = function(date) {
        return moment(date);
    }

    $scope.setCurrentVac = function(vac) {
        $scope.currentVacancy = vac;
        $scope.vacActive = true;
    };

    $scope.vacActiveFalse = function() {
        $scope.vacActive = false;
    };

    $scope.viewLocum=function(userId){
        $cookies.put('locumForViewId',userId);
        $location.path('/view_locum');
    }
}]);