<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" ng-app="myApp">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" type="text/css" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/bower_components/angular-input-stars-directive/angular-input-stars.css">

        <!-- Angular-loading-bar -->
        <link rel='stylesheet' href="bower_components/angular-loading-bar/build/loading-bar.min.css" type='text/css' media='all' />
        <link rel="stylesheet" type="text/css" href="bower_components/angular-toastr/dist/angular-toastr.css"/>
        <link rel="stylesheet" type="text/css" href="bower_components/SpinKit/css/spinners/7-three-bounce.css"/>

        <!-- CSS -->
        <link rel='stylesheet' href="angular/shared/style.css" type='text/css' media='all' />
        <link rel='stylesheet' href="angular/home/home.css" type='text/css' media='all' />
        <link rel="stylesheet" type="text/css" href="angular/login/login.css">
        <link rel="stylesheet" type="text/css" href="angular/registration/registration.css">
        <link rel="stylesheet" type="text/css" href="angular/resources/resources.css">
        <link rel='stylesheet' href="angular/locum/locum_find_a_job/locum_find_a_job.css" type='text/css' media='all' />
        <link rel='stylesheet' href="angular/locum/locum_profile/locum_profile.css" type='text/css' media='all' />
        <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.css"/>
        <link rel="stylesheet" type="text/css" href="angular/registration-locum/registration_locum.css">
        <link rel="stylesheet" type="text/css" href="angular/locum/locum_my_job/locum_my_job.css">
        <link rel="stylesheet" type="text/css" href="angular/locum/billing/billing.css">
        <link rel="stylesheet" type="text/css" href="angular/locum/job_details/job_details.css">
        <link rel="stylesheet" type="text/css" href="angular/practice/practice_billing/practice_billing.css">
        <link rel="stylesheet" type="text/css" href="angular/about_us/about_us.css">
        <link rel="stylesheet" type="text/css" href="angular/contact/contact.css">
        <link rel="stylesheet" type="text/css" href="angular/locum_home/locum_home.css">
        <link rel="stylesheet" type="text/css" href="angular/terms_and_conditions/terms_and_conditions.css">
        <link rel="stylesheet" type="text/css" href="angular/practice_home/practice_home.css">
        <link rel="stylesheet" type="text/css" href="angular/practice/practice_sessions/practice_sessions.css">
        <link rel="stylesheet" type="text/css" href="angular/admin/admin-add/admin.css">
        <link rel="stylesheet" type="text/css" href="angular/paypal/paypal.css">
        <link rel="stylesheet" type="text/css" href="bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"
        >
        <link href="bower_components/angular-bootstrap-calendar/dist/css/angular-bootstrap-calendar.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="angular/practice/practice_profile/practice_profile.css">
        <link rel="stylesheet" type="text/css" href="angular/practice/practice_my_dashboard/practice_my_dashboard.css">
        <link rel="stylesheet" type="text/css" href="angular/practice/practice_create_job/practice_create_job.css">
        <link rel="stylesheet" type="text/css" href="bower_components/fullcalendar/dist/fullcalendar.css">
        <link rel="stylesheet" type="text/css" href="angular/admin/admin-list-view/admin_list_view.css">
        <link rel="stylesheet" href="bower_components/animate.css/animate.min.css">
        <link rel="stylesheet" type="text/css" href="bower_components/angular-bootstrap/ui-bootstrap-csp.css">
    </head>

    <body>
        <div ng-view autoscroll="true"></div>
    </body>
    
    <!-- angular -->
    <script src="/bower_components/angular/angular.min.js"></script>
    <script src="/bower_components/angular-route/angular-route.min.js"></script>
    <script type='text/javascript' src="bower_components/angular-loading-bar/build/loading-bar.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-toastr/dist/angular-toastr.tpls.js"></script>

    <!-- bootstrap -->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>
    <script src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/bower_components/ngmap/build/scripts/ng-map.min.js"></script>
    <script src="http://maps.google.com/maps/api/js"></script>

    <script src='//maps.googleapis.com/maps/api/js'></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/bower_components/angular-cookies/angular-cookies.min.js"></script>
    <script type='text/javascript' src='/bower_components/ngInfiniteScroll/build/ng-infinite-scroll.min.js'></script>
    <script src="/bower_components/angular-spinner/dist/angular-spinner.min.js"></script>

    <script src="bower_components/angular-bootstrap-calendar/dist/js/angular-bootstrap-calendar-tpls.min.js"></script>
    <script type="text/javascript" src="bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script type="text/javascript" src="bower_components/fullcalendar/dist/gcal.js"></script>
    <script src="../src/calendar.js"></script>

    <!-- loading -->
    <script src="bower_components/angular-spinner/dist/angular-spinner.min.js"></script>
    <script src="bower_components/angular-input-stars-directive/angular-input-stars.js"></script>
    <script src="bower_components/ng-file-upload/ng-file-upload-shim.min.js"></script> <!-- for no html5 browsers support -->
    <script src="bower_components/ng-file-upload/ng-file-upload.min.js"></script>
    <script src="bower_components/angular-ui-mask/dist/mask.js"></script>
    <script src="bower_components/angular-messages/angular-messages.min.js"></script>
    <script src="bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>

    <!-- pages -->
    <script src="angular/shared/app.js"></script>
    <script src="angular/shared/filters.js"></script>
    <script src="angular/home/home.controller.js"></script>
    <script src="angular/home/home.service.js"></script>
    <script src="angular/login/login.controller.js"></script>
    <script src="angular/login/login.service.js"></script>
    <script src="angular/registration/registration.controller.js"></script>
    <script src="angular/registration/registration.service.js"></script>
    <script src="angular/about_us/about_us.controller.js"></script>
    <script src="angular/about_us/about_us.service.js"></script>
    <script src="angular/locum/locum_find_a_job/locum_find_a_job.controller.js"></script>
    <script src="angular/locum/locum_find_a_job/locum_find_a_job.service.js"></script>
    <script src="angular/locum/locum_profile/locum_profile.controller.js"></script>
    <script src="angular/locum/locum_profile/locum_profile.service.js"></script>
    <script src="angular/practice/practice_profile/practice_profile.controller.js"></script>
    <script src="angular/practice/practice_profile/practice_profile.service.js"></script>
    <script src="angular/practice/practice_my_dashboard/practice_my_dashboard.controller.js"></script>
    <script src="angular/practice/practice_my_dashboard/practice_my_dashboard.service.js"></script>
    <script src="angular/practice/practice_billing/practice_billing.controller.js"></script>
    <script src="angular/practice/practice_billing/practice_billing.service.js"></script>
    <script src="angular/practice/practice_sessions/practice_sessions.controller.js"></script>
    <script src="angular/practice/practice_sessions/practice_sessions.service.js"></script>
    <script src="angular/practice/practice_create_job/practice_create_job.controller.js"></script>
    <script src="angular/practice/practice_create_job/practice_create_job.service.js"></script>
    <script src="angular/resources/resources.controller.js"></script>
    <script src="angular/resources/resources.service.js"></script>
    <script src="angular/payment/payment.controller.js"></script>
    <script src="angular/payment/payment.service.js"></script>
    <script src="angular/public_job_details/job_details.controller.js"></script>
    <script src="angular/public_job_details/job_details.service.js"></script>
    <script src="angular/contact/contact.controller.js"></script>
    <script src="angular/contact/contact.service.js"></script>
    <script src="angular/registration-locum/registration_locum.controller.js"></script>
    <script src="angular/registration-locum/registration_locum.service.js"></script>
    <script src="angular/locum/billing/billing.controller.js"></script>
    <script src="angular/locum/billing/billing.service.js"></script>
    <script src="angular/locum/locum_my_job/locum_my_job.controller.js"></script>
    <script src="angular/locum/locum_my_job/locum_my_job.service.js"></script>
    <script src="angular/locum/job_details/job_details.controller.js"></script>
    <script src="angular/locum/job_details/job_details.service.js"></script>
    <script src="angular/practice/job_details/job_details_practice.controller.js"></script>
    <script src="angular/practice/job_details/job_details_practice.service.js"></script>
    <script src="angular/locum_home/locum_home.controller.js"></script>
    <script src="angular/locum_home/locum_home.service.js"></script>
    <script src="angular/practice_home/practice_home.controller.js"></script>
    <script src="angular/practice_home/practice_home.service.js"></script>
    <script src="angular/practice/view_locum/view_locum.controller.js"></script>
    <script src="angular/practice/view_locum/view_locum.service.js"></script>
    <script src="angular/locum/view_practice/view_practice.controller.js"></script>
    <script src="angular/locum/view_practice/view_practice.service.js"></script>

    <script src="angular/terms_and_conditions/terms_and_conditions.controller.js"></script>
    <script src="angular/terms_and_conditions/terms_and_conditions.service.js"></script>
    
    <script type="text/javascript" src="angular/shared/function.js"></script>
    <script type="text/javascript" src="angular/admin/admin-add/admin.controller.js"></script>
    <script type="text/javascript" src="angular/admin/admin-add/admin.service.js"></script>
    <script type="text/javascript" src="angular/admin/admin-list-view/admin_list_view.controller.js"></script>
    <script type="text/javascript" src="angular/admin/admin-list-view/admin-list-view.service.js"></script>
    <script type="text/javascript" src="angular/practice/practice_all_jobs/practice_all_jobs.controller.js"></script>
    <script type="text/javascript" src="angular/practice/practice_all_jobs/practice_all_jobs.service.js"></script>
    <script type="text/javascript" src="angular/paypal/paypal.controller.js"></script>
</html>
