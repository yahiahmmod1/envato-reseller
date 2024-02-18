@extends('admin.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Banner List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">Dashboard</li>
                <li class="breadcrumb-item active">Banner List</li>
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
                                <h4 class="card-title">Banner List</h4>
                                <h6 class="card-subtitle">All Banner</h6>
                            </div>
                            <div>
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#bannerModal" data-whatever="bannerModal">Add Banner</a>
                            </div>
                        </div>
                        <div class="table-responsive m-t-40">
                            <table id="downloadTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>File Name</th>
                                    <th>Go to URL</th>
                                    <th>Upload Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['banner_list'] as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td> <img src="{{asset('uploads/banner/'.$list->image_name)}}" style="width: 100px"></td>
                                        <td>{{$list->goto_url}}</td>
                                        <td>{{$list->created_at}}</td>
                                        <td> <a href="{{route('admin.deleteBanner',$list->id)}}"  onclick="return confirm('Are you sure you want to delete ?');"><i class="mdi mdi-delete text-danger"></i></a></td>
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

    <div class="modal fade" id="bannerModal" tabindex="-1" role="dialog" aria-labelledby="bannerModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Create Banner</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="license-key-form" action="{{route('admin.createBanner')}}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="days-limit" class="control-label">Image</label>
                            <input name="file" type="file" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="site" class="control-label">Select Side</label>
                            <select class="form-control" name="position">
                                <option value="left">Left</option>
                                <option value="right">Right</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="days-limit" class="control-label">Got to Url</label>
                            <input name="goto_url" type="url" class="form-control" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('license-key-form').submit()">Activate</button>
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
