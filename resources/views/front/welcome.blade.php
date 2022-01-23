@extends('layouts.app')

@section('title'){{Setting::getIfExists('site_name')}}@endsection
@section('description'){{Setting::getIfExists('site_desc')}}@endsection

@section('content')

@include('partials.home.news')
@include('partials.ad-unit',['slug'=>'ad-home-1'])

@include('partials.home.tv')
@include('partials.ad-unit',['slug'=>'ad-home-2'])

@include('partials.home.services')
@include('partials.ad-unit',['slug'=>'ad-home-3'])

@include('partials.home.contact')
@include('partials.ad-unit',['slug'=>'ad-home-4'])

@endsection
