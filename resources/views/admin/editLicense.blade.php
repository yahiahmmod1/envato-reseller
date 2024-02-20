@extends('admin.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Cookie Edit</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "> <a href="{{route('admin.dashboard')}}">Dashboard</a>></li>
                <li class="breadcrumb-item active">Cookie Edit</li>
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
                        <h4 class="card-title">License Edit {{$data['license_key']['id']}}</h4>
                        <form id="cookie-form"   action="{{route('admin.licenseEdit', $data['license_key']['id'])}}" method="POST" accept-charset="UTF-8">
                            @csrf
                            <div class="form-group">
                                <label for="days-limit" class="control-label">After how many dasy will expire.</label>
                                <input name="days_limit" type="number" class="form-control" value="{{$data['license_key']['days_limit']}}" required>
                            </div>
                            <div class="form-group">
                                <label for="daily-limit" class="control-label">Dialy Download Limit.</label>
                                <input name="daily_limit" type="number" class="form-control" value="{{$data['license_key']['daily_limit']}}">
                            </div>
                            <div class="form-group">
                                <label for="total-limit" class="control-label">Total Download Limit.</label>
                                <input name="total_limit" type="number" class="form-control" value="{{$data['license_key']['total_limit']}}">
                            </div>

                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary text-center">
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
