
<!--============== Footer Section Start ==============-->
<footer class="full-row pt-50 footer-default-dark bg-footer footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-12 col-xs-12">
                <div class="footer-widget contact-widget mb-4">
                    <h3 class="widget-title mb-4"><img src="{{ asset('front/img/logo.png')}}" class="img-responsive" width="120"/></h3>
                    <div class="footer-ceo pb-10">
                        <span class="text-primary">{{trans('app.ceo')}}</span>
                        <br>
                        <h6>{{Setting::getIfExists('ceo')}}</h6>
                    </div>
                    <ul>
                        <li><a href="https://www.google.com/maps/search/{{Setting::getIfExists('site_address')}}"><i class="fa fa-map-marker"></i> <span class="text-white">{{Setting::getIfExists('site_address')}}</span></a></li>
					    <li><a href="https://www.google.com/maps/search/{{Setting::getIfExists('site_address_2')}}"><i class="fa fa-map-marker"></i> <span class="text-white">{{Setting::getIfExists('site_address_2')}}</span></a></li>
                        <li><i class="fa fa-envelope-o"></i> <a href="mailto:{{Setting::getIfExists('emails_default')}}" style="color:#fff">{{Setting::getIfExists('emails_default')}}</a></li>
                        <li><i class="fa fa-phone"></i> <a href="tel:+{{Setting::getIfExists('site_phone')}}" style="color:#fff">{{Setting::getIfExists('site_phone')}}</a></li>
                    </ul>
                </div>
                <div class="footer-widget media-widget mb-4">
                    <ul class="list-inline socila-footer">
                    @foreach(Func::menu('footer_social') as $sl)
                        {!!  Func::drowMenuLink($sl)!!}
                    @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-6 col-xs-6">
                <div class="footer-widget footer-nav mb-4">
                    <h3 class="widget-title mb-4">{{trans('app.sitemap')}}</h3>
                    <ul>
                        @foreach(Func::menu('quick_links_footer') as $sl)
                            {!!  Func::drowMenuLink($sl)!!}
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 col-6 col-xs-6">
                <div class="footer-widget footer-nav mb-4">
                    <h3 class="widget-title mb-4">{{trans('app.news')}}</h3>
                    @if($cats=\App\Models\Category::where('parent_id',60)->orderBy('id','asc')->get())
                    <ul>
                        @foreach($cats as $post)
                            <li><a href="{{route('categoryBySlug',$post->slug)}}" class="">{{$post->title}}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-12 col-xs-12">
                <div class="footer-widget footer-nav mb-4">
                    <h3 class="widget-title mb-4">{{trans('app.tv network')}}</h3>
                    @if($cats=\App\Models\Category::where('parent_id',54)->orderBy('id','asc')->get())
                    <ul>
                        @foreach($cats as $post)
                            <li><a href="{{route('categoryBySlug',$post->slug)}}" class="">{{$post->title}}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!--============== Copyright Section Start ==============-->
    <div class="copyright text-default py-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <span class="text-dark">{{trans('app.copyright')}} {{Setting::getIfExists('site_name')}} </span> 
                    <span class="text-dark"> - </span>
                    <span class="text-dark">
                        {{trans('app.Developed')}} <a href="https://web-egy.com" target="_blank">{{trans('app.web-egy')}}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!--============== Copyright Section End ==============-->
</footer>
<div class="modal" id="bookmodal" tabindex="-1" role="dialog">
  <div class="modal-dialog " role="document">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('app.Close')}}</button>
      </div>
    </div>
  </div>
</div>
    <!-- Scroll to top -->
    <a href="#" class="text-general scroll-top-vertical xs-mx-none" id="scroll"><i class="fa fa-arrow-circle-up"></i></a>
	<!-- End Scroll To top -->
<!--============== Footer Section End ==============-->
