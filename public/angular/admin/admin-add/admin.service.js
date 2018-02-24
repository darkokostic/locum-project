var AdminServices = angular.module('AdminServices', ['ngCookies'])
AdminServices.factory('AdminService', function($http,$q,toastr) {
	return {  
        httpPostNews: function(news){
            var defer = $q.defer();
            $http({
                method: 'POST',
                data: {
                    'title' :  news.title,
                    'content' : news.content,
                    'for_locum' : news.locum,
                    'for_practice' : news.practice,
                    'url' : single.url
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