var RegistrationControllers = angular.module('RegistrationControllers', ['ngMessages']);

RegistrationControllers.controller('RegistrationController', ['$scope','RegistrationService','$location','toastr','$cookies','UserService', function($scope,RegistrationService,$location,toastr,$cookies,UserService) {
	UserService.currentUser().then((user) => {
        $scope.currentUser = user;
    });
    $scope.UserService = UserService;
	$scope.user = {};
	$scope.firstStepCompleted=false;
	$scope.user.city="";
	
	$scope.$watch('user.practice_city', function() {
        if(!angular.isUndefined($scope.user.practice_city)){
            if(!isNaN($scope.user.practice_city.substring($scope.user.practice_city.length-1))) {
                $scope.user.practice_city=$scope.user.practice_city.substring(0,$scope.user.practice_city.length-1);
            }
        }
    })

	$scope.changeToStepTwo = function() {
		if ($scope.user.agreed) {
      		$scope.firstStepCompleted=true;
      	}
      	else {
      		$scope.firstStepCompleted=false;
      		toastr.warning("Agree with Terms and Conditions and Privacy and Policy");
      	}
	}

	$scope.registerPractice = function() {
		var responseValidMail = RegistrationService.checkRegisterLocum($scope.user);
			responseValidMail.then(function(response) {
      		if(response.data.errors.email!=null && response.data.errors.email[0]=="The email has already been taken."){
      			 $('#myModal').modal('show');
      		}else {
			var responseRegister = RegistrationService.registerPractice($scope.user);
			responseRegister.then(function(response){
				var responseLogin = RegistrationService.loginPractice($scope.user);
				responseLogin.then(function(response){
					$location.path('/practice');
			      	},
			      	function(response){
			      	});
	      	},
	      	function(response){
	      	});

      		}
	      	},
	      	function(response) {
	      	});
	}
    
	$scope.goToLogin=function() {
		$location.path('/login');
	}

	var responseLatAndLong = RegistrationService.getGeolocation();
		responseLatAndLong.then(function(response){
			RegistrationService.getAddress(response.data.location.lat,response.data.location.lng);
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