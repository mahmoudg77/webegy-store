@extends('layouts.app')
@section('title'){{trans('app.contact-us')}}@endsection

@section('content')

<!--============== Contact form Start ==============-->
<div class="full-row pt-50 contact">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 ">
                <div class="d-flex mb-3">
                    <ul class="contact-info">
                        <li class="mb-3 text-white"><i class="fa fa-map-marker"></i> {{Setting::getIfExists('site_address')}}</li>
                        <li class="mb-3 text-white"><i class="fa fa-map-marker"></i> {{Setting::getIfExists('site_address_2')}}</li>
                        <li class="mb-3 text-white"><i class="fa fa-envelope-o"></i> <a href="mailto:{{Setting::getIfExists('emails_default')}}" style="color:#fff">{{Setting::getIfExists('emails_default')}}</a></li>
                        <li class="mb-3 text-white"><i class="fa fa-phone"></i> <a href="tel:{{Setting::getIfExists('site_phone')}}" style="color:#fff">{{Setting::getIfExists('site_phone')}}</a></li>
                    </ul>
                </div>
                <div class="form-group mb-3 about">
                    <ul class="list-inline socila-footer">
                        @foreach(Func::menu('footer_social') as $sl)
                            {!!  Func::drowMenuLink($sl)!!}
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6">
                <div class="form-simple mb-5">
                    {{Form::model(null, ['route'=>["contact.store"],"method"=>"POST","class"=>"contact-form","id"=>"contactForm"])}}
                        <div class="form-row">
                            <div class="col-md-6 mb-20">
                                <input type="text" class="form-control bg-gray" id="name" name="first_name" required placeholder="{{trans('app.first-name')}}"/>
                            </div>
                            <div class="col-md-6 mb-20">
                                <input type="text" class="form-control bg-gray" id="last_name" name="last_name" required placeholder="{{trans('app.last-name')}}" />
                            </div>
                            <div class="col-md-12 mb-20">
                                <input type="email" class="form-control bg-gray" id="email" name="email" placeholder="{{trans('app.email')}}" />
                            </div>

                            <div class="col-md-12 mb-20">
                                <textarea class="form-control bg-gray" cols="30" rows="8" name="message" id="message" placeholder="{{trans('app.message')}}"></textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary w-100">{{trans('app.contact-send')}}</button>
                                <div id="contact-result" class="h3 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
            
        </div>
    </div>
</div>
<!--============== Contact form End ==============-->

@endsection

