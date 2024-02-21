@extends('admin.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Social List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">Dashboard</li>
                <li class="breadcrumb-item active">Social List</li>
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
                                <h4 class="card-title">Social List</h4>
                                <h6 class="card-subtitle">All Social Link</h6>
                            </div>
                            <div>
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#socialModal" data-whatever="bannerModal">Add Social</a>
                            </div>
                        </div>
                        <div class="table-responsive m-t-40">
                            <table id="socialTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Social Icon</th>
                                    <th>Go to URL</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['social_list'] as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td> <img src="{{asset('uploads/social/'.$list->social_icon)}}" style="width: 50px"></td>
                                        <td>{{$list->goto_url}}</td>
                                        <td> <a href="{{route('admin.deleteSocial',$list->id)}}"  onclick="return confirm('Are you sure you want to delete ?');"><i class="mdi mdi-delete text-danger"></i></a></td>
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

    <div class="modal fade" id="socialModal" tabindex="-1" role="dialog" aria-labelledby="socialModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Create Social</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="social-form" action="{{route('admin.createSocial')}}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label">Name</label>
                            <input name="name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="social_icon" class="control-label">Image</label>
                            <input name="file" type="file" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="goto_url" class="control-label">Got to Url</label>
                            <input name="goto_url" type="url" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="button_color" class="control-label">Button Color </label>
                            <input name="button_color" type="url" class="form-control" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('social-form').submit()">Add Social</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('#socialTable',{
                order: [[0, 'desc']]
            }).DataTable();
            $('#orderTable').DataTable();
        });
    </script>
@endpush
