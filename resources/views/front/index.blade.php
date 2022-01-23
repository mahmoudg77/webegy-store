@extends('layouts.app')
@section('title', trans('app.tenders'))

@section('css')
<style>
    .nav-tabs>li {
        float: left;
        list-style: none;
        width: 20%;
        text-align: center;
        transition: all 300ms linear 0s;
        border-right: 1px solid #dfe3e4;
        height: 90px;
    }

    .nav-tabs>li:active {
        border-bottom: 5px solid #b57f30;
    }
    .nav-tabs>li:active a{
        
    }
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover{
        color: #b57f30 !important;
        background-color:transparent !important;
    }
    .nav-tabs > li > a{
        font: 400 20px "Roboto", sans-serif;
        display: block;
        color: #222222;
    }
    .nav-tabs > li > a > i{
        font-size: 36px;
        display: block;
        padding-bottom: 10px;
    }
    .tab-content{
        padding: 50px 10px;
    }
    .tab-content .tab-pane h3{
        font: 700 36px "Roboto", sans-serif;
        color: #0c2a50;
        text-transform: uppercase;
        position: relative;
        margin-bottom: 20px;
    }
    .tab-content .tab-pane h3:after{
        content: "";
        position: absolute;
        height: 2px;
        width: 80px;
        /* background: #222222; */
        left: 0;
        bottom: -22px;
        background: #b57f30;
    }
    .timer{
        font-weight:bold;
    }
</style>
@endsection

@section('content')

<!-- Banner area -->
<section class="banner_area" data-stellar-background-ratio="0.5">
    <h2>{{trans('app.tenders')}}</h2>
    <ol class="breadcrumb">
        <li><a href="index.html">{{trans('app.home')}}</a></li>
        <li><a href="{{route('tenders')}}" class="active">{{trans('app.tenders')}}</a></li>
    </ol>
</section>
<!-- End Banner area -->

<!-- Our Services Area -->
<section class="our_services_tow">
    <div class="container">

        <div class="tenders_tabs">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <i class="fa fa-folder-open"></i> {{trans('app.open')}}</a>
                </li>
                <li><a data-toggle="tab" href="#menu1">
                    <i class="fa fa-window-close"></i> {{trans('app.closed')}}</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div style="padding-bottom: 30px;"><h3>{{trans('app.tender_open')}}</h3></div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{trans('app.code')}}</th>
                                    <th>{{trans('app.project')}}</th>
                                    <th>{{trans('app.tender_name')}}</th>
                                    <th>{{trans('app.city')}}</th>
                                    <!-- <th>{{trans('app.status')}}</th> -->
                                    <th>{{trans('app.remaining time')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data_open as $tender)
                                    <tr>
                                        <td></td>
                                        <td>{{$tender->Project->name}}</td>
                                        <td>{{$tender->tender_name}}</td>
                                        <td>{{$tender->Project->address}}</td>
                                        <!-- <td></td> -->
                                        <td><div class="text-success timer" data-countdown="{{$tender->end_date}}"></div></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> 
                </div>
                <div id="menu1" class="tab-pane fade">
                    <div style="padding-bottom: 30px;"><h3>{{trans('app.tender_closed')}}</h3></div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{trans('app.code')}}</th>
                                    <th>{{trans('app.project')}}</th>
                                    <th>{{trans('app.tender_name')}}</th>
                                    <th>{{trans('app.city')}}</th>
                                    <!-- <th>{{trans('app.status')}}</th> -->
                                    <th>{{trans('app.remaining time')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data_closed as $tender)
                                    <tr>
                                        <td></td>
                                        <td>{{$tender->Project->name}}</td>
                                        <td>{{$tender->tender_name}}</td>
                                        <td>{{$tender->Project->address}}</td>
                                        <!-- <td></td> -->
                                        <td><div class="text-danger timer" data-countdown="{{$tender->end_date}}"></div></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>

    </div>
</section>
<!-- End Our Services Area -->

@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
<script>
$(function(){
    $('[data-countdown]').each(function() {
        var $this = $(this), finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function(event) {
            $this.html(event.strftime('%D days %H:%M:%S'));
        });
    });
});

</script>
@endsection