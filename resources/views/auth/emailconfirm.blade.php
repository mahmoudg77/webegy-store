@extends('layouts.app')

@section('content')

<section style="background: #edf0f2;">
<div class='container'>
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class='panel panel-default' style="margin: 100px auto;">
                    <div class='panel-heading text-center'>Registration Confirmed</div>
                    <div class='panel-body text-center'>
                        Your Email is successfully verified. Click here to <a href="{{route('login')}}">login</a>
                    </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
