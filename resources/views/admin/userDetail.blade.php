@extends('admin.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">User Detail</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">Dashboard</li>
                <li class="breadcrumb-item active">User Detail</li>
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
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <td>:</td>
                                <td> {{  $data['user_info']->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>:</td>
                                <td> {{  $data['user_info']->email }}</td>
                            </tr>
                            <tr>
                                <th>Join</th>
                                <td>:</td>
                                <td> {{  $data['user_info']->created_at }}</td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-info">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white">{{$data['today_download'] }} <i class="ti-angle-down font-14  text-default"></i></h2>
                                                <h6 class=" text-white">Today  Download</h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-success">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white">{{ $data['total_download']}} <i class="ti-angle-down font-14  text-default"></i></h2>
                                                <h6 class=" text-white">Total  Download</h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-warning">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white"> {{ $data['today_limit']}} <i class="ti-angle-down font-14  text-default"></i></h2>
                                                <h6 class=" text-white">Today Limit  </h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-danger">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white"> {{ $data['total_limit'] }} <i class="ti-angle-down font-14  text-default"></i></h2>
                                                <h6 class=" text-white">Total Limit  </h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">License List</h4>
                        <div class="table-responsive m-t-10">
                            <table id="licenseTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Service Name</th>
                                    <th>Days Limit</th>
                                    <th>Daily Limit</th>
                                    <th>Total Limit</th>
                                    <th>Expiry</th>
                                    <th>Key String</th>

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
                                        <td>{{$list->expiry_date}}</td>
                                        <td>{{$list->license_key}}
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Download List</h4>
                        <div class="table-responsive m-t-10">
                            <table id="downloadTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Service Name</th>
                                    <th>Assets</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['download_list'] as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->site->site_name}}</td>
                                        <td>
                                            <a href="{{$list->content_link}}"  target="_blank"> {{$list->content_link}} </a>
                                        </td>
                                        <td><span class="label label-success">{{$list->status}}</span></td>
                                        <td>{{$list->created_at->diffForHumans()}}</td>
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
            $('#licenseTable').DataTable( {
                order: [[ 0, 'desc' ]]
            } );

            $('#downloadTable').DataTable( {
                order: [[ 0, 'desc' ]]
            } );

        });
    </script>
@endpush
