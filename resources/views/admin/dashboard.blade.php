@extends('admin.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">License List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">Dashboard</li>
                <li class="breadcrumb-item active">License List</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row my-2">
            <div class="col-lg-3 col-md-6">
                <div class="card card-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"><h2 class=" text-white"> {{$data['total_user']}} <i class="ti-angle-down font-14  text-default"></i></h2>
                                <h6 class="text-white">Total User</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"><h2 class=" text-white"> {{ $data['today_user']}} <i class="ti-angle-down font-14  text-default"></i></h2>
                                <h6 class=" text-white">Today User</h6></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card card-warning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"><h2 class=" text-white">{{$data['total_active_user'] }} <i class="ti-angle-down font-14  text-default"></i></h2>
                                <h6 class=" text-white">Total Active User</h6></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card card-danger">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"><h2 class=" text-white">{{  $data['total_envato_downlaod'] }}<i class="ti-angle-up font-14  text-default"></i></h2>
                                <h6 class=" text-white">Total Envato Download</h6></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-2">
            <div class="col-lg-3 col-md-6">
                <div class="card card-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"><h2 class=" text-white"> {{$data['today_envato_downlaod'] }} <i class="ti-angle-down font-14  text-default"></i></h2>
                                <h6 class="text-white">Today Envato Download</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"><h2 class=" text-white"> {{   $data['total_freepik_downlaod'] }} <i class="ti-angle-down font-14  text-default"></i></h2>
                                <h6 class=" text-white">Total Freepik Download</h6></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card card-warning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"><h2 class=" text-white">{{ $data['today_freepik_downlaod'] }} <i class="ti-angle-down font-14  text-default"></i></h2>
                                <h6 class=" text-white">Today Freepik Download</h6></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card card-danger">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"><h2 class=" text-white">{{   $data['today_limit']  }} / {{$data['total_limit'] }}<i class="ti-angle-up font-14  text-default"></i></h2>
                                <h6 class=" text-white">Today/Total Limit</h6></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order List</h4>
                        <h6 class="card-subtitle">All Order</h6>
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
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['license_list'] as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->site->site_name}}</td>
                                        <td>{{$list->days_limit}}</td>
                                        <td>{{$list->daily_limit}}</td>
                                        <td>{{$list->total_limit}}</td>
                                        <td>{{$list->license_key}}</td>
                                        <td><span class="label label-success">{{$list->status}}</span></td>

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
