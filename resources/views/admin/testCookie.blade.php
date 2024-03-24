@extends('admin.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Cookie Setting</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">Dashboard</li>
                <li class="breadcrumb-item active">Cookie Test</li>
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
                        <h4 class="card-title">Cookie Test</h4>

                        <form id="cookie-form" action="{{route('admin.testCookieProcess')}}" method="POST" accept-charset="UTF-8">
                            @csrf
                            <div class="form-group">
                                <label for="site" class="control-label">Cookie List</label>
                                <select class="form-control" name="cookie_id">
                                    @foreach($data['cookie_list'] as $cookie)
                                    <option value="{{$cookie->id}}">{{$cookie->account}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="csrf_token" class="control-label">Download Url.</label>
                                <input name="download_url" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <input  type="submit" class="btn btn-primary">
                            </div>
                        </form>

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
