@extends('admin.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">User License </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">Dashboard</li>
                <li class="breadcrumb-item active">User License </li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">User License </h4>
                        <h6 class="card-subtitle">{{$data['user_detail']->name}} ({{$data['user_detail']->email}})</h6>
                        <div class="table-responsive m-t-40">
                            <table id="downloadTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Service Name</th>
                                    <th>Days Limit</th>
                                    <th>Daily Limit</th>
                                    <th>Total Limit</th>
                                    <th>Key String</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['user_license'] as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->site->site_name}}</td>
                                        <td>{{$list->days_limit}}</td>
                                        <td>{{$list->daily_limit}}</td>
                                        <td>{{$list->total_limit}}</td>
                                        <td>{{$list->license_key}}</td>
                                        <td>@if($list->status=='used' || $list->status=='new' || $list->status=='sold') <span class="label label-info">{{$list->status}}</span> @else <span class="label label-danger">{{$list->status}}</span> @endif</td>
                                        <td>
                                            @if($list->status!='suspend')
                                                <a href="{{route('admin.suspendLicense',$list->id)}}"  onclick="return confirm('Are you sure you want to suspend ?');">
                                                    <i class="mdi mdi-power-plug text-success"></i>
                                                </a>
                                            @else
                                                <a href="{{route('admin.activateLicense',$list->id)}}">
                                                    <i class="mdi mdi-power-plug-off text-danger"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('#downloadTable').DataTable();
            $('#orderTable').DataTable();
        });
    </script>
@endpush
