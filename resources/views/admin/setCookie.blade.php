@extends('admin.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Cookie Setting</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">Dashboard</li>
                <li class="breadcrumb-item active">Cookie Set</li>
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
                        <h4 class="card-title">Cookie List</h4>
                        <div class="d-flex justify-content-between">
                            <h6 class="card-subtitle">All Cookie</h6>
                            <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#cookieModal">Set Cookie</button>
                        </div>

                        <div class="table-responsive m-t-40">
                            <table id="downloadTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Service Name</th>
                                    <th>Cookie</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['cookie_list'] as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->site->site_name}}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($list->cookie_content, 50, $end='...') }}</td>
                                        <td>{{$list->status}}</td>
                                        <td><a href="{{route('admin.cookieDelete',$list->id)}}"  onclick="return confirm('Are you sure you want to delete ?');"><i class="mdi mdi-delete text-danger"></i></a></td>
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

    <div class="modal fade" id="cookieModal" tabindex="-1" role="dialog" aria-labelledby="cookieModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Set Cookie</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="cookie-form" action="{{route('admin.setCookieProcess')}}" method="POST" accept-charset="UTF-8">
                        @csrf
                        <div class="form-group">
                            <label for="site" class="control-label">Select Site</label>
                            <select class="form-control" name="site_id">
                                <option value="1">Envato</option>
                                <option value="2">FreePik</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cookie_content" class="control-label">Cookie</label>
                            <textarea class="form-control" name="cookie_content" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="csrf_token" class="control-label">Csrf Token.</label>
                            <input name="csrf_token" type="text" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('cookie-form').submit()">Create</button>
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
