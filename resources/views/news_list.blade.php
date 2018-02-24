@extends('layouts.app')
@push('style')
<!-- Fonts -->
<link rel="stylesheet" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="/bower_components/angular-input-stars-directive/angular-input-stars.css">

<!-- Angular-loading-bar -->
<link rel='stylesheet' href="bower_components/angular-loading-bar/build/loading-bar.min.css" type='text/css' media='all' />
<link rel="stylesheet" type="text/css" href="bower_components/angular-toastr/dist/angular-toastr.css"/>
<link rel="stylesheet" type="text/css" href="bower_components/angular-bootstrap/ui-bootstrap-csp.css"/>

<link rel="stylesheet" type="text/css" href="angular/admin/admin-add/admin.css">
<link rel="stylesheet" type="text/css" href="angular/admin/admin-list-view/admin_list_view.css">

<link rel="stylesheet" type="text/css" href="bower_components/angular-bootstrap/ui-bootstrap-csp.css">
<link rel="stylesheet" type="text/css" href="bower_components/SpinKit/css/spinners/7-three-bounce.css"/>
@endpush
@section('content')

<div ng-view ng-app="myApp" ng-controller="AdminListViewController">
    <div class="container">
        <div class="row">
            {{Auth::check()}}
            <div class="col-xs-12">
                <h1>
                    News list
                </h1>
            </div>
            <div class="latest-vacancies-description col-xs-12">
                <p>
                    Here you can add news and it will be displayed on Website.
                </p>
            </div>
            <div class="col-xs-12">
                <div class="line">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 new-list-all">
                <div class="header-meni-create-corp">
                    <p class="text-header-corporation col-xs-7"><i class="fa fa-building-o create-corp-icon" aria-hidden="true"></i>Create News</p>
                    <button class="btn btn-default pull-right btn-create-corporation create-corporation-heading-btn custom-add-margin" data-target="#addNewsModal" data-toggle="modal">Add</button>
                </div> <!-- infinite-scroll="getNextNews(nextPageUrlNews)" infinite-scroll-use-document-bottom="true -->
                <div class="row">
                    <div class="col-md-12">
                        <div ng-repeat="single in news track by $index" class="panel-default ng-isolate-scope panel size-panel-news" is-open="false" is-disabled="false">
                            <div role="tab" id="accordiongroup-92-6918-tab" aria-selected="false" class="panel-heading" ng-keypress="toggleOpen($event)">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" href="" aria-expanded="false" aria-controls="accordiongroup-92-6918-panel" class="accordion-toggle"  ng-disabled="isDisabled" ><span  ng-class="{'text-muted': isDisabled}" class="ng-binding">
                                        <div class="row ng-scope">
                                            <div class="col-xs-12 col-md-7 span-date sessions-text">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <span class="text-capitalize"><p><% single.title %></p></span>
                                                    </div>
                                                    <div class="col-xs-12 content-news">
                                                        <span class="text-capitalize"></span><p class="ng-binding" style="color: #99abb4;"><% single.content %></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-5 text-right pull-right">
                                                <button class="btn create-your-acc-btn sign-up-btn search-btn-filters pull-right admin-header-btn edit-delete-news delete-btn-news col-md-2" type="submit" ng-click="deleteNews(single.id,$index)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                <button data-target="#editNewsModal" data-toggle="modal" class="btn create-your-acc-btn sign-up-btn edit-delete-news search-btn-filters pull-right edit-btn-news col-md-2" type="submit" ng-click="getNewsPopup(single.id)"><i class="fa fa-pencil" aria-hidden="true" style="margin-right:5px"></i>Edit</button>
                                            </div>
                                        </div>
                                    </span></a>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" ng-hide="news==0 && !showLoader">
                    <div class="col-xs-12">
                        <div class=pull-right >
                            <ul uib-pagination total-items="single.bigTotalItems" ng-model="single.bigCurrentPage" max-size="5" class="pagination-sm" boundary-link-numbers="true" ng-change="pageChanged()" items-per-page="single.maxSize">
                            </ul>
                        </div>
                    </div>
                </div>

                <div ng-if="news==0 && !showLoader" class="col-xs-12 text-center">
                    <h3 class="media-heading no-results-found" style="margin-top:50px;">No results found</h3>
                    <div class="text-center my-job-nosearch">
                        <img src="img/nosearch.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sk-three-bounce" ng-if="showLoader">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
    <div class="modal fade" id="editNewsModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times exit-popup" aria-hidden="true"></i></button>
                    <h4 class="modal-title">Editing - <% single.title %></h4>
                </div>
                <div class="modal-body">
                    <form id="edit-news" method="post" name="myForm">
                        {{csrf_field()}}
                        <div>
                            <img class="media-object picture-media-object images-avatar" ng-src="<%single.avatar%>">
                            <h4>Upload on file select</h4>
                            <button type="file" ngf-select="uploadFiles($file, $invalidFiles)"
                                    accept="image/*" ngf-max-size="1MB">
                                Select File</button>
                            <br><br>
                            <div style="font:smaller">
                                File:<%f.name%>
                                <p style="color:red;"><%errFile.name%> <%errFile.$error%></p>
                            </div>
                            <%errorMsg%>
                        </div>
                        <div ng-class="{'has-error': !single.title || single.title==''}" class="form-group col-xs-12 col-sm-12">
                            <p>Title</p>
                            <input type="text" style="margin-bottom:0px" class="form-control edit-overview popup-mail input-border-address1" placeholder="Subject" aria-describedby="inputGroupSuccess4Status" required ng-model="single.title" value="<% single.title %>">
                        </div>
                        <div ng-class="{'has-error': !single.content || single.content==''}" class="form-group col-xs-12 col-sm-12">
                            <p>Description</p>
                            <textarea style="margin-bottom:0px" placeholder="Description" class="form-control edit-overview popup-mail" rows="6" ng-model="single.content" required><% single.content %></textarea>
                        </div>
                        <div ng-class="{'has-error': !single.url || single.url==''}" class="form-group col-xs-12 col-sm-12">
                            <p>See more url</p>
                            <input type="text" style="margin-bottom:0px" class="form-control edit-overview popup-mail input-border-address1" placeholder="Url" aria-describedby="inputGroupSuccess4Status" required ng-model="single.url" value="<% single.url %>">
                        </div>
                        <div class="radio-btns-news col-xs-12">
                            <p>Who can see your news?</p>
                            <input class="pull-left radio-btn-news-create" type="radio" ng-checked="single.for_both" name="locum" value="both" ng-model="single.both" ><span class="text-radio-news">Both</span> <br>
                            <input class="pull-left radio-btn-news-create" type="radio" ng-checked="single.for_locum" name="locum" value="locum" ng-model="single.locum"><span class="text-radio-news">Locum</span> <br>
                            <input class="pull-left radio-btn-news-create" type="radio" ng-checked="single.for_practice" name="locum" value="practice" ng-model="single.practice"><span class="text-radio-news">Practice</span>
                        </div>
                        <center>
                            <button ng-disabled="myForm.$invalid" type="submit" class="btn create-your-acc-btn send-popup" ng-click="editNewsPopup(single)" data-dismiss="modal">Save</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addNewsModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times exit-popup" aria-hidden="true"></i></button>
                    <h4 class="modal-title">Create news form</h4>
                </div>
                <div class="modal-body">
                    <form id="edit-news" method="post" name="addForm">
                        {{csrf_field()}}
                        <div ng-class="{'has-error': !new.title || new.title==''}" class="form-group col-xs-12 col-sm-12">
                            <p>Title</p>
                            <input type="text" style="margin-bottom:0px" class="form-control edit-overview popup-mail input-border-address1" placeholder="Subject" aria-describedby="inputGroupSuccess4Status" required ng-model="new.title">
                        </div>
                        <div ng-class="{'has-error': !new.content || new.content==''}" class="form-group col-xs-12 col-sm-12">
                            <p>Description</p>
                            <textarea style="margin-bottom:0px" placeholder="Description" class="form-control edit-overview popup-mail" rows="6" ng-model="new.content" required></textarea>
                        </div>
                        <div ng-class="{'has-error': !new.url || new.url==''}" class="form-group col-xs-12 col-sm-12">
                            <p>See more url</p>
                            <input type="text" style="margin-bottom:0px" class="form-control edit-overview popup-mail input-border-address1" placeholder="Url" aria-describedby="inputGroupSuccess4Status" required ng-model="new.url">
                        </div>
                        <div class="radio-btns-news col-xs-12">
                            <p>Who can see your news?</p>
                            <input class="pull-left radio-btn-news-create" type="radio" ng-checked="new.for_locum && new.for_practice" name="locum" value="both" ng-model="new.both" ><span class="text-radio-news">Both</span> <br>
                            <input class="pull-left radio-btn-news-create" type="radio" ng-checked="new.for_locum" name="locum" value="locum" ng-model="new.locum"><span class="text-radio-news">Locum</span> <br>
                            <input class="pull-left radio-btn-news-create" type="radio" ng-checked="new.for_practice" name="locum" value="practice" ng-model="new.practice"><span class="text-radio-news">Practice</span>
                        </div>
                        <center>
                            <button ng-disabled="addForm.$invalid" type="submit" class="btn create-your-acc-btn send-popup" ng-click="newsPost(new)" data-dismiss="modal">Save</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- angular -->
<script src="/bower_components/angular/angular.min.js"></script>
<script type='text/javascript' src="bower_components/angular-loading-bar/build/loading-bar.min.js"></script>
<script type="text/javascript" src="bower_components/angular-toastr/dist/angular-toastr.tpls.js"></script>
<script src="/bower_components/angular-spinner/dist/angular-spinner.min.js"></script>
<script type='text/javascript' src='/bower_components/ngInfiniteScroll/build/ng-infinite-scroll.min.js'></script>

<!-- bootstrap -->
<script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>

<script src="bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>

<script type="text/javascript" src="/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>

<!-- loading -->
<script src="bower_components/angular-spinner/dist/angular-spinner.min.js"></script>
<script src="bower_components/angular-input-stars-directive/angular-input-stars.js"></script>
<script src="bower_components/ng-file-upload/ng-file-upload-shim.min.js"></script> <!-- for no html5 browsers support -->
<script src="bower_components/ng-file-upload/ng-file-upload.min.js"></script>

<!-- pages -->
<script >
    angular.module('myApp',['AdminListViewControllers','AdminListViewServices','ui.bootstrap','toastr','angularSpinner','infinite-scroll','ngFileUpload'], function($interpolateProvider) {
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