<div class="col-lg-3 col-md-6 col-sm-6 col-12 col-xs-12 mb-20 books-items">
    <div class="books-items-content">
        <div class="row pb-1 books-rats">
            <div class="col-lg-6 col-sm-6 col-6 text-white">
                <i class="fa fa-star text-green"></i> {{$post->calcRate()}}/5
            </div>
            <div class="col-lg-6 col-sm-6 col-6 text-green books-items-vots">
                {{$post->Rates()->count()}} {{trans('app.votes')}}
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <a href="{{$post->link()}}">
                    <img class="img-responsive" src="{{$post->mainImage('350x525','crope')}}">
                    <h5 class="pt-10 books-title">{{$post->title}}</h5>
                </a>
                <div class="pb-10 books-items-auth"><a class="text-green">{{$post->RelatedPost('Author')->title}}</a></div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="books-items-btn">
                    <a class="btn btn-light text-dark " href="{{$post->link()}}">{{trans('app.read now')}}</a>
                    <a class="btn books book-btn-download" download href="{{url('/uploads/files/'.$post->mainFile())}}"><i class="fa fa-download text-green"></i></a>
                    <a class="btn ajax-link book-btn-info" title="{{$post->title}}" target="modal" href="{{route('getInfoBySlug',$post->slug)}}"><i class="fa fa-info-circle text-green"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>