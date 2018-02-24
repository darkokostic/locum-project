var ContactControllers = angular.module('ContactControllers', []);

ContactControllers.controller('ContactController', ['$scope', 'ContactService', 'UserService', '$location', '$rootScope', function($scope, ContactService, UserService, $location, $rootScope) {
	UserService.currentUser().then((user) => {
        $rootScope.currentUser = user;
    });
    $scope.$location = $location;
    $scope.user = {
    	'name': null,
    	'mail': null,
    	'message': null
    };
    $scope.isSubmitted = false;

    $scope.onFormSubmit = function() {
    	$scope.isSubmitted = true;
    	ContactService.sendContactForm($scope.user).then(function(success) {
    		$scope.isSubmitted = false;
            $scope.user = {
                'name': null,
                'mail': null,
                'message': null
            };
    	}, function(error) {
    		$scope.isSubmitted = false;
            $scope.user = {
                'name': null,
                'mail': null,
                'message': null
            };
    	});
    	return false;
    };
}]);