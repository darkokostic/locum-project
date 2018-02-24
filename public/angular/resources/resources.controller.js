var ResourcesControllers = angular.module('ResourcesControllers', [])
.controller('ResourcesController', ['$scope', 'ResourcesService', 'UserService', '$location', '$rootScope', function($scope, ResourcesService, UserService, $location, $rootScope) {
	UserService.currentUser().then((user) => {
        $rootScope.currentUser = user;
    });
    $scope.$location = $location;
}]);

