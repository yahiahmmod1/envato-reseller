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
                                    <th>Action</th>
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
                                        <td>{{$list->license_key}}
                                            <p style="font-size: 10px">
                                                {{@$list->user->email}}  (Used: {{$list->used_date}}) / (Expiry: {{$list->expiry_date}})
                                            </p>
                                        </td>
                                        <td>@if($list->status=='new') <span class="label label-success">{{$list->status}}</span> @else <span class="label label-danger">{{$list->status}}</span> @endif</td>
                                        <td>@if($list->status=='new') <a href="{{route('admin.sellLicense',$list->id)}}"  onclick="return confirm('Are you sure you want to delete ?');"><i class="mdi mdi-check text-info"></i></a>@endif</td>
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
            $('#downloadTable',{
                order: [[0, 'desc']]
            }).DataTable();
            $('#orderTable').DataTable();
        });
    </script>
@endpush
