var LoginControllers = angular.module('LoginControllers', ['ngMessages']);
LoginControllers.controller('LoginController', ['$scope', 'LoginService', '$location', '$rootScope', '$cookies', 'UserService', 'toastr', function($scope, LoginService, $location, $rootScope, $cookies, UserService, toastr) {
    UserService.currentUser().then((user) => {
        $rootScope.currentUser = user;
        if($rootScope.currentUser) {
        	if($rootScope.currentUser.role == "ROLE_USER") {
        		$location.path('/locum');
        	} else if($rootScope.currentUser.role == "ROLE_OWNER") {
        		$location.path('/practice');
        	} else if($rootScope.currentUser.role == "ROLE_ADMIN") {
        		$location.path('/home');
        	}
        }
    });
    $scope.$location = $location;
    
    $scope.login = function() {
        LoginService.loginLocum($scope.user).then(function(response) {
            if (response.data.entity.role == "ROLE_USER") {
                $location.path('/locum');
            } else if (response.data.entity.role == "ROLE_OWNER") {
                LoginService.loginPractice($scope.user).then(function(response) {
                    $location.path('/practice');
                }, function(data) {
                    toastr.warning("Wrong email or password");
                });
            }
        }, function(data) {
        	toastr.warning("Wrong email or password");
        });
    };

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

}]);