var AdminListViewControllers = angular.module('AdminListViewControllers', []);
AdminListViewControllers.controller('AdminListViewController', ['$scope','AdminListViewService','$location','$window','Upload', function($scope,AdminListViewService,$location,$window,Upload) {
	
	$scope.news = [];
	$scope.single = [];
	$scope.single.both = false;
    $scope.fileToUpload = null;
	//Dev
	//$scope.nextPageUrlNews = 'http://homestead.dev/api/v1/news?page=1';
	//Prod
	$scope.nextPageUrlNews = 'http://162.243.87.85/api/v1/news?page=1';
	$scope.nextPageExistNewsList=false;

    $scope.single.maxSize = 0;
    $scope.single.bigTotalItems = 0;
    $scope.single.bigCurrentPage = 0;
    $scope.showLoader = true;

    $scope.uploadFiles = function(file, errFiles) {
        $scope.f = file;
        $scope.errFile = errFiles && errFiles[0];
        if(!angular.isUndefined($scope.errFile)){
            if($scope.errFile.$error=='maxSize'){
                $scope.errFile.$error='File is too big, maximum size is 1MB!'
            }
        }
        if (file) {
            $scope.fileToUpload = file;
            console.log('eeee');
            // file.upload = Upload.upload({
            //     method: 'POST',
            //     url: 'api/v1/practice/'+$rootScope.currentUser.practice.id,
            //     data: {files: file}
            // });
            // file.upload.then(function (response) {
            //     $rootScope.currentUser.practice.avatar=response.data.entity.avatar;
            //     $timeout(function () {
            //         file.result = response.data;
            //     });
            // }, function (response) {
            //     if (response.status > 0)
            //         $scope.errorMsg = response.status + ': ' + response.data;
            // }, function (evt) {
            //     file.progress = Math.min(100, parseInt(100.0 *
            //         evt.loaded / evt.total));
            // });
        }
    }

    $scope.pageChanged = function() {
        var url=$scope.news.next_page_url;
        if($scope.news.next_page_url==null) {
            url=$scope.news.prev_page_url;
        }
        var numberToSlice =url;
        var number =numberToSlice.slice(-2);
        if(number>9) {
            var urlToReturn = url.slice(0, -2);
            urlToReturn=urlToReturn+$scope.single.bigCurrentPage;
            $scope.paginate(urlToReturn)
        }else {
            var urlToReturn = url.slice(0, -1);
            urlToReturn=urlToReturn+$scope.single.bigCurrentPage;
            $scope.paginate(urlToReturn)
        }
    };
    $scope.paginate = function(url) {
        $scope.enabled=true;
        if(url!=null){
            var responseNews = AdminListViewService.getNextNewsData(url);
            responseNews.then(function(response){
                    $scope.news=response.data.entity.data;
                    $scope.news.last_page=response.data.entity.last_page;
                    $scope.news.next_page_url=response.data.entity.next_page_url;
                    $scope.news.prev_page_url=response.data.entity.prev_page_url;

                    $scope.single.maxSize = response.data.entity.per_page;
                    $scope.single.bigTotalItems = response.data.entity.total;
                    $scope.single.bigCurrentPage = response.data.entity.current_page;

                },
                function(response){
                });
        }
    }
  	var responseNews = AdminListViewService.httpGetNews('news');
	responseNews.then(function(response){
            $scope.enabled=true;
            $scope.news=response.data.entity.data;
            $scope.news.last_page=response.data.entity.last_page;
            $scope.news.next_page_url=response.data.entity.next_page_url;
            $scope.news.prev_page_url=response.data.entity.prev_page_url;
            $scope.single.maxSize = response.data.entity.per_page;
            $scope.single.bigTotalItems = response.data.entity.total;
            $scope.single.bigCurrentPage = response.data.entity.current_page;
            $scope.showLoader = false;
	},
	function(response){
        $scope.showLoader = false;
	});

	$scope.getNewsPopup = function(userId) {
	  	var responseNewsUser = AdminListViewService.httpGetNewsUser(userId);
		responseNewsUser.then(function(response){
                $scope.single=response.data.entity;
                $scope.single.for_locum = response.data.entity.for_locum;
                $scope.single.for_practice = response.data.entity.for_practice;
                $scope.single.for_both = 0;
                if ($scope.single.for_locum && $scope.single.for_practice){
                    $scope.single.for_both = 1;
                    $scope.single.for_locum = 0;
                    $scope.single.for_practice = 0;
                }
            },
  		function(response){
  		});
	}
	$scope.deleteNews = function(userId,index) {

		var responseNewsDelete = AdminListViewService.httpDeleteNews(userId);
		responseNewsDelete.then(function(response){
                var responseNews = AdminListViewService.httpGetNews('news');
                responseNews.then(function(response){
                        $scope.enabled=true;
                        $scope.news=response.data.entity.data;
                        $scope.news.last_page=response.data.entity.last_page;
                        $scope.news.next_page_url=response.data.entity.next_page_url;
                        $scope.news.prev_page_url=response.data.entity.prev_page_url;
                        $scope.single.maxSize = response.data.entity.per_page;
                        $scope.single.bigTotalItems = response.data.entity.total;
                        $scope.single.bigCurrentPage = response.data.entity.current_page;
                    },
                    function(response){
                    });
		},
		function(response){
		});
	}

	$scope.single = [];
	$scope.editNewsPopup = function (single) {
        $scope.single = single;
			if ($scope.single.locum == 'locum') {
				$scope.single.locum = true;
				$scope.single.practice = false;
			};
			if ($scope.single.practice == 'practice') {
				$scope.single.practice = true;
				$scope.single.locum = false;
			};
			if ($scope.single.both == 'both') {
				$scope.single.practice = true;
				$scope.single.locum = true;
			};
		var responseEditNews = AdminListViewService.editNewsAdmin($scope.single).then(function() {
		    var file = $scope.fileToUpload;
            file.upload = Upload.upload({
                method: 'POST',
                url: 'api/v1/news/avatar/'+$scope.single.id,
                data: {files: file}
            });
            file.upload.then(function (response) {
                $window.location.reload();
            }, function (response) {
                if (response.status > 0)
                    $scope.errorMsg = response.status + ': ' + response.data;
            }, function (evt) {
                file.progress = Math.min(100, parseInt(100.0 *
                    evt.loaded / evt.total));
            });

		});
	}

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
		AdminListViewService.httpPostNews($scope.news).then(function(response) {
			$window.location.reload();
	    },
	  	function(response){
	  	});
  	}
}]);