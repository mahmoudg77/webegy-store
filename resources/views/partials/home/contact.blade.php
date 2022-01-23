<!-- Start Contact Area -->
<section class="full-row pt-20 pb-20 contact-home">
    <div class="container-fluid">
        <div class="row pb-30">
			<div class="col-lg-12">
				<h2 class="mb-4 text-center w-50 w-sm-100 mx-auto contact-header">{{trans('app.contact-us')}} <i class="fa fa-circle"></i></h2>
			</div>
		</div>
		<div class="row">
		    <div class="col-lg-7 col-md-6 ">
				<div class="d-flex mb-3 contact-data">
					<ul>
					    <li class="mb-3"><a href="https://www.google.com/maps/search/{{Setting::getIfExists('site_address')}}"><i class="fa fa-map-marker"></i> <span class="text-white">{{Setting::getIfExists('site_address')}}</span></a></li>
					    <li class="mb-3"><a href="https://www.google.com/maps/search/{{Setting::getIfExists('site_address_2')}}"><i class="fa fa-map-marker"></i> <span class="text-white">{{Setting::getIfExists('site_address_2')}}</span></a></li>
                        <li class="mb-3"><i class="fa fa-envelope-o"></i> <a href="mailto:{{Setting::getIfExists('emails_default')}}" style="color:#fff">{{Setting::getIfExists('emails_default')}}</a></li>
                        <li class="mb-3"><i class="fa fa-phone"></i> <a href="tel:+{{Setting::getIfExists('site_phone')}}" style="color:#fff">{{Setting::getIfExists('site_phone')}}</a></li>
                    </ul>
				</div>
				<div class="footer-widget media-widget mb-4 contact-socila">
                    <ul class="list-inline socila-footer">
                    @foreach(Func::menu('footer_social') as $sl)
                        {!!  Func::drowMenuLink($sl)!!}
                    @endforeach
                    </ul>
                </div>
			</div>
			
			<div class="col-lg-5 col-md-6">
				<div class="form-simple mb-5">
					{{Form::model(null, ['route'=>["contact.store"],"method"=>"POST","class"=>"contact-form form-icon-right"])}}
                    <div class="form-row">
                        <div class="col-6 mb-10">
                            <div class="form-group mb-20">
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="{{trans('app.first-name')}}"/>
                            </div>
                            <div class="text-danger {{ $errors->has('first_name') ? 'has-error' : '' }}">{{ $errors->first('first_name') }}</div>
                        </div>
                        <div class="col-6 mb-10">
                            <div class="form-group mb-20">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="{{trans('app.last-name')}}"/>
                            </div>
                            <div class="text-danger {{ $errors->has('last_name') ? 'has-error' : '' }}">{{ $errors->first('last_name') }}</div>
                        </div>
                        <div class="col-12 mb-10">
                            <div class="form-group mb-20">
                                <input type="email" class="form-control" id="email" name="email" placeholder="{{trans('app.email')}}"/>
                            </div>
                        </div>
                        <div class="col-12 mb-10">
                            <div class="form-group mb-20">
                                <textarea class="form-control" cols="30" rows="8" name="message" id="message" placeholder="{{trans('app.message')}}"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-20">
                                {{ Form::hidden('type_id', 4) }}
                                <button type="submit" class="btn btn-primary w-100">{{trans('app.contact-send')}}</button>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
				</div>
			</div>
		</div>
    </div>

</section>

<!-- End Contact Area -->