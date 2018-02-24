<div class="container-fluid footer" ng-if="checkForURLFooter()">
    <div class="text-center">
        <img src="{{ asset('img/logo-footer-2.png') }}" class="img-responsive center-block" alt="Responsive image"/></a>
        <p class="company-address">Address of company | Number 02037718411</p>
    </div>
    <div class="row">
        <div class="footer-big-text-div col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-offset-0 col-xs-12">
            <div class="text-center footer-text col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <p class="latest-news">Latest News</p>
                <p>HOME Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
            </div>
            <div class="text-center footer-text col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <p class="latest-news">latest Vacancies</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
            </div>
            <div class="text-center footer-text col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <p class="latest-news">About us</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
            </div>
            <div class="text-center footer-text col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <p class="latest-news">Terms and Services</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
                <p>Lorem Ipsum 1</p>
            </div>
        </div>
    </div>
    <div class="text-center">
        <img ng-src="@{{activeImageFacebook}}" class="footer-icons" ng-mouseover="activeImageFacebook='../img/facebook-active.png'" ng-mouseout="activeImageFacebook='../img/facebook-img.png'">
        <img ng-src="@{{activeImageIn}}" class="footer-icons" ng-mouseover="activeImageIn='../img/linkedin-active.png'" ng-mouseout="activeImageIn='../img/linkedin.png'">
        <img ng-src="@{{activeImageTwitter}}" class="footer-icons" ng-mouseover="activeImageTwitter='../img/twitter-active.png'" ng-mouseout="activeImageTwitter='../img/twitter.png'">
        <img ng-src="@{{activeImageYoutube}}" class="footer-icons" ng-mouseover="activeImageYoutube='../img/youtube-active.png'" ng-mouseout="activeImageYoutube='../img/youtube.png'">
        <p class="copyright">Copyright 2017 © Locum OD. All rights  reserved. </p>
    </div>
</div>