@extends('admin.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">User List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "> <a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">User List</li>
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
                        <h4 class="card-title">User List</h4>
                        <h6 class="card-subtitle">All User</h6>
                        <p>Temporary Login Link: https://digitaltoolsbdstock.com/user/templogin </p>
                        <div class="table-responsive m-t-40">
                            <table id="downloadTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th> Name</th>
                                    <th>Email</th>
                                    <th>Joining</th>
                                    <th>Licenses</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['user_list'] as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->name}}</td>
                                        <td>{{$list->email}}</td>
                                        <td>{{$list->created_at}}</td>
                                        <td> <a href="{{route('admin.userLicense',$list->id)}}">{{count($list->license)}} </a></td>
                                        <td>
                                            @if($list->status=='active')
                                                <span class="label label-success">{{$list->status}}</span>
                                            @else
                                                <span class="label label-danger">{{$list->status}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div id="temp_pass_{{$list->id}}">
                                                <button type="submit" class="btn btn-xs btn-info" onclick="generateTempPass({{$list->id}})">Generate</button>
                                            </div>

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


        async function generateTempPass(user_id){
            let {data} = await axios.post('{{route('generateTempPass')}}', {"action":"generate-temp-pass", "user_id": user_id }, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#temp_pass_"+user_id).html(data.password);

            console.log(data);
        }
    </script>
@endpush
