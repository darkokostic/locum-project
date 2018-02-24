<nav class="col-lg-12 col-md-12 navbar navbar-default menu-nav-bar navbar_no_board locum-nav-bar visible-xs" ng-if="checkForURLHeader()">
    <div class="container-fluid menu-bar menu-bar-locum">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed hover-burger" data-toggle="collapse" data-target="#locum-mobile-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo logo-locum" href="#"><img src="../img/logo-locum.png" class="img-responsive" alt="Responsive image"/></a>
        </div>
        <div class="collapse navbar-collapse response-nav-bar-xs" id="locum-mobile-navbar-collapse" ng-init="init()">
            <ul class="nav navbar-nav navbar_font nav-bar-response-locum nav-bar-locum">
                <li class="@{{activeClassesForNavbar[0]}} navbar-locum-menu"><a href="/#!/locum/locum_my_job" ng-click="clickToChangeHeader(2);clickToChangeActiveTabOnLocumNavbar(0)">My jobs<span class="sr-only">(current)</span></a></li>
                <li class="@{{activeClassesForNavbar[1]}} navbar-locum-menu"><a href="/#!/locum/locum_find_a_job" ng-click="clickToChangeHeader(1);clickToChangeActiveTabOnLocumNavbar(1)">Find a job</a></li>
                <li class="@{{activeClassesForNavbar[2]}} navbar-locum-menu"><a href="/#!/locum/billing" ng-click="clickToChangeHeader(3);clickToChangeActiveTabOnLocumNavbar(2)">Billing</a></li>
            </ul>
            <ul class="nav navbar-nav navbar_font navbar-right nav-bar-response-locum logging nav-bar-locum">
                <li class="navbar-locum-menu"><a href="/#!/home" ng-click="clearCookies()">Home</a></li>
            <ul class="nav navbar-nav navbar_font navbar-right logging nav-bar-locum">
                <li class="@{{activeClassesForNavbar[3]}} navbar-locum-menu"><a href="/#!/locum" ng-click=";clickToChangeActiveTabOnLocumNavbar(3)">Your Account</a></li>
                <li class="navbar-locum-menu"><a href="#" ng-click="logout()"><i class="fa fa-unlock-alt lock-logout" aria-hidden="true" ></i>Logout</a></li>
                <!-- <li>
                    <div class="btn-group language-group-btn">
                        <button type="button" class="btn dropdown-toggle create-your-acc-btn custom_create_account sign-up-btn language-btn langugae-btn-locum" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            En <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu drop-down-language">
                            <li><a href="#">Text</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                </li> -->
            </ul>
        </div>
    </div><!-- /.container-fluid -->
    <div class="container menu-bar-2-locum col-xs-12 col-md-10 col-md-offset-2 col-lg-offset-1" ng-if="style=='profile'" >
        <ul class="nav nav-tabs border-nav-tabs-locum locum-nav-2">
            <li role="presentation" class="@{{activeClassesForAccInformation[0]}} menu-bar-2-active"><a href="/#!/locum" ng-click="clickToChangeActiveTabOnYourAccount(0)">Profile</a></li>
            <li role="presentation" class="@{{activeClassesForAccInformation[2]}} menu-bar-2-active profile-btn-locum-menu"><a href="/#!/locum" ng-click="clickToChangeActiveTabOnYourAccount(2)">Feedback</a></li>
            <li role="presentation" class="@{{activeClassesForAccInformation[1]}} menu-bar-2-active profile-btn-locum-menu"><a href="/#!/locum" ng-click="clickToChangeActiveTabOnYourAccount(1)">Availability</a></li>
        </ul>
    </div>
    <div class="container menu-bar-2-locum col-xs-12 col-md-10 col-md-offset-2 col-lg-offset-1" ng-if="style=='find_a_job'">
        <ul class="nav nav-tabs border-nav-tabs-locum locum-nav-2">
            <li class="active menu-bar-2-active profile-btn-locum-menu" role="presentation"><a href="/#!/locum">Find a job</a></li>
        </ul>
    </div>
    <div class="container menu-bar-2-locum col-xs-12 col-md-10 col-md-offset-2 col-lg-offset-1" ng-if="style=='myJob'" >
        <ul class="nav nav-tabs border-nav-tabs-locum locum-nav-2">
            <li role="presentation" class="@{{activeClassesForMyJobs[0]}} menu-bar-2-active"><a href="/#!/locum/locum_my_job" ng-click="clickToChangeActiveTabOnMyJobs(0)">Applications</a></li>
            <li role="presentation" class="@{{activeClassesForMyJobs[1]}} menu-bar-2-active profile-btn-locum-menu"><a href="/#!/locum/locum_my_job" ng-click="clickToChangeActiveTabOnMyJobs(1)">Booked Jobs</a></li>
            <li role="presentation" class="@{{activeClassesForMyJobs[2]}} menu-bar-2-active profile-btn-locum-menu"><a href="/#!/locum/locum_my_job" ng-click="clickToChangeActiveTabOnMyJobs(2)">Completed</a></li>
        </ul>
    </div>
    <div class="container menu-bar-2-locum col-xs-12 col-md-10 col-md-offset-2 col-lg-offset-1" ng-if="style=='billing'">
        <ul class="nav nav-tabs border-nav-tabs-locum locum-nav-2">
        </ul>
    </div>
</nav>