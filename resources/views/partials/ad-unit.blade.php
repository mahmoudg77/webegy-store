@if($ad=App\Models\Post::where('post_type_id',20)->where('is_published',1)->whereSlug($slug)->first())
<div class="full-row pt-20">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="ads">{!! $ad->body !!}</div>
            </div>
        </div>
    </div>
</div>
@endif