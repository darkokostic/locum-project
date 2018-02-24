<nav class="col-lg-12 col-md-12 navbar navbar-default menu-nav-bar navbar_no_board visible-xs" ng-if="checkForURLHeader()">
    <div class="container-fluid menu-bar menu-home-page">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed dugme" data-toggle="collapse" data-target="#home-mobile-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo-home-page" href="#"><img src="../img/logo.png" class="img-responsive" alt="Responsive image"/></a>
        </div>
        <div class="collapse navbar-collapse" id="home-mobile-navbar-collapse">
            <ul class="nav navbar-nav navbar_font home-menu-hover">
                <li class="@{{activeClassesForHomeNavbar[0]}}"><a href="/#!/home" ng-click="clickToChangeActiveTabOnHomeNavbar(0)">Home<span class="sr-only">(current)</span></a></li>
                <li class="@{{activeClassesForHomeNavbar[1]}}"><a href="/#!/about" ng-click="clickToChangeActiveTabOnHomeNavbar(1)">About Us</a></li>
                <li class="@{{activeClassesForHomeNavbar[2]}}"><a href="/#!/locum" ng-click="clickToChangeActiveTabOnHomeNavbar(2)">Locum</a></li>
                <li class="@{{activeClassesForHomeNavbar[3]}}"><a href="/#!/practice" ng-click="clickToChangeActiveTabOnHomeNavbar(3)">Practice</a></li>
                <li class="@{{activeClassesForHomeNavbar[4]}}"><a href="/#!/resources" ng-click="clickToChangeActiveTabOnHomeNavbar(4)">Resource</a></li>
                <li class="@{{activeClassesForHomeNavbar[5]}}"><a href="/#!/contact" ng-click="clickToChangeActiveTabOnHomeNavbar(5)">Contact Us</a></li>
                <li class="@{{activeClassesForHomeNavbar[6]}}" ng-if="!signInOrLogout"><a href="/#!/login" ng-click="loginPage();">Sign in</a></li>
                <li ng-if="signInOrLogout" ng-click="logout()"><a href="/#!/login">Logout</a></li>
                <li ng-if="!signInOrLogout"><button class="btn create-your-acc-btn custom_create_account sign-up-btn" ng-click="registerPage()" type="button">Sign up</button></li>
            </ul>
            <ul class="nav navbar-nav navbar_font navbar-right logging login-home">
                <li class="@{{activeClassesForHomeNavbar[6]}}" ng-if="!signInOrLogout"><a href="/#!/login" ng-click="loginPage();">Sign in</a></li>
                <li ng-if="signInOrLogout" ng-click="logout()"><a href="/#!/login">Logout</a></li>
                <li ng-if="!signInOrLogout"><button class="btn create-your-acc-btn custom_create_account sign-up-btn" ng-click="registerPage()" type="button">Sign up</button></li>
                <!-- <li>
                    <div class="btn-group language-group-btn">
                        <button type="button" class="btn dropdown-toggle create-your-acc-btn custom_create_account sign-up-btn language-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            En <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
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
</nav>