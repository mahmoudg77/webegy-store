@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-{{(app()->getLocale()=='ar')?'right':'left'}}">
                    <li class="breadcrumb-item"><a href="{{route('cp.dashboard')}}">{{trans('app.home')}}</a></li>
                    <li class="breadcrumb-item active">{{trans("cp.{$postType->name}")}}</li>
                </ol>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                @if(isset($filter_cats))
                <!-- Example single danger button -->
                <div class="btn-group category-list  float-sm-{{(app()->getLocale()=='ar')?'left':'right'}}">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{trans('cp.all')}}
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item"
                            data-type="{{$post_type_id}}" data-cat="0" href="#">{{trans('cp.all')}}</a>

                        @foreach($filter_cats as $category)
                        <a class="dropdown-item {{($category->id==$cat->id)?'active':''}}"
                            data-type="{{$post_type_id}}" data-cat="{{$category->id}}" href="#">{{$category->title}}</a>
                        @if($category->Chields()->count()>0)
                        @foreach($category->Chields as $c)
                        <a class="dropdown-item {{($c->id==$cat->id)?'active':''}}"
                            data-type="{{$post_type_id}}" data-cat="{{$c->id}}" href="#">{{$category->title}}\{{$c->title}}</a>

                        @endforeach
                        <div class="dropdown-divider"></div>

                        @endif
                        @endforeach
                        {{-- <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="#">Separated link</a>
                        --}}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <a class="btn btn-primary btn-sm"
            href="{{route('cp.posts.create',['post_type_id'=>$post_type_id,'curr_menu'=>$sel_menu,'related'=>Request::get('related')])}}">{{trans('app.create New')}}</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        @if(Request::has('related'))
        <div class="row">

            @foreach(Request::get('related') as $key=>$value)
            <div class="col-12">
                <strong>{{trans("cp.{$key}")}} : </strong>
                @if($p=\App\Models\PostTypeProperty::where('post_type_id',$post_type_id)->where('name',$key)->first())
                @if($p->related_post_type_id)
                @if($post=\App\Models\Post::withoutGlobalScopes()->find($value))
                {{$post->title}}
                @endif
                @else
                {{$value}}
                @endif
                @else
                {{$value}}
                @endif

            </div>
            @endforeach
        </div>
        <hr />
        @endif

        <div class="table-responsive">
            <table class="table datatable-ajax" style="width: 100%;">
                <thead>
                    <tr>
                       <!-- <th></th>-->
                        <th>{{trans('app.title')}}</th>
                        <th>{{trans('app.created date')}}</th>
                        <th>{{trans('app.publish date')}}</th>
                        <th>{{trans('app.category')}}</th>
                        <th>{{trans('app.visits')}}</th>
                        <!-- <th>Icon</th> -->
                        <th>{{trans('app.status')}}</th>
                        <th style="width: 190px;"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->




<style>
    input[type="checkbox"] {
        position: absolute !important;
        left: 0px;
        opacity: 1;
    }
</style>
@endsection

@section('js')

<script>
    $(function() {
        
            $("body").on("click", ".publish", function(e) {
                e.preventDefault();
                var $this = $(this);
                if (!confirm("Are you sure you want to publish this post?")) return false;

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    url: "{{route('cp.post-publish')}}",
                    type: "post",
                    dataType: "json",
                    data: {
                        id: $this.data("id")},
                    /* beforeSubmit: function() {
                    return confirm("Are you sure you want to publish this post?");
                },
                */
                    success: function(d, statusText, xhr, form) {
                        if (d.type == "success") {
                            Success(d.message);
                            $this.toggleClass("publish");
                            $this.toggleClass("unpublish");
                            $this.find("span").toggleClass("text-danger");
                            $this.find("span").toggleClass("text-success");
                            $this.find("span").toggleClass("fa-toggle-off");
                            $this.find("span").toggleClass("fa-toggle-on");

                        } else {
                            Error(d.message);
                        }
                    },
                    error: function (data, status, xhr) {
                        Error(data.status + " " + xhr);
                    }
                });
            });

            $("body").on("click", ".unpublish", function(e) {
                e.preventDefault();
                var $this = $(this);
                if (!confirm("Are you sure you want to un-publish this post?")) return false;

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    url: "{{route('cp.post-unpublish')}}",
                    type: "post",
                    dataType: "json",
                    data: {
                        id: $this.data("id")},
                    /* beforeSubmit: function() {
                    return confirm("Are you sure you want to un-publish this post?");
                },
                */
                    success: function(d, statusText, xhr, form) {
                        if (d.type == "success") {
                            Success(d.message);
                            $this.toggleClass("publish");
                            $this.toggleClass("unpublish");

                            $this.find("span").toggleClass("text-danger");
                            $this.find("span").toggleClass("text-success");
                            $this.find("span").toggleClass("fa-toggle-off");
                            $this.find("span").toggleClass("fa-toggle-on");


                        } else {
                            Error(d.message);
                        }
                    },
                    error: function (data, status, xhr) {
                        Error(data.status + " " + xhr);
                    }
                });
            });

            

        loadData('{{$post_type_id}}', '{{$cat->id}}');

        $(".category-list a").click(function(e) {
            e.preventDefault();

            var btn = $(this);
            $(".category-list a").removeClass("active");
            btn.addClass('active');
            $("#cat-title").html(btn.text());
            $(".category-list button").text(btn.text());
            loadData(btn.data('type'),
                btn.data('cat'));
        })
        $("#delete-selected").click(function() {})
    });
    var table;
    var currType;
    var currCat;
    function loadData(type, cat) {
        currType = type;
        currCat = cat;

        if (table)table.destroy();
        table = $(".datatable-ajax").DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Arabic.json"
            },
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                url: '{{ route('cp.posts.datatable')}}'+location.search+'&cat='+cat,
                type: "POST",
                error: function(a, b, c) {
                    if (a.status == 401)window.location.reload(); //="{{route('login')}}";
                    else Error(a.statusText);
                },
               /* success: function() {
                    applyAjaxDelete();
                }*/

            },
            /*columnDefs: [{
                orderable: false,
                targets: 0,
                checkboxes: {
                    selectRow: true
                },
                className: 'select-checkbox',
            }],
            */
            dom: "<'col-sm-2'l><'col-sm-7 text-right'B><'col-sm-3'f>" +
            "<'col-sm-12'tr>" +
            "<'col-sm-5'i><'col-sm-7'p>",
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            columns: [
                // { data: 'image', name: 'image',orderable: false, searchable: false },
                /*{
                    data: "select",
                    name: 'select',
                    sortable: false,
                },*/
                {
                    data: 'title',
                    name: 'translations.title'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'pub_date',
                    name: 'pub_date'
                },
                // { data: 'creator', name: 'creator' },
                {
                    data: 'category',
                    name: 'category'
                },
                // { data: 'file', name: 'file',orderable: false, searchable: false },
                {
                    data: 'visits',
                    name: 'visits'
                },

                // { data: 'icon', name: 'icon',render:function(d){
                //     return "<i class='"+d+"'></i>";
                // }  },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            buttons: [
                //'csv', 'excel', 'pdf', 'print', 'reset', 'reload',
                //'pageLength',
                {
                    text: '<span class="text-danger">Delete</span>',
                    action: function () {
                        var items = table.rows( {
                            selected: true
                        });
                        if (items.count() == 0) return;

                        if (!confirm("Are you sure you wont to delete "+items.count()+" items?")) return;

                        bulkAction("{{route('cp.post-delete-bulk')}}");
                        //events.prepend( '<div>'+count+' row(s) selected</div>' );
                    }
                },

                {
                    text: '{{trans("cp.Publish")}}',
                    action: function () {


                        bulkAction("{{route('cp.post-publish-bulk')}}");
                        //events.prepend( '<div>'+count+' row(s) selected</div>' );
                    }
                },
                {
                    text: '{{trans("cp.UnPublish")}}',
                    action: function () {

                        bulkAction("{{route('cp.post-unpublish-bulk')}}");
                        //events.prepend( '<div>'+count+' row(s) selected</div>' );
                    }
                },
                @if (isset($filter_cats)) {
                    text: '' +
                    '<select class="form-1control" id="catid">' +
                    @foreach($filter_cats as $category)
                    @if ($category->Chields()->count() > 0)
                        '<optgroup label="{{$category->title}}">' +
                    @foreach($category->Chields as $cat)
                    '<option value="{{$cat->id}}" >{{$cat->title}}</option>' +
                    @endforeach
                    '</optgroup>'+
                    @else
                        '<option value="{{$category->id}}" >{{$category->title}}</option>' +
                    @endif
                    @endforeach
                    '</select>' +
                    '',
                    action: function() {}
                },

                {
                    text: '{{trans("cp.Move")}}',
                    action: function() {
                        bulkAction("{{route('cp.post-move-bulk')}}",
                            null, {
                                cat: $("#catid").val()});
                    }
                }
                @endif

            ],

        });
    }
    function bulkAction(url, next = null, extraData = null) {
        var items = table.rows( {
            selected: true
        });
        if (items.count() == 0) return;
        var strIds = [];

        items.data().each(function(item) {
            strIds.push(item.id);
        })

        var sdata = {
            ids: strIds
        };
        // console.log(Object.keys(extraData));
        if (extraData) Object.keys(extraData).forEach(function(key) {
            // console.log(key);
            sdata[key] = extraData[key];
        })
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            url: url,
            type: "post",
            dataType: "json",
            data: sdata,
            success: function(d, statusText, xhr, form) {
                if (d.type == "success") {
                    if (next != null) next(d); else {
                        Success(d.message);
                        //location.reload();
                        loadData(currType, currCat);
                    }
                } else {
                    Error(d.message);
                }
            },
            error: function (data, status, xhr) {
                Error(data.status + " " + xhr);
            }
        });
        function applyAjaxDelete() {
            $(".ajax-delete").ajaxForm({
                dataType: "json",
                beforeSubmit: function() {
                    return confirm("Are you sure you want to delete this item?");
                },
                success: function(d, statusText, xhr, form) {
                    if (d.type == "success") {
                        Success(d.message);
                        form.closest(form.attr("elm-parent")).remove();
                    } else {
                        Error(d.message);
                    }
                },
                error: function(data, status, xhr) {
                    Error(data.status + " " + xhr);
                }
            });
        }
    }
</script>

@endsection