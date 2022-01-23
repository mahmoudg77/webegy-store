@extends('layouts.app')

@section('content')

<div class="page-title-area bg-5">
			<div class="container">
				<div class="page-title-content">
					<h2>{{trans('app.register')}}</h2>
					<ul>
						<li>
							<a href="/">
								{{trans('app.home')}} 
							</a>
						</li>

						<li class="active">{{trans('app.register')}}</li>
					</ul>
				</div>
			</div>
		</div>
		<section class="contact-info-area pt-100 pb-70">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="contact-wrap contact-pages mb-0">
							<div class="contact-form">
								<div class="section-title">
									<h2>{{trans('app.Registration-msg')}}</h2>
									<p> {{trans('app.Registration-desc')}}<br/><a class="default-btn" href="/{{app()->getLocale()}}/login">{{trans('app.login')}}</a> </p>
										
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
<section class="contact-info-area pt-100 pb-70">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-sm-6">
				<div class="single-contact-info">
					<i class="flaticon-call"></i>
					<h3>{{trans('app.Call Us')}}</h3>
					<a href="tel:{{Setting::getIfExists('site_phone')}}">{{trans('app.phone')}} :{{Setting::getIfExists('site_phone')}}</a>
				</div>
			</div>

			<div class="col-lg-4 col-sm-6">
				<div class="single-contact-info">
					<i class="flaticon-pin"></i>
					<h3>{{trans('app.Our location')}}</h3>
					<a href="#">{{Setting::getIfExists('site_address')}}</a>
				</div>
			</div>

			<div class="col-lg-4 col-sm-6 offset-sm-3 offset-lg-0">
				<div class="single-contact-info">
					<i class="flaticon-email"></i>
					<h3>{{trans('app.email')}}</h3>
					<a href="mailto:{{Setting::getIfExists('emails_default')}}">{{Setting::getIfExists('emails_default')}}</a>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
