var AdminControllers = angular.module('AdminControllers', []);

AdminControllers.controller('AdminController', ['$scope','AdminService','$location', function($scope,AdminService,$location) {
	$scope.news=[];
	$scope.news.practice = true;
	$scope.news.locum = true;
	$scope.newsPost = function (news) {
		$scope.news = news;
		if ($scope.news.locum == 'locum') {
			$scope.news.locum = true;
			$scope.news.practice = false;
		};
		if ($scope.news.practice == 'practice') {
			$scope.news.practice = true;
			$scope.news.locum = false;
		};
		if ($scope.news.both == 'both') {
			$scope.news.practice = true;
			$scope.news.locum = true;
		};
		AdminService.httpPostNews($scope.news).then(function(response) {
			window.location.pathname = '/news_list';
	    },
	  	function(response){
	  	});
  	}

}]);