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
                        @php// dd($data['site_cookie']['id']); @endphp
                        <h4 class="card-title">Cookie Edit</h4>
                        <form id="cookie-form" action="{{route('admin.cookieEdit',$data['site_cookie']['id'])}}" method="POST" accept-charset="UTF-8">
                            @csrf
                            <div class="form-group">
                                <label for="site" class="control-label">Select Site</label>
                                <select class="form-control" name="site_id">
                                    @if($data['site_cookie']['site_id']==1)
                                        <option value="{{$data['site_cookie']['site_id']}}" selected>Envato</option>
                                        <option value="2">FreePik</option>
                                    @endif
                                    @if($data['site_cookie']['site_id']==2)
                                        <option value="{{$data['site_cookie']['site_id']}}" selected>FreePik</option>
                                        <option value="1">Envato</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="site" class="control-label">Account / Project Name</label>
                                <input name="account" type="text" class="form-control" value="{{$data['site_cookie']['account']}}">
                            </div>
                            <div class="form-group">
                                <label for="site" class="control-label">Cookie Source</label>
                                <select class="form-control" name="cookie_source">
                                    @if($data['site_cookie']['cookie_source']=='d5stock')
                                        <option value="{{$data['site_cookie']['cookie_source']}}">D5Stock</option>
                                        <option value="envato-element">Evnato Element</option>
                                    @endif
                                    @if($data['site_cookie']['cookie_source']=='envato-element')
                                        <option value="{{$data['site_cookie']['cookie_source']}}">Evnato Element</option>
                                            <option value="d5stock">D5Stock</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cookie_content" class="control-label">Cookie</label>
                                <textarea class="form-control" name="cookie_content" rows="4" required>{{$data['site_cookie']['cookie_content']}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="csrf_token" class="control-label">Csrf Token.</label>
                                <input name="csrf_token" type="text" class="form-control" value="{{$data['site_cookie']['csrf_token']}}">
                            </div>

                            <div class="form-group">
                                <label for="site" class="control-label">Select Site</label>
                                <select class="form-control" name="status">
                                    @if($data['site_cookie']['status']=='active')
                                        <option value="active" selected>Active</option>
                                        <option value="inactive">Inactive</option>
                                    @endif
                                        @if($data['site_cookie']['status']=='inactive')
                                            <option value="inactive" selected>Inactive</option>
                                            <option value="active">active</option>
                                        @endif
                                </select>
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
