@extends('admin.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Log List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "> <a href={{route('admin.dashboard')}}"">Dashboard</a>></li>
                <li class="breadcrumb-item active">Log List</li>
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
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">Log List</h4>
                                <h6 class="card-subtitle">All Log</h6>
                            </div>
                            <div>
                               Total: {{$data['log_list']->total()}}
                                <a href="{{route('admin.clearLog')}}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete all Log?');">Clear Log</a>
                            </div>
                        </div>
                        <div class="table-responsive m-t-40">
                            <table  class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Message</th>
                                    <th>Type</th>
                                    <th>Check-point</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['log_list'] as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->message}}</td>
                                        <td>{{$list->type}}</td>
                                        <td>{{$list->getAttribute('check-point')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $data['log_list']->links() }}
            </div>
        </div>
    </div>
@endsection

