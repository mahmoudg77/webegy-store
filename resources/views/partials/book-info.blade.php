<h2 class="mb-2 book-info-title">{{$book->title}}</h2>

<div class="rate mb-3">
    <i class="fa fa-star-o"></i>
    <i class="fa fa-star-o"></i>
    <i class="fa fa-star-o"></i>
    <i class="fa fa-star-o"></i>
    <i class="fa fa-star-o"></i>
</div>
<div class="single-book-items">
    <div>
        <label style="width:150px">{{trans('app.author')}}:</label>
        <a href="{{$book->RelatedPost('Author')->link()}}" class="hover-green">{{$book->RelatedPost('Author')->title}}</a>
    </div>
    <div>
        <label style="width:150px">{{trans('app.category')}}:</label>
        <a href="{{$book->Category->link()}}" class="hover-green">{{$book->Category->title}}</a>
    </div>
    <div>
        <label style="width:150px">{{trans('app.size')}}:</label>
        <span class="text-green">{{round($book->Files()->first()->size/1000000,2)}} MB</span>
    </div>
    <div>
        <label style="width:150px">{{trans('app.year')}}:</label>
        <span class="text-green">{{$book->RelatedPost('Year')}}</span>
    </div>
    <div>
        <label style="width:150px">{{trans('app.pages')}}:</label>
        <span class="text-green">{{$book->RelatedPost('Pages')}}</span>
    </div>
    <div>
        <label style="width:150px">{{trans('app.rate')}}:</label>
        <span class="text-green">{{$book->calcRate()}}/5</span>
    </div>
    <div>
        <label style="width:150px">{{trans('app.votes')}}:</label>
        <span class="text-green">{{$book->Rates()->count()}}</span>
    </div>
    <div>
        <label style="width:150px">{{trans('app.language')}}:</label>
        <span class="text-green">{{ array_key_exists($book->RelatedPost('Language'),config('languages'))?config('languages')[$book->RelatedPost('Language')]:$book->RelatedPost('Language')}}</span>
    </div>
    <div>
        <label style="width:150px">{{trans('app.publisher')}}:</label>
        <span class="text-green">{{$book->RelatedPost('Publisher')->title}}</span>
    </div>
    <div class="single-book-btn">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-light text-dark" href="{{$book->link()}}_pdf">{{trans('app.read now')}}</a>
                <a class="btn btn-dow2nload book-btn-download" download href="{{url('/uploads/files/'.$book->mainFile())}}"><i class="fa fa-download fa-2x text-green"></i></a>
            </div>
            <div class="col-12 pt-20 book_social">
                @if($book->PostType->can_share)
                    <div style="display:inline" class="addthis_inline_share_toolbox_biwn"></div>
                @endif
            </div>
        </div>

    </div>
    
</div>