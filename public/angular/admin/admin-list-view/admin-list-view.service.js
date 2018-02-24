var AdminListViewServices = angular.module('AdminListViewServices', [])
AdminListViewServices.factory('AdminListViewService', function($http,$q,toastr,$location) {
	return {
		httpGetNews: function() {
			var defer = $q.defer();
        	$http({
                method: 'GET',
                url: 'api/v1/news'
    	    }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
    	    }, function errorCallback(response) {
                defer.reject(response);
    	  	});
        return defer.promise;
        },

        httpGetNewsUser: function(userId) {
            var defer = $q.defer();
            $http({
                method: 'GET',
                url: 'api/v1/news/'+userId
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
        return defer.promise;
        },

        editNewsAdmin: function(single) {
            var defer = $q.defer();
            $http({
            method: 'PATCH',
            data: {
                'title' :  single.title,
                'content' : single.content,
                'for_locum' : single.locum,
                'for_practice' : single.practice,
                'url' : single.url
            },
            url: 'api/v1/news/'+single.id
            }).then(function successCallback(response) {
                defer.resolve(response);
                toastr.success(response.data.message);
            }, function errorCallback(response) {
                defer.reject(response);
                toastr.warning(response.data.message);
            });
            return defer.promise;
        },

        httpDeleteNews: function(Id) {
            var defer = $q.defer();
            $http({
                method: 'DELETE',
                url: 'api/v1/news/'+Id
            }).then(function successCallback(response) {
                defer.resolve(response);
                toastr.success(response.data.message);
                return response;
            }, 
            function errorCallback(response) {
                defer.reject(response);
                toastr.warning(response.data.message);
            });
        return defer.promise;
        },

        getNextNewsData: function(url){
            var defer = $q.defer();
            $http({
                method: 'GET',
                url: url
            }).then(function successCallback(response) {
                defer.resolve(response);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
            });
            return defer.promise;
        },

        httpPostNews: function(news) {
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'title' :  news.title,
                    'content' : news.content,
                    'for_locum' : news.locum,
                    'for_practice' : news.practice,
                    'url' : news.url
                },
                url: 'api/v1/news'
            }).then(function successCallback(response) {
                defer.resolve(response);
                toastr.success(response.data.message);
                return response;
            }, function errorCallback(response) {
                defer.reject(response);
                toastr.warning(response.data.message);
            });
            return defer.promise;
        }
	}
});