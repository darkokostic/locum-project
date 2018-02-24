var AboutControllers = angular.module('AboutControllers', []);

AboutControllers.controller('AboutController', ['$scope','AboutService','$location','UserService','$rootScope', function($scope,AboutService,$location,UserService,$rootScope) {
	UserService.currentUser().then((user) => {
        $rootScope.currentUser = user;
    });
    $scope.$location = $location;
}]);