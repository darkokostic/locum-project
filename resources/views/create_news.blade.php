
@extends('layouts.app')
@push('style')
<!-- Fonts -->
<link rel="stylesheet" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="/bower_components/angular-input-stars-directive/angular-input-stars.css">

<!-- Angular-loading-bar -->
<link rel='stylesheet' href="bower_components/angular-loading-bar/build/loading-bar.min.css" type='text/css' media='all' />
<link rel="stylesheet" type="text/css" href="bower_components/angular-toastr/dist/angular-toastr.css"/>

<link rel="stylesheet" type="text/css" href="angular/admin/admin-add/admin.css">
<link rel="stylesheet" type="text/css" href="angular/admin/admin-list-view/admin_list_view.css">
@endpush
@section('content')
    <div ng-view ng-app="myApp" ng-controller="AdminController">
        <div class="container admin-panel">
            <div class="row">
                <div class="col-xs-12">
                    <h1 style="color:#000000 !important;">Add</h1>
                    <a class="col-sm-2 pull-right" href="{{ route('news_list') }}"><button class="btn create-your-acc-btn custom_create_account sign-up-btn search-btn-filters pull-right list-view-btn" type="submit">List view</button></a>
                </div>
                <div class=" col-xs-12 latest-vacancies-description">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                </div>
                <div class="col-xs-12">
                    <div class="line"></div>
                </div>
            </div>
            <center>
                <div class="row admin-header admin-news-content">
                    <form id="add-news" method="post" name="myForm"> 
                        <div>
                            <div ng-class="{'has-error': !news.title || adnews.title==''}">
                                <input placeholder="Title" type="text" name="" class="form-control edit-media-heading title-admin" ng-model="news.title" required>
                            </div>
                            <div ng-class="{'has-error': !news.content || adnews.content==''}">
                                <textarea placeholder="Description" class="form-control latest-vacancies-description edit-overview title-admin" ng-model="news.content" required></textarea>
                            </div>
                            <div class="radio-btns-news row">
                                <p class="latest-vacancies-description" style="text-align:left;margin-left: 15px;margin-bottom: 0px;">Who can se your news</p>
                                <input class="pull-left radio-btn-news-create" type="radio" name="locum" value="locum" ng-model="news.locum"><span class="text-radio-news">Locum</span> <br>
                                <input class="pull-left radio-btn-news-create" type="radio" name="locum" value="practice" ng-model="news.practice"><span class="text-radio-news">Practice</span><br>
                                <input class="pull-left radio-btn-news-create" ng-checked="true" type="radio" name="locum" value="both" ng-model="news.both" ><span class="text-radio-news">Locum and Practice</span>
                            </div>
                            {{csrf_field()}}
                        </div>
                        <div class="btn-save">
                            <button ng-disabled="myForm.$invalid" style="width: 100px !important; background-color: #ff8f00;" class="btn create-your-acc-btn custom_create_account sign-up-btn search-btn-filters save-admin-btn" type="submit" ng-click="newsPost(news)">Save</button>
                        </div>
                    </form>
                </div>
            </center>
        </div>
    </div>

    @push('scripts')
    <!-- angular -->
    <script src="bower_components/angular/angular.min.js"></script>
    <script type='text/javascript' src="bower_components/angular-loading-bar/build/loading-bar.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-toastr/dist/angular-toastr.tpls.js"></script>
    <script type="text/javascript" src="/bower_components/angular-cookies/angular-cookies.min.js"></script>
    <!-- bootstrap -->
    <script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>

    <script type="text/javascript" src="/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>

    <!-- loading -->
    <script src="bower_components/angular-spinner/dist/angular-spinner.min.js"></script>
    <script src="bower_components/angular-input-stars-directive/angular-input-stars.js"></script>

    <!-- pages -->
    <script >
        angular.module('myApp',['AdminControllers','AdminServices','toastr'], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });
    </script>
    <script type="text/javascript" src="angular/admin/admin-add/admin.controller.js"></script>
    <script type="text/javascript" src="angular/admin/admin-add/admin.service.js"></script>

    <script type="text/javascript" src="angular/admin/admin-list-view/admin-list-view.service.js"></script>
    <script type="text/javascript" src="angular/admin/admin-list-view/admin_list_view.controller.js"></script>
    @endpush
    @endsection
    </body>
</html>