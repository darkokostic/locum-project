var BillingControllers = angular.module('BillingControllers', []);

BillingControllers.controller('BillingController', ['$scope','BillingService','$location','$cookies','UserService','$window','toastr', function($scope,BillingService,$location,$cookies,UserService,$window,toastr) {
	$scope.invoices=[];
	$scope.$location = $location;
	$scope.UserService = UserService;
	$scope.disableSlide=false;
	$scope.searchTerm=[];
	$scope.searchTerm.practice_name='';
	$scope.bill=[];
	$scope.bill.maxSize = 0;
	$scope.bill.bigTotalItems = 0;
	$scope.bill.bigCurrentPage = 0;
	$scope.showLoader = true;

	$scope.moment = function(date) {
		return moment(date);
	}	

	$scope.check = function(billId,invoice) { 
		if (document.getElementById(billId).checked === false) {
		    return false;
		} else {
		   	var box= confirm("Are you sure you want to do this?");
		    if (box===true){   // yes sure
		    	var responseFinish = BillingService.finishBill(invoice.id);
		    	responseFinish.then(function(response) {
		    		document.getElementById(billId).style.display = 'none';
		    		invoice.paid_status="Paid"
		    	},function(response) {
		    	});
		        return true;
		    }
		    else{   // cancel
		       document.getElementById(billId).checked = false;
		    }
	  	}
	};

	$scope.pageChanged = function() {
		var url=$scope.invoices.next_page_url;
	   	if($scope.invoices.next_page_url==null) {
			url=$scope.invoices.prev_page_url;
		}
		var numberToSlice =url;
		var number =numberToSlice.slice(-2);
		if(number>9) {
			var urlToReturn = url.slice(0, -2);
			urlToReturn=urlToReturn+$scope.bill.bigCurrentPage;
	   		$scope.paginate(urlToReturn)
		}else {
			var urlToReturn = url.slice(0, -1);
			urlToReturn=urlToReturn+$scope.bill.bigCurrentPage;
	   		$scope.paginate(urlToReturn)
		}
	};

	var responseBilling = BillingService.getBilling();
		responseBilling.then(function(response){
			$scope.disableSlide=false;		
			$scope.invoices=response.data.entity.data;

			$scope.invoices.last_page=response.data.entity.last_page;
			$scope.invoices.next_page_url=response.data.entity.next_page_url;
			$scope.invoices.prev_page_url='';

			$scope.bill.maxSize = response.data.entity.per_page;
			$scope.bill.bigTotalItems = response.data.entity.total;
			$scope.bill.bigCurrentPage = response.data.entity.current_page;

			for (var i = 0; i < $scope.invoices.length; i++) {
				if($scope.invoices[i].paid_status==1) {
					$scope.invoices[i].paid_status='Paid';
				}else {
					$scope.invoices[i].paid_status='Not Paid';
				}
			}
			$scope.showLoader = false;
  		},function(response){
  			$scope.showLoader = false;
  		});

	$scope.reload=function() {
		$scope.enabled=false;
		$scope.searchTerm=[];
		$scope.searchTerm.name='';
		$scope.searchTerm.city='';
		var responseBilling = BillingService.getBilling();
		responseBilling.then(function(response) {
			$scope.enabled=true;
			$scope.invoices=response.data.entity.data;

			$scope.invoices.last_page=response.data.entity.last_page;
			$scope.invoices.next_page_url=response.data.entity.next_page_url;
			$scope.invoices.prev_page_url='';

			$scope.bill.maxSize = response.data.entity.per_page;
			$scope.bill.bigTotalItems = response.data.entity.total;
			$scope.bill.bigCurrentPage = response.data.entity.current_page;

			for (var i = 0; i < $scope.invoices.length; i++) {
				if($scope.invoices[i].paid_status==1) {
					$scope.invoices[i].paid_status='Paid';
				}else {
					$scope.invoices[i].paid_status='Not Paid';
				}
			}
		},function(response){
		});
	}

	$scope.search = function(searchTerm) {
		if(moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")<moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")||moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD")==moment(searchTerm.dateToToSearch).format("YYYY-MM-DD")){
			if(searchTerm.dateFromToSearch!=null && searchTerm.dateToToSearch!=null){
				var momentDateFrom=moment(searchTerm.dateFromToSearch).format("YYYY-MM-DD");
		        var momentDateTo=moment(searchTerm.dateToToSearch).format("YYYY-MM-DD");
		        searchTerm.dateFromToSearch=momentDateFrom;
		        searchTerm.dateToToSearch=momentDateTo;
	    	}
			var response = BillingService.search(searchTerm);
			response.then(function(response) {
				$scope.invoices=response.data.entity.data;
				$scope.invoices.last_page=response.data.entity.last_page;
				$scope.invoices.next_page_url=response.data.entity.next_page_url;
				$scope.invoices.prev_page_url='';

				$scope.bill.maxSize = response.data.entity.per_page;
				$scope.bill.bigTotalItems = response.data.entity.total;
				$scope.bill.bigCurrentPage = response.data.entity.current_page;

				for (var i = 0; i < $scope.invoices.length; i++) {
					if($scope.invoices[i].paid_status==1) {
						$scope.invoices[i].paid_status='Paid';
					}else {
						$scope.invoices[i].paid_status='Not Paid';
					}
				}
				$scope.searchTerm=[];
			},function(response){
				$scope.searchTerm=[];
				$scope.invoices=[];
			});
		}else {
       		toastr.warning("Job cannot start after it finishes");
   	 	}
	}

	$scope.paginate = function(url) {	
		$scope.enabled=true;
		if(url!=null){
			var response = BillingService.paginate(url,$scope.searchTerm);
			response.then(function(response) {
				$scope.enabled = true;
				$scope.invoices=response.data.entity.data;
				$scope.invoices.last_page=response.data.entity.last_page;
				$scope.invoices.next_page_url=response.data.entity.next_page_url;
				$scope.invoices.prev_page_url=response.data.entity.prev_page_url;

				$scope.bill.maxSize = response.data.entity.per_page;
				$scope.bill.bigTotalItems = response.data.entity.total;
				$scope.bill.bigCurrentPage = response.data.entity.current_page;

				for (var i = 0; i < $scope.invoices.length; i++) {
					if($scope.invoices[i].paid_status==1) {
						$scope.invoices[i].paid_status='Paid';
					}else {
						$scope.invoices[i].paid_status='Not Paid';
					}
				}
		},function(response){
		});
		}
	}

	$scope.requestPDF=function(invoiceId) {
		var responsePDF = BillingService.requestPDF(invoiceId);
		responsePDF.then(function(response){
			$window.open(response.data.entity);
		},function(response){
		});
	}

	$scope.viewPractice=function(practiceId){
		$cookies.put('practiceForViewId',JSON.stringify(practiceId));
		$location.path('/view_practice');
	}

	$scope.open2 = function() {
        if($scope.popup2.opened==false){
            $scope.popup2.opened = true;
        }
        else {
            $scope.popup2.opened = false;
        }
    };

    $scope.popup2 = {
        opened: false
    };

    $scope.open1 = function() {
        if($scope.popup1.opened==false){
            $scope.popup1.opened = true;
        }
        else {
            $scope.popup1.opened = false;
        }
    };

    $scope.popup1 = {
        opened: false
    };

    $scope.status = {
    	isopen: false
  	};


}]);