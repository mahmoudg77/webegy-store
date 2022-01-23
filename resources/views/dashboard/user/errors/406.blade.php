@section('title') 406 Not Acceptable ! @endsection

@extends('layouts.app')

@section('content')
<!-- Banner area -->
<section class="page-header">
<div class="container">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h3> 406 Not Acceptable!</h3>
            <p class="page-breadcrumb">
            </p>
        </div>
    </div> 
</div> 
</section> 
<!-- End Banner area -->

<section class="section-content-block section-our-team section-pure-white-bg ">
    <div class="container wow fadeInUp">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
                <div class="single-team-details">
                    <article class="team-info">
                        <h3>406 Not Acceptable !</h3>                                   
                     </article> 
                    <div class="four-zero-four-container">
                            <div class="error-code">406</div>
                            <div class="error-message">This Feature Not Acceptable Now.</div>
                            <div class="button-place">
                                <a href="{{url('/')}}" class="btn btn-default btn-lg waves-effect">GO TO HOMEPAGE</a>
                            </div>
                        </div>
                 </div>
            </div>
        </div>
    </div>
</section>

     

@endsection