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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">License List</h4>
                        <h6 class="card-subtitle">All License</h6>
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
