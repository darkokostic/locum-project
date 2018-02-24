var RegistrationLocumControllers = angular.module('RegistrationLocumControllers', ['ngMessages']);

RegistrationLocumControllers.controller('RegistrationLocumController', ['$scope','RegistrationLocumService','$location','UserService', function($scope,RegistrationLocumService,$location,UserService) {
	UserService.currentUser().then((user) => {
      $scope.currentUser = user;
    });
    $scope.user = {};
    $scope.UserService = UserService;
	$scope.firstStepCompleted=false;
    $scope.user.city="";

    $scope.$watch('user.city', function() {
        if(!angular.isUndefined($scope.user.city)){
            if(!isNaN($scope.user.city.substring($scope.user.city.length-1))) {
                $scope.user.city=$scope.user.city.substring(0,$scope.user.city.length-1);
            }
        }
    })

	$scope.changeToStepTwo = function() {
		var responseValidMail = RegistrationLocumService.checkRegisterLocum($scope.user);
			responseValidMail.then(function(response) {
      		if(response.data.errors.email!=null && response.data.errors.email[0]=="The email has already been taken."){
      			 $('#myModal').modal('show');
      		}else {
      		$scope.firstStepCompleted=true;
      		}
	      	},
	      	function(response) {
	      	});
	}

	$scope.registerLocum = function() {
		var responseRegister = RegistrationLocumService.registerLocum($scope.user);
		responseRegister.then(function(response){
			var responseLogin = RegistrationLocumService.loginLocum($scope.user);
			responseLogin.then(function(response){
				$location.path('/locum');
	      	},
	      	function(response){
	      	});
      	},
      	function(response){
      	});
	}

	$scope.goToLogin=function() {
		$location.path('/login');
	}

	var responseLatAndLong = RegistrationLocumService.getGeolocation();
	responseLatAndLong.then(function(response){
		RegistrationLocumService.getAddress(response.data.location.lat,response.data.location.lng);
		$scope.user.lat=response.data.location.lat;
		$scope.user.lng=response.data.location.lng;
  	},
  	function(response){
  	});

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
}]);