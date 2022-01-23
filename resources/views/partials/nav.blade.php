<!--============== Header Section Start ==============-->
<header class="nav-on-top bg-dark shadow-sm">
    <div class="main-nav py-2 xs-p-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg nav-secondary nav-primary-hover nav-line-active">
                        <a class="navbar-brand mr-5" href="{{route('home')}}">
                            <img class="nav-logo" src="{{ asset('front/img/logo.png')}}" alt="{{Setting::getIfExists('site_name')}}">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" 
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon flaticon-menu flat-small text-primary"></span>
                        </button>
                        <div class="collapse navbar-collapse sm-ml-0" id="navbarSupportedContent">
                            
                        <ul class="navbar-nav m{{(app()->getLocale()=='ar')?"r":'l'}}-auto">
                            @foreach(Func::menu('main') as $link)
                            {!!Func::drowMenuLink($link,['li'=>'nav-item','a'=>'nav-link'])!!}
                            @endforeach        
                            <li class="nav-item lang" style="display: inline-flex;">
                               @foreach(config('translatable.locales') as $lang)
                                <a class="nav-link {{app()->getLocale()==$lang?'active':''}}" href="/{{$lang}}/lang" style="padding: 0 3px !important;">{{strtoupper($lang)}}</a>
                            @endforeach 
                            </li>
                        </ul>
                            
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!--============== Header Section End ==============-->

@section('js')

<script>
$(document).ready(function(){
  $('ul li a').click(function(){
    $('li').removeClass("active");
    $(this).addClass("active");
    });
});
</script>
@endsection
