@extends('layouts.app')
@section('title', trans('app.register'))
@section('css')
@if(app()->getLocale()=="ar")
    <link href="/front/css/wizard/style-rtl.css" rel="stylesheet">
@else
    <link href="/front/css/wizard/style.css" rel="stylesheet">

@endif
<style>
    .steps  {
    display: none;
}
</style>
@endsection

@section('content')
<div class="page-title-area bg-5" style="background-image: url(https://academy.web-egy.com/uploads/images/crope/1200x500/15a68_contactUs.jpg);">
    <div class="container">
        <div class="page-title-content">
            <h2 style="color: #fff;">{{trans('app.register')}}</h2>
            <ul>
                <li><a href="/{{app()->getLocale()}}" style="color: #fff;">{{trans('app.home')}} </a></li>
                <li class="active">{{trans('app.register')}}</li>
            </ul>
        </div>
    </div>
</div>

<!-- Start Log In Area -->
<section class="user-area-style ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!--<div class="section-title">-->
                <!--    <h2><i class="fa fa-user-plus"></i> @if($type=='teacher') {{trans('app.Register as a')}}{{trans('app.teacher')}} @else  {{trans('app.Register as a')}}{{trans('app.student')}} @endif</h2>-->
                <!--</div>-->
                
                <div class="contact-form-action wizard-v1-content">
                    <div class="wizard-form">
                         @if($errors->any())
                            <div class="alert alert-danger">
                            <!--{{print_r($errors)}}-->
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{route('register')}}" id="form-register" class="form-register">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="type" value="{{ $type }}">
                    <div id="form-total">
                        <h2>
			            	<span class="step-icon">1</span>
			            	<!--<span class="step-number">0</span>-->
			            	<span class="step-text"> مدرس ام طالب؟</span>
			            </h2>
			             <section>
			                <div class="inner">
                        <div class="col-sm-12" style="text-align: center;margin: 20px 0;">
                            <h1>أنت علي بعد خطوة من الإنضمام إلى فريق اونلاين أكاديميا</h1>
                            <h1>سجل كـ ...</h1>
                            <div class="row" style="width:70%;margin:auto">
                                <div class="col-sm-12 col-md-5 col-lg-5"> 
                                <a href="#"  class="default-btn select-teacher-btn">
                                    {{trans('app.teacher')}}
                                </a>
                                </div>
                                    <div class="col-sm-12 col-md-2 col-lg-2">
                                        <span style="padding:0px 30px">أو</span>
                                    </div>
                                    
                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                        <a href="#" class="default-btn select-student-btn">
                                            {{trans('app.student')}}
                                        </a>
                                </div>
                            </div>
                           
                            

                            
                        </div>
                        
                          <div class="col-sm-12 text-center">
                            <p>لديك حساب بالفعل؟  <a href="{{route('login')}}">{{trans('app.login')}}!</a></p>
                        </div>
                    </div>
                    </section>
                    
                          
                            <!-- SECTION 1 -->
			            <h2>
			            	<span class="step-icon">2</span>
			            	<!--<span class="step-number">1</span>-->
			            	<span class="step-text">{{trans('app.Personal Info')}}</span>
			            </h2>
			            <section>
			                <div class="inner">

                                <div class="col-sm-12">
                                     <h1 class="contenue-teacher">الاستمرار ك{{trans('app.teacher')}}</h1>
                                     <h1 class="contenue-student">الاستمرار ك{{trans('app.student')}}</h1>
                                     <a href="#" class="select-student-btn not-teacher" >لست {{trans('app.teacher')}}؟ سجل ك{{trans('app.student')}} </a>
                                     <a href="#" class="select-teacher-btn not-student" >لست {{trans('app.student')}}؟ سجل ك{{trans('app.teacher')}} </a>

                                <fieldset class="row">
                                    <legend>{{trans('app.Personal Info')}}</legend>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        <label>{{trans('app.first_name')}} <span class="required">*</span></label>
                                        <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>
                                        @if ($errors->has('first_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        <label>{{trans('app.last_name')}} <span class="required">*</span></label>
                                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>
                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label>{{trans('app.phone')}} <span class="required">*</span> 
                                            <small style="color:#999;">({{trans('app.Enabled with WhatsApp service')}})</small></label>
                                        <input id="phone" type="tel" class="form-control" name="phone" value="{{ old('phone') }}" required >
                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>     
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label>{{trans('app.email')}} <span class="required">*</span> <small>{Example:test@test.com}</small></label>
                                        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                  
                                
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label>{{trans('app.password')}} <span class="required">*</span></label>
                                        <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{trans('app.confirm password')}} <span class="required">*</span></label>
                                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                                    
                                </fieldset>
                               
                                </div>
                                </div>
                        </section>
                         <h2>
			            	<span class="step-icon">3</span>
			            	<!--<span class="step-number">3</span>-->
			            	<span class="step-text">{{trans('app.Education Details')}} / {{trans('app.Contact Details')}} </span>
			            </h2>
			            <section>
			                <div class="inner">

                                   <div class="col-sm-12" >
                                     <h1 class="contenue-teacher">الاستمرار ك{{trans('app.teacher')}}</h1>
                                     <h1 class="contenue-student">الاستمرار ك{{trans('app.student')}}</h1>
                                     <a href="#" class="select-student-btn not-teacher" >لست {{trans('app.teacher')}}؟ سجل ك{{trans('app.student')}} </a>
                                     <a href="#" class="select-teacher-btn not-student" >لست {{trans('app.student')}}؟ سجل ك{{trans('app.teacher')}} </a>

                                <fieldset class="row">
                                    <legend>{{trans('app.Education Details')}} </legend>
                                       <div class="col-sm-6" >
                                            <div class="form-group{{ $errors->has('educational_id') ? ' has-error' : '' }}">
                                                <label></label>
                                                <select name="educational_id" id="educational_id" class="form-control nice--select" placeholder="{{trans('app.Grade')}}*">
                                                    <option></option>
                                                    @php($list=App\Models\Educational::all() )
                                                    @foreach($list as $item)
                                                        <option value="{{$item->id}}" > {{$item->name}}</option>
                                                    @endforeach
                                                </select>                                               
                                                @if ($errors->has('educational_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('educational_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                       <div class="col-sm-6" >
                                            <div class="form-group{{ $errors->has('department_id') ? ' has-error' : '' }}">
                                                <label></label>
                                                <select name="department_id" id="department_id" class="form-control nice--select" placeholder="{{trans('app.Department')}}*">
                                                    <option></option>
                                                    @php($list=App\Models\Department::all() )
                                                    @foreach($list as $item)
                                                        <option value="{{$item->id}}" > {{$item->name}}</option>
                                                    @endforeach
                                                </select>                                               
                                                @if ($errors->has('department_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('department_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                       <div class="col-sm-6" >
                                            <div class="form-group{{ $errors->has('speciality_id') ? ' has-error' : '' }}">
                                                <label>{{trans('app.speciality')}}</label>
                                                <select name="speciality_id" class="form-control nice--select" placeholder="{{trans('app.speciality')}}*">
                                                    <option></option>
                                                    @php($list=App\Models\Speciality::all() )
                                                    @foreach($list as $item)
                                                        <option value="{{$item->id}}" > {{$item->name}}</option>
                                                    @endforeach
                                                </select>                                               
                                                @if ($errors->has('speciality_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('speciality_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group{{ $errors->has('school') ? ' has-error' : '' }}">
                                            <label>{{trans('app.school')}}</label>
                                            <input id="school" type="text" class="form-control" name="school" value="{{ old('school') }}" />
                                            @if ($errors->has('school'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('school') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                   
                                </fieldset>
                                    </div>
               <!--                     </div>-->
               <!--                     </section>-->
               <!--          <h2>-->
			            <!--	<span class="step-icon">5</span>-->
			            	<!--<span class="step-number">4</span>-->
			            <!--	<span class="step-text">{{trans('app.Contact Details')}}</span>-->
			            <!--</h2>-->
			            <!--<section>-->
			            <!--    <div class="inner">-->

                                       <div class="col-sm-12" >
                                     <!--<h1 class="contenue-teacher">الاستمرار ك{{trans('app.teacher')}}</h1>-->
                                     <!--<h1 class="contenue-student">الاستمرار ك{{trans('app.student')}}</h1>-->
                                     <!--<a href="#" class="select-student-btn not-teacher" >لست {{trans('app.teacher')}}؟ سجل ك{{trans('app.student')}} </a>-->
                                     <!--<a href="#" class="select-teacher-btn not-student" >لست {{trans('app.student')}}؟ سجل ك{{trans('app.teacher')}} </a>-->

                                <fieldset class="row">
                                    <legend>{{trans('app.Contact Details')}}</legend>
                                     <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('country_id') ? ' has-error' : '' }}">
                                        <label>{{trans('app.country')}}</label>
                                            <select name="country_id" class="form-control nice--select" 
                                                data-live-search="true" data-show-subtext="true" placeholder="{{trans('app.country')}}*">
                                                <option></option>
                                                @php($countries=App\Models\Country::all() )
                                                @foreach($countries as $country)
                                                    <option value="{{$country->id}}" > {{$country->name}}</option>
                                                @endforeach
                                            </select>
                                             @if ($errors->has('country_id'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('country_id') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('city_id') ? ' has-error' : '' }}">
                                        <label>{{trans('app.city')}}</label>
                                        <select name="city_id" class="form-control  nice--select" 
                                            data-live-search="true" data-show-subtext="true" placeholder="{{trans('app.city')}}*">
                                            <option></option>
                                        </select>
                                         @if ($errors->has('city_id'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('city_id') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('area') ? ' has-error' : '' }}">
                                        <label>{{trans('app.area')}}</label>
                                        <input id="area" type="text" class="form-control" name="area" value="{{ old('area') }}" required >
                                         @if ($errors->has('area'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('area') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                   <div class="col-sm-6" >
                                            <div class="form-group {{ $errors->has('father_mobile') ? ' has-error' : '' }}">
                                                <label>@if($type=='teacher'){{trans('app.other_phone')}} @else {{trans('app.father_mobile')}} @endif 
                                                    <small style="color:#999;">({{trans('app.Enabled with WhatsApp service')}})</small></label>
                                                <input id="father_mobile" type="tel" class="form-control" name="father_mobile" value="{{ old('father_mobile') }}" >
                                                @if ($errors->has('father_mobile'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('father_mobile') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    <div class="col-sm-12">
                                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                                            <label>{{trans('app.address')}} <small style="color:#999;">({{trans('app.address_note')}})</small></label>
                                            <textarea id="address" rows="2" class="form-control" name="address" required >{{ old('address') }}</textarea>
                                            @if ($errors->has('address'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                     <div class="col-sm-6">
                                     <div class="form-group" style="padding-right: 20px;">
                                            <input type="checkbox" class="form-check-input" id="agree" name="agree">
                                        <label class="form-check-label w-100" for="agree">
                                        اوافق على 
                                        <a href="#"  data-toggle="modal" data-target="#modlPrivacy">سياسة الخصوصية</a>
                                        و <a href="#"  data-toggle="modal" data-target="#modlTerms">الشروط والأحكام</a>
                                        </label>
                                      </div>
                                  </div>
                               
                                </fieldset>
                                    </div>
                                    
                                </div>
                                
                                <!--<div class="col-sm-12" style="margin-top:20px;">-->
                                <!--    <div class="row align-items-center">-->
                                <!--        <div class="col-lg-6 col-sm-6">-->
                                <!--            <button type="submit" class="default-btn register" type="submit">{{trans ('app.submit')}}</button>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                </section>

                               
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

  <!-- Modal -->
@if($post=Func::getPageBySlug('privacy-policy'))
<div id="modlPrivacy" class="modal  fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h1 class="modal-title">{{$post->title}}</h1>
      </div>
      <div class="modal-body">
        {!! $post->body!!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endif

  <!-- Modal -->
@if($post=Func::getPageBySlug('terms'))
<div id="modlTerms" class="modal  fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h1 class="modal-title">{{$post->title}}</h1>
      </div>
      <div class="modal-body">
        {!! $post->body!!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endif

<!-- End Log In Area -->
@endsection

@section('js')
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script src="{{asset('/front/js/wizard/jquery.steps.js')}}"></script>
	<script src="{{asset('/front/js/wizard/main.js')}}"></script>
<script>
$(document).ready(function () {
    $("select[name=country_id]").change(function(){
      var $this=$(this);
      var $cities=$("select[name=city_id]");
        
        $cities.html("<option>Loading ...</option>");
        $cities.niceSelect('update');
        $.ajax({type:'get',                
            headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
            url:"/{{app()->getLocale()}}/cities/"+$this.val(),
            dataType:'json',
            success:function(res){
                $cities.html("");
                res.data.forEach(element => {
                    $cities.append("<option value='"+element.id+"'>"+element.name+"</option>");
                });
                // $cities.trigger("chosen:updated");
                $cities.niceSelect('update');
            }
        });
    });
    
    // $(".teacher").click(function(e){
    //     $(".show-form").show();
    //     //$(".student").disabled();
    //     $('.student').prop('disabled', true);
    // });

    $(".select-teacher-btn").click(function(e){
        e.preventDefault();
        $("input[name=type]").val('teacher');
        $("#form-total").steps("setStep",1); 
        // $("#form-total-t-1").click();
        loadRegisterForm('teacher');
    });
    $(".select-student-btn").click(function(e){
        e.preventDefault();
        $("input[name=type]").val('student');
       $("#form-total").steps("setStep",1); 
        loadRegisterForm('student');
    });
    
    $("input,select,textarea").focusin(function(){
        var placement = $(this).closest(".form-group");
          if (placement) {
            placement.removeClass("has-error");
            $(placement).find(".help-block").remove();
          }
    })
    $(".actions ul li:eq(1)").addClass("disbaled").hide();
    @if($type)
     loadRegisterForm('{{$type}}');
      $("#form-total").steps("next");  
    @endif
    
    window.scrollTo(0, 0); 
});
function loadRegisterForm(type){
    $("#educational_id").closest(".form-group").find("label").html((type=='teacher'?'{{trans("app.Grade_teacher")}}':'{{trans("app.Grade_student")}}'));
    $("#department_id").closest(".form-group").find("label").html((type=='teacher'?'{{trans("app.Department_teacher")}}':'{{trans("app.Department_student")}}'));
    $("#father_mobile").closest(".form-group").find("label").html((type=='teacher'?'{{trans("app.other_phone")}}' : '{{trans("app.father_mobile")}}'));
    
    $("#school").closest(".col-sm-6").css({'display':(type=='student'?'block':'none')});
    $("#address").closest(".col-sm-12").css({'display':(type=='teacher'?'block':'none')});
    
    $(".contenue-teacher").css({'display':(type=='teacher'?'block':'none')});
    $(".contenue-student").css({'display':(type=='student'?'block':'none')});
    $(".not-teacher").css({'display':(type=='teacher'?'block':'none')});
    $(".not-student").css({'display':(type=='student'?'block':'none')});
    
    
}
</script>
@endsection
