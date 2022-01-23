@extends('layouts.app')
@section('title', trans('app.login'))

@section('content')


<!--============== Signup Form Start ==============-->
<div class="full-row pt-50 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 mx-auto">
                <div class="bg-wh2ite p-50 border rounded">
                    <div class="form-icon-left rounded form-boder">
                        <h4 class="mb-4">{{trans ('app.login')}}</h4>
                        <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12 mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="mb-2 text-white">{{trans('app.email')}}</label>
                                    <input type="email" name="email" class="form-control bg-light" value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-12 mb-3 {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="mb-2 text-white">{{trans('app.password')}}</label>
                                    <input type="password" name="password" class="form-control bg-light" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-12 mb-3">
                                    <button class="btn btn-primary mb-3" type="submit">{{trans ('app.login')}}</button>
                                </div>
                                <div class="col-md-12">
                                    <a href="{{ route('password.request') }}" class="btn-link text-white d-table py-1">{{trans ('app.forgot-password')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--============== Signup Form End ==============-->

@endsection