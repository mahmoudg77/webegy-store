<form action="" method="get" class="form-filter">
    <div class="form-row ">
         <div class="col-sm-12 col-md-2 col-4 col-xs-4 form-filter-select form-filter-cat">
            <select name="cat" placeholder="{{trans('app.category')}}" class="form-control selectpicker show-tick">
               <option value="{{$category->Parent?$category->Parent->slug:'blogs'}}">{{trans('app.Category')}}</option>
                @foreach($chields as $cat)
                <option {{$category->id==$cat->id?'selected':''}} value="{{$cat->slug}}">{{$cat->title}}</option>
                @endforeach
            
            </select>
        </div>
        <div class="col-sm-12 col-md-2 col-4 col-xs-4 form-filter-select">
            <select name="filter[created_at]" placeholder="{{trans('app.year')}}" class="form-control selectpicker show-tick">
                <option value="">{{trans('app.Year')}}</option>
                @for($n=2015;$n < 2022;$n++)
                    <option {{request()->has('filter') && request()->get('filter')['created_at']==$n?'selected':''}} value="{{$n}}">{{$n}}</option>
                    @endfor
                </select>
        </div>
        <div class="col-sm-12 col-md-2 col-4 col-xs-4 form-filter-select">
            <input type="hidden" name="sort" value="id">
            <input type="hidden" name="type" value="{{$type}}">
            <select name="sort_dir" class="form-control selectpicker show-tick">
                <option {{request()->get('sort_dir')=='desc'?'selected':''}} value="desc">{{trans('app.Newest')}}</option>
                <option {{request()->get('sort_dir')=='asc'?'selected':''}} value="asc">{{trans('app.Oldest')}}</option>
            </select>
        </div>
        <div class="col-sm-12 col-md-6 col-12 col-xs-12 form-filter-search">
           <i class="fa fa-search"></i> 
           <input class="form-control" name="q" placeholder="{{trans('app.search')}}" value="{{request()->get('q')}}">
        </div>
    </div>
</form>