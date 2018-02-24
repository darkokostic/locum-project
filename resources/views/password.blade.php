@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Change password</div>
                    <form action="{{ url('corporation/password/edit') }}" method="post" >
                        <div class="panel-body">
                            <div class="form-group ">
                                <label for="example-text-input" class="col-2 col-form-label">Current password</label>
                                <div class="col-10">
                                    <input class="form-control" type="password" placeholder="*******" name="current">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-search-input" class="col-2 col-form-label">New password</label>
                                <div class="col-10">
                                    <input class="form-control" type="password" placeholder="******" name="new">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Change</button>
                                </div>
                            </div>
                            {{ csrf_field() }}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection