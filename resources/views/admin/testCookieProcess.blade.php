@extends('admin.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Cookie Test</h3>
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
                        <h4 class="card-title">Cookie Test Report for User</h4>
                        @php
                            $report =  json_decode($data['cookie_response']);
                        @endphp
                        Status: @if(isset($report->data->attributes->downloadUrl))  Working @else Not Working @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Cookie Test Report for Developer</h4>
                        <pre>
                        @php
                            $report =  json_decode($data['cookie_response']);
                            print_r($report);
                        @endphp
                        </pre>
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
