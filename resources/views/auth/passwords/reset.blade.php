@extends('layouts.app')
@section('title', trans('app.reset my password'))

@section('css')
<style>
.user-area-style .form-control{margin-bottom:10px;border:1px solid #eee;}
.user-area-style label {margin-bottom: 10px;}
.user-area-style .form-control:focus {box-shadow: 0 0 0 0.1rem rgba(0,123,255,.25);}
</style>
@endsection
@section('content')

<!-- Start Log In Area -->
<section class="user-area-style ptb-100">
    <div class="container">
        <div class="log-in-area" style="padding: 40px 270px;margin-bottom: 50px;">
            <div class="section-title"><h2 class="text-center">{{trans ('app.reset my password')}}</h2></div>
            <div class="contact-form-action">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                 @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                        {{ $error }}<br/>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{$token}}"/>
                        
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label>{{trans('app.email')}}</label>
                                <input id="email" type="email" class="form-control" name="email" placeholder="{{trans('app.email')}}"
                                    value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label>{{trans('app.password')}}</label>
                                <input id="password" type="password" class="form-control" name="password" placeholder="{{trans('app.password')}}" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label>{{trans('app.password_confirmation')}}</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="{{trans('app.password_confirmation')}}" required>
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="login-action">
                                <!-- <span class="log-rem">
                                    <input id="remember" type="checkbox">
                                    <label for="remember">Remember me!</label>
                                </span> -->
                                <span class="forgot-login">
                                    <a href="{{ route('login') }}">{{trans ('app.login')}}</a>
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <button class="default-btn" type="submit">{{trans('app.login')}}</button>
                        </div>

                        <!-- <div class="col-12">
                            <p>Have an account? <a href="registration.html">Registration Now!</a></p>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- End Log In Area -->
@endsection
