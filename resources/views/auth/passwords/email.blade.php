@extends('layouts.app')
@section('title', trans('app.forgot password')) 

@section('content')

<!-- Start Page Title Area -->
<header class="services">
	<div class="item" style="background-image: url({{ asset('front/img/contact.png')}});">
		<div class="cover">
			<div class="container">
				
				<div class="header-content">
				    <img src="{{ asset('front/img/box-shadow.png')}}" class="box-shadow"/>
                    <h1>{{trans ('app.forgot password')}}</h1>
				</div>
			</div>
			</div>
	</div>                    
</header> 
<!-- End Page Title Area -->



<!-- Start Log In Area -->
<section class="user-area-style ptb-100">
    <div class="container">
        <div class="log-in-area" style="padding: 40px 270px;margin-bottom: 50px;">
            <div class="section-title"><h2 class="text-center">{{trans ('app.forgot password')}}</h2></div>
            <div class="contact-form-action">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}
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
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-primary" type="submit">{{trans('app.reset my password')}}</button>
                        </div>
                        <div class="col-6 text-right">
                            <div class="login-action">
                                <span class="forgot-login">
                                    <a href="{{ route('login') }}">{{trans ('app.login')}}</a>
                                </span>
                            </div>
                        </div>                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- End Log In Area -->
@endsection

