var app = angular.module('myApp', ['ngRoute', 'ui.bootstrap', 'angular-loading-bar', 'angularSpinner', 'PublicJobDetailsControllers','PublicJobDetailsServices','toastr','mwl.calendar','ngCookies','infinite-scroll','angularSpinner', 'angular-input-stars', 'HomeControllers', 'HomeServices', 'LoginControllers', 'LoginServices', 'RegistrationControllers', 'RegistrationServices', 'AboutControllers', 'AboutServices', 'LocumFindAJobControllers', 'LocumFindAJobServices', 'LocumProfileControllers', 'LocumProfileServices', 'PracticeProfileControllers', 'PracticeProfileServices', 'PracticeMyDashboardControllers','ui.calendar', 'PracticeMyDashboardServices', 'PracticeBillingControllers', 'PracticeBillingServices', 'PracticeSessionsControllers', 'PracticeSessionsServices', 'PracticeCreateJobControllers', 'PracticeCreateJobServices', 'ResourcesControllers', 'ResourcesServices', 'PaymentControllers', 'PaymentServices', 'ContactControllers', 'ContactServices', 'RegistrationLocumControllers', 'RegistrationLocumServices', 'BillingControllers', 'BillingServices', 'LocumMyJobControllers', 'LocumMyJobServices', 'LocumHomeControllers', 'LocumHomeServices', 'PracticeHomeControllers', 'PracticeHomeServices', 'ViewLocumServices', 'ViewLocumControllers', 'ViewPracticeServices', 'ViewPracticeControllers', 'ngMap', 'AdminControllers', 'AdminServices', 'AdminListViewControllers', 'AdminListViewServices', 'PayPalControllers', 'ui.mask', 'PracticeAllJobsControllers', 'PracticeAllJobsServices','JobDetailsControllers','JobDetailsServices','PracticeJobDetailsControllers','PracticeJobDetailsServices','TermsAndConditionsControllers', 'TermsAndConditionsServices'])

.config(['$routeProvider', 'cfpLoadingBarProvider', '$httpProvider', 'uiMask.ConfigProvider', 'toastrConfig', 'calendarConfig', function($routeProvider, cfpLoadingBarProvider, $httpProvider, uiMaskConfigProvider, toastrConfig, calendarConfig) {
    uiMaskConfigProvider.maskDefinitions({
        '0': /[0]/,
        '1': /[0-1]/,
        '2': /[0-2]/,
        '3': /[0-3]/,
        '4': /[0-4]/,
        '5': /[0-5]/,
        '6': /[0-6]/,
        '7': /[0-7]/,
        '8': /[0-8]/,
        '9': /\d/,
        'A': /[a-zA-Z]/,
        '*': /[a-zA-Z0-9]/
    });
    $routeProvider.
    when('/home', {
        templateUrl: 'angular/home/home.html',
        controller: 'HomeController'
    }).
    when('/login', {
        templateUrl: 'angular/login/login.html',
        controller: 'LoginController'
    }).
    when('/registration', {
        templateUrl: 'angular/registration/registration.html',
        controller: 'RegistrationController'
    }).
    when('/about', {
        templateUrl: 'angular/about_us/about_us.html',
        controller: 'AboutController'
    }).
    when('/locum', {
        templateUrl: 'angular/locum/locum_profile/locum_profile.html',
        controller: 'LocumProfileController'
    }).
    when('/locum/locum_find_a_job', {
        templateUrl: 'angular/locum/locum_find_a_job/locum_find_a_job.html',
        controller: 'LocumFindAJobController'
    }).
    when('/locum/billing', {
        templateUrl: 'angular/locum/billing/billing.html',
        controller: 'BillingController'
    }).
    when('/practice', {
        templateUrl: 'angular/practice/practice_profile/practice_profile.html',
        controller: 'PracticeProfileController'
    }).
    when('/practice/practice_my_dashboard', {
        templateUrl: 'angular/practice/practice_my_dashboard/practice_my_dashboard.html',
        controller: 'PracticeMyDashboardController'
    }).
    when('/practice/practice_sessions', {
        templateUrl: 'angular/practice/practice_sessions/practice_sessions.html',
        controller: 'PracticeSessionsController'
    }).
    when('/practice/practice_all_jobs', {
        templateUrl: 'angular/practice/practice_all_jobs/practice_all_jobs.html',
        controller: 'PracticeAllJobsController'
    }).
    when('/practice/practice_billing', {
        templateUrl: 'angular/practice/practice_billing/practice_billing.html',
        controller: 'PracticeBillingController'
    }).
    when('/practice/practice_create_job', {
        templateUrl: 'angular/practice/practice_create_job/practice_create_job.html',
        controller: 'PracticeCreateJobController'
    }).
    when('/resources', {
        templateUrl: 'angular/resources/resources.html',
        controller: 'ResourcesController'
    }).
    when('/terms_and_conditions', {
        templateUrl: 'angular/terms_and_conditions/terms_and_conditions.html',
        controller: 'TermsAndConditionsController'
    }).
    when('/payment', {
        templateUrl: 'angular/payment/payment.html',
        controller: 'PaymentController'
    }).
    when('/contact', {
        templateUrl: 'angular/contact/contact.html',
        controller: 'ContactController'
    }).
    when('/job_details', {
        templateUrl: 'angular/public_job_details/job_details.html',
        controller: 'PublicJobDetailsController'
    }).
    when('/registration-locum', {
        templateUrl: 'angular/registration-locum/registration_locum.html',
        controller: 'RegistrationLocumController'
    }).
    when('/locum/locum_my_job', {
        templateUrl: 'angular/locum/locum_my_job/locum_my_job.html',
        controller: 'LocumMyJobController'
    }).
    when('/locum_home', {
        templateUrl: 'angular/locum_home/locum_home.html',
        controller: 'LocumHomeController'
    }).
    when('/practice_home', {
        templateUrl: 'angular/practice_home/practice_home.html',
        controller: 'PracticeHomeController'
    }).
    when('/view_locum', {
        templateUrl: 'angular/practice/view_locum/view_locum.html',
        controller: 'ViewLocumController'
    }).
    when('/view_practice', {
        templateUrl: 'angular/locum/view_practice/view_practice.html',
        controller: 'ViewPracticeController'
    }).
    when('/paypal', {
        templateUrl: 'angular/paypal/paypal.html',
        controller: 'PayPalController'
    }).
    when('/locum/job_details', {
        templateUrl: 'angular/locum/job_details/job_details.html',
        controller: 'JobDetailsController'
    }).
    when('/practice/job_details', {
        templateUrl: 'angular/practice/job_details/job_details_practice.html',
        controller: 'PracticeJobDetailsController'
    }).
    otherwise({
        redirectTo: '/home'
    });
    
    cfpLoadingBarProvider.includeSpinner = false;
    var interceptor401 = ['$q', '$window', '$location', '$rootScope', '$injector', '$cookies', function($q, $window, $location, $injector, $rootScope, $cookies) {
        return {
            'responseError': function(rejection, $rootScope) {
                if (rejection.status === 401) {
                    var publicPages = ['/login', '/home', '/registration', '/about', '/contact', '/registration-locum', '/locum_home', '/practice_home', '/resources', '/paypal','/view_locum', '/job_details','/terms_and_conditions'];
                    var restrictedPage = publicPages.indexOf($location.path()) === -1;
                    if (restrictedPage) {
                        $location.path("/home");
                    }
                    $cookies.remove('userCookie');
                }
                return $q.reject(rejection);
            }
        };
    }];
    var interceptor400 = ['$q', '$window', '$location', '$rootScope', '$injector', function($q, $window, $location, $injector) {
        return {
            'responseError': function(rejection, $rootScope) {
                if (rejection.status === 400) {}
                return $q.reject(rejection);
            }
        };
    }];
    var interceptor404 = ['$q', '$window', '$location', '$rootScope', '$injector', function($q, $window, $location, $injector) {
        return {
            'responseError': function(rejection, $rootScope) {
                if (rejection.status === 404) {}
                return $q.reject(rejection);
            }
        };
    }];
    $httpProvider.interceptors.push(interceptor401);
    $httpProvider.interceptors.push(interceptor400);
    $httpProvider.interceptors.push(interceptor404);

    angular.extend(toastrConfig, {
        positionClass: 'toast-bottom-right'
    });
    /**
     * Calendar default settings
     */
    // Use either moment or angular to format dates on the calendar. Default angular.
    // Setting this will override any date formats you have already set.
    calendarConfig.dateFormatter = 'moment';
    // This will configure times on the day view to display in 24 hour format rather than the default of 12 hour
    // calendarConfig.allDateFormats.moment.date.hour = 'HH:mm';
    // This will configure the day view title to be shorter
    calendarConfig.allDateFormats.moment.title.day = 'MM DD YYYY';
    // This will set the week number hover label on the month view
    calendarConfig.i18nStrings.weekNumber = 'Week {week}';
    // This will display all events on a month view even if they're not in the current month. Default false.
    calendarConfig.displayAllMonthEvents = true;
    // Make the week view more like the day view, ***with the caveat that event end times are ignored***.
    calendarConfig.showTimesOnWeekView = true;

}]).run(['$cookies', '$rootScope', '$http', '$location', 'UserService', '$window', function($cookies, $rootScope, $http, $location, UserService, $window) {
    //Quick fix for design
    //TUPID ANGULARJS
    $rootScope.currentUser = {};
    
    $rootScope.dateOptions = {
        showWeeks:false
    };

    $rootScope.$on('$locationChangeStart', function(event, next, current) {
        var userCookie = $cookies.getObject('userCookie');

        if (userCookie) {
            $http.defaults.headers.common.Authorization = 'Bearer ' + userCookie.token;
        }
        var publicPages = ['/login', '/home', '/registration', '/about', '/contact', '/registration-locum', '/locum_home', '/practice_home', '/resources', '/paypal','/view_locum', '/job_details', '/terms_and_conditions'];
        var restrictedPage = publicPages.indexOf($location.path()) === -1;
        
        if (userCookie) {
            if ($location.path() == '/locum' && (userCookie.role == "ROLE_OWNER" || userCookie.role == "ROLE_ADMIN")) {
                $location.path('/locum_home');
            }
            if ($location.path() == '/practice' && (userCookie.role == "ROLE_USER" || userCookie.role == "ROLE_ADMIN")) {
                $location.path('/practice_home');
            }
            if ($location.path() == '/admin' && userCookie.role != "ROLE_ADMIN") {
                $location.path('/home');
            }
            if (($location.path() == '/login' || $location.path() == '/registration' || $location.path() == '/registration-locum') && userCookie) {
                $location.path('/home');
            }
        }
        if (restrictedPage && !userCookie) {
            if ($location.path() == '/locum') {
                $location.path('/locum_home');
            } else if ($location.path() == '/practice') {
                $location.path('/practice_home');
            } else {
                $location.path('/login');
            }
        }
    });
    // $window.onbeforeunload = function() {
    //     $cookies.remove('userCookie');
    //     $cookies.remove('activeCalLoc');
    //     $cookies.remove('activeTabAccount');
    //     $cookies.remove('activeTabAccountPractice');
    //     $rootScope.currentUser = null;
    //     $http.defaults.headers.common = {};
    // }
}]);
angular.module('myApp').factory('UserService', ['$cookies', '$q', '$http', '$rootScope','toastr', function($cookies, $q, $http, $rootScope,toastr) {
    return {
        currentUser: function() {
            var defer = $q.defer();
            var userCookie = $cookies.getObject('userCookie');
            if(angular.isUndefined(userCookie)){
                this.logout();
            }
            var user = $http.get('/api/v1/token/check').then(response => {
                return response.data.entity;
            }).catch(error => {
            });

            defer.resolve(user);

            return defer.promise;
        },

        logout: function() {
            $cookies.remove('userCookie');
            $cookies.remove('activeCalLoc');
            $cookies.remove('activeTabAccount');
            $cookies.remove('activeTabAccountPractice');
            $rootScope.currentUser = null;
            $http.defaults.headers.common = {};
        }
    };
}]);