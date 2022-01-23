@section('title') 404 File Not Found ! @endsection

@extends('layouts.app')

@section('content')

<!--============== Page Banner Start ==============-->
<div class="page-banner-simple bg-secondary">
    <div class="container">
        <div class="row" style="padding: 100px 0">
            <div class="col-lg-6 col-md-6">
                <span class="banner-tagline d-table font-large text-primary mb-2">404</span>
                <h1 class="banner-title text-white">Error Page</h1>
            </div>
        </div>
    </div>
</div>
<!--============== Page Banner End ==============-->

<!--============== Faqs Start ==============-->
<div class="full-row">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error_area text-center">
                    <h1 class="page_error text_primary">404</h1>
                    <h5 class="my-4">Opps This Page Could Not Be Found !</h5>
                    <p>The Page you looking for does not appear to exist Please go back or<br> head on over our homepage to choose a new direction</p>
                    <a href="{{route('home')}}" class="btn btn-primary">Back To Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--============== Faqs End ==============-->
     

@endsection