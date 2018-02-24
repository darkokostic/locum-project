var HomeControllers = angular.module('HomeControllers', []);

HomeControllers.controller('HomeController', ['$scope', '$location', '$cookies', '$rootScope', '$window', 'HomeService', 'AdminListViewService', 'UserService', '$q', function($scope, $location, $cookies, $rootScope, $window, HomeService, AdminListViewService, UserService, $q) {
    UserService.currentUser().then((user) => {
        $rootScope.currentUser = user;
    });
    $scope.$location = $location;
    $scope.activeImageFacebook = "../img/facebook-img.png";
    $scope.activeImageIn = "../img/linkedin.png";
    $scope.activeImageTwitter = "../img/twitter.png";
    $scope.activeImageYoutube = "../img/youtube.png";
    $scope.userIsPractice='';
    $scope.vacanciesNews = [];
    $scope.currentVacanciesNews = [];
    $scope.currentVacancy = [];
    $scope.vacActive = false;
    $scope.vacancies=[];
    $scope.showLoader = true;

    //Slider
    setTimeout(function() {
        $('.carousel').carousel({
            interval: 700 * 10
        });
    }, 500);

    $scope.loginPage = function() {
        if ($location.path() == '/login') {
            $('#loginFormHolder').addClass('animated tada');
            setTimeout(() => {
                $('#loginFormHolder').removeClass('animated tada');
            }, 2000);
        } else {
            $location.path('/login');
        }
    };

    $scope.registerPage = function() {
        if ($location.path() == '/login') {
            $('#registerFormHolder').addClass('animated tada');
            setTimeout(() => {
                $('#registerFormHolder').removeClass('animated tada');
            }, 2000);
        } else {
            $location.path('/login');
        }
    };

    $scope.viewLocum=function(userId) {
        $cookies.put('locumForViewId',userId);
        $location.path('/view_locum');
    }

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

    HomeService.httpGetNewsHome('news').then(function(response) {
        $scope.vacanciesNews = response.data.entity;
    }, function(response) {$scope.showLoader = false;});

    HomeService.getLocumVac().then(function(response) {
        for (var i = 0; i < 5; i=i+2) {
            if (response.data.entity[i]) {
                response.data.entity[i].role="user"
                $scope.vacancies.push(response.data.entity[i]);
            }
        }
    }, function(response) {$scope.showLoader = false;});

    HomeService.getPracticeVac().then(function(response) {
        for (var i = 1; i < 6; i=i+2) {
            if (response.data.entity[i]) {
                response.data.entity[i].role="practice";
                $scope.vacancies.push(response.data.entity[i]);
            };
            
        }
        $scope.showLoader = false;
    }, function(response) {$scope.showLoader = false;});

    $scope.moment = function(date) {
        return moment(date);
    }

    $scope.setCurrentNews = function(news) {
        $scope.currentVacanciesNews = news;
    };

    $scope.setCurrentVac = function(vac) {
        $scope.currentVacancy = vac;
        $scope.vacActive = true;
    };

    $scope.vacActiveFalse = function() {
        $scope.vacActive = false;
    };
}]);