@extends('layouts.app')

@section('content')
<!-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('corporation/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <center>
                <div class="login-form1">
                    <div class="row login-form">
                        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1" id="loginFormHolder">
                            <div class="row padding-login">
                                <form name="loginForm" role="form" method="POST" action="{{ route('corporation/login') }}">
                                    {{ csrf_field() }}
                                    <div class="col-xs-12 header-login-text">
                                        <h2>
                                            Sign in
                                        </h2>
                                        <p>
                                            If you have account, quickly sign in.
                                        </p>
                                        <img src="../../img/login-line.jpg">
                                        </img>
                                    </div>
                                    <div class="col-xs-12">
                                        <div id="email-input" class="input-login hover-query {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <div class="col-xs-4 col-sm-2 email-input-admin">
                                                <i aria-hidden="true" class="fa fa-envelope-o">
                                                    <span>
                                                        Email
                                                    </span>
                                                </i>
                                            </div>
                                            <div class="col-xs-8 col-sm-9">
                                                <input autocomplete="off" id="username" name="email" placeholder="example@gmail.com" type="email" required autofocus>
                                                </input>
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div id="email-input" class="input-login hover-query {{ $errors->has('password') ? ' has-error' : '' }}">
                                            <div class="col-xs-5 col-sm-3 password-input-admin">
                                                <i aria-hidden="true" class="fa fa-lock">
                                                    <span>
                                                        Password
                                                    </span>
                                                </i>
                                            </div>
                                            <div class="col-xs-7 col-sm-9">
                                                <input id="password" name="password" placeholder="*********" type="password" required>
                                                </input>
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- <div class="row check-box-forgot-pw forgot-pw-admin">
                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                <div class="checkbox">
                                                    <label style="font-size: 1em">
                                                        <input id="remember" type="checkbox" value="">
                                                            <span class="cr">
                                                                <i class="cr-icon fa fa-check">
                                                                </i>
                                                            </span>
                                                            Remember me
                                                        </input>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                <a class="forgot-password pull-right transitions" href=""> 
                                                    Forgot password?
                                                </a>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="">
                                        <div class="col-lg-12 sign-in-button admin-sign-in">
                                            <button class="btn btn-danger btn-sign-in transitions" type="submit">
                                                Sign in
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>
@endsection
