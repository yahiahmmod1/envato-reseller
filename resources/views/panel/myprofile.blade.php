@extends('panel.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Dashboard</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">My Profile</h4>
                        <h6 class="card-subtitle">You can update your Profile</h6>
                        <form id="cookie-form" action="{{route('user.updateMyProfile')}}" method="POST" accept-charset="UTF-8">
                            @csrf
                            <input type="hidden" value="{{$data['myprofile']->id}}" name="id">
                            <div class="form-group">
                                <label for="site" class="control-label">Name</label>
                                <input name="name" type="text" class="form-control" value="{{$data['myprofile']->name}}" required>
                            </div>

                            <div class="form-group">
                                <label for="site" class="control-label">Email</label>
                                <input name="email" type="text" class="form-control" value="{{$data['myprofile']->email}}" required>
                            </div>

                            <div class="form-group">
                                <label for="site" class="control-label">Whatsapp</label>
                                <input name="whatsapp" type="text" class="form-control" value="{{$data['myprofile']->whatsapp}}" required>
                            </div>

{{--                            <div class="form-group">--}}
{{--                                <label for="site" class="control-label">Current Password</label>--}}
{{--                                <input name="cpassword" type="text" class="form-control" value="" >--}}
{{--                            </div>--}}

                            <div class="form-group">
                                <label for="site" class="control-label">New Password</label>
                                <input name="password" type="text" class="form-control" value="" >
                            </div>

                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary text-center">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

