<nav class="col-lg-12 col-md-12 navbar navbar-default menu-nav-bar navbar_no_board locum-nav-bar hidden-xs" ng-if="checkForURLHeader()">
    <div class="container-fluid menu-bar menu-bar-locum">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed hover-burger" data-toggle="collapse" data-target="#practice-desktop-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo logo-locum" href="#"><img src="../img/logo-locum.png" class="img-responsive" alt="Responsive image"/></a>
        </div>
        <div class="collapse navbar-collapse response-nav-bar-xs" id="practice-desktop-navbar-collapse">
            <ul class="nav navbar-nav navbar_font nav-bar-response-locum nav-bar-locum">
                <li class="@{{activeClassesForNavbarPractice[0]}} navbar-locum-menu"><a href="/#!/practice/practice_my_dashboard" ng-click="clickToChangeHeaderPractice(1);clickToChangeActiveTabOnPracticeNavbar(0)">My dashboard<span class="sr-only">(current)</span></a></li>
                <li class="@{{activeClassesForNavbarPractice[1]}} navbar-locum-menu"><a href="/#!/practice/practice_sessions" ng-click="clickToChangeHeaderPractice(2);clickToChangeActiveTabOnPracticeNavbar(1)">Sessions</a></li>
                <li class="@{{activeClassesForNavbarPractice[2]}} navbar-locum-menu"><a href="/#!/practice/practice_create_job" ng-click="clickToChangeHeaderPractice(3);clickToChangeActiveTabOnPracticeNavbar(2)">Create a job</a></li>
                <li class="@{{activeClassesForNavbarPractice[3]}} navbar-locum-menu"><a href="/#!/practice/practice_billing" ng-click="clickToChangeHeaderPractice(4);clickToChangeActiveTabOnPracticeNavbar(3)">Billing</a></li>
                <li class="@{{activeClassesForNavbarPractice[5]}} navbar-locum-menu"><a href="/#!/practice/practice_all_jobs" ng-click="clickToChangeHeaderPractice(5);clickToChangeActiveTabOnPracticeNavbar(5)">All Jobs</a></li>
            </ul>
            <ul class="nav navbar-nav navbar_font navbar-right nav-bar-response-locum logging nav-bar-locum">
                <li class="navbar-locum-menu"><a href="/#!/home" ng-click="clearCookies()">Home</a></li>
                <li class="@{{activeClassesForNavbarPractice[4]}} navbar-locum-menu"><a href="/#!/practice" ng-click="clickToChangeActiveTabOnPracticeNavbar(4)">Your Account</a></li>
                <li class="navbar-locum-menu"><a href="#" ng-click="logout()"><i class="fa fa-unlock-alt lock-logout" aria-hidden="true" ></i>Logout</a></li>
                <!-- <li>
                    <div class="btn-group language-group-btn">
                        <button id="nav" type="button" class="btn dropdown-toggle create-your-acc-btn custom_create_account sign-up-btn language-btn langugae-btn-locum" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <div class="container menu-bar-2-locum col-xs-12 col-md-10 col-md-offset-2 col-lg-offset-1" ng-if="style=='yourAccPractice'">
        <ul class="nav nav-tabs border-nav-tabs-locum locum-nav-2">
            <li role="presentation" class="@{{activeClassesForAccInformationPractice[0]}} menu-bar-2-active"><a href="/#!/practice" ng-click="clickToChangeActiveTabOnYourAccountPractice(0)">Profile</a></li>
            <li role="presentation" class="@{{activeClassesForAccInformationPractice[1]}} menu-bar-2-active profile-btn-locum-menu"><a href="/#!/practice" ng-click="clickToChangeActiveTabOnYourAccountPractice(1)">Feedback</a></li>
            <li role="presentation" class="@{{activeClassesForAccInformationPractice[2]}} menu-bar-2-active profile-btn-locum-menu"><a href="/#!/practice" ng-click="clickToChangeActiveTabOnYourAccountPractice(2)">Availability</a></li>
        </ul>
    </div>
    <div class="container menu-bar-2-locum col-xs-12 col-md-10 col-md-offset-2 col-lg-offset-1" ng-if="style=='myDashboardPractice'">
        <ul class="nav nav-tabs border-nav-tabs-locum locum-nav-2">
            <li role="presentation" class="active menu-bar-2-active"><a href="/#!/practice/practice_my_dashboard">My dashboard</a></li>
        </ul>
    </div>
    <div class="container menu-bar-2-locum col-xs-12 col-md-10 col-md-offset-2 col-lg-offset-1" ng-if="style=='session'">
        <ul class="nav nav-tabs border-nav-tabs-locum locum-nav-2">
            <li role="presentation" class="active menu-bar-2-active"><a href="/#!/practice/practice_sessions">Sessions</a></li>
        </ul>
    </div>
    <div class="container menu-bar-2-locum col-xs-12 col-md-10 col-md-offset-2 col-lg-offset-1" ng-if="style=='create_a_job'">
        <ul class="nav nav-tabs border-nav-tabs-locum locum-nav-2">
            <li role="presentation" class="active menu-bar-2-active"><a href="/#!/practice/practice_create_job">Create a job</a></li>
        </ul>
    </div>
    <div class="container menu-bar-2-locum col-xs-12 col-md-10 col-md-offset-2 col-lg-offset-1" ng-if="style=='billing'">
        <ul class="nav nav-tabs border-nav-tabs-locum locum-nav-2">
            <li role="presentation" class="active menu-bar-2-active"><a href="/#!/practice/practice_billing">Billing</a></li>
        </ul>
    </div>
    <div class="container menu-bar-2-locum col-xs-12 col-md-10 col-md-offset-2 col-lg-offset-1" ng-if="style=='all'">
        <ul class="nav nav-tabs border-nav-tabs-locum locum-nav-2">
            <li role="presentation" class="active menu-bar-2-active"><a href="/#!/practice/practice_all_jobs">All Jobs</a></li>
        </ul>
    </div>
</nav>