@extends('layouts.admin')
@section('content')
<section class="user-dashboard">


    <div class="col col-md-6 col-lg-4">
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-body" >
                    <a href="{{route('cp.setting.edit')}}">
                    <center>
                        <i class="fa fa-cogs"  style="font-size: 150px"></i>
                        <br/>
                        Settings
                    </center>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col col-md-6 col-lg-4">
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-body" >
                    <a href="{{route('cp.secgroup.index')}}">

                        <center>
                            <i class="fa fa-user-secret "  style="font-size: 150px"></i>
                            <br/>
                            Security Groups
                        </center>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <div class="col col-md-6 col-lg-4">
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-body" >
                    <a href="{{route('cp.secpermission.create')}}">
                        <center>
                        <i class="fa fa-shield "  style="font-size: 150px"></i>
                        <br/>
                        Permissions
                    </center>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')

@endsection
