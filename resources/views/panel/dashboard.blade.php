@extends('panel.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Dashboard</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row my-2 mb-4">
            <div class="col-6">
                    <a  href="https://digitaltoolsbd.com/" target="_blank"> <img src="{{asset('uploads/banner/banner-10.png')}}" style="width: 100%"></a>
            </div>
            <div class="col-6">
                <a  href="https://digitaltoolsbd.com/" target="_blank"> <img src="{{asset('uploads/banner/banner-11.png')}}"  style="width: 100%"></a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Download History</h4>
                        <h6 class="card-subtitle">All Service Download History</h6>
                        <div class="alert alert-dark" style="background-color: #FFE0DB; color: #e63946">
                            <strong>Important:</strong>
                            <ul>
                                <li> For your safety, we recommend buying accounts on our official website, page, or WhatsApp.</li>
                                <li>   Files that you have already downloaded can be re-downloaded within 24 hours by clicking the License Download button.</li>
                                <li>    Depending on the file sizes, showing the License Download option may take longer.</li>
                            </ul>
                        </div>
                        <div class="table-responsive m-t-40">
                            <table id="downloadTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Service Name</th>
                                    <th>Assets</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['download_history'] as $list)
                                <tr>
                                    <td>{{$list->item_id}}</td>
                                    <td>{{$list->site->site_name}}</td>
                                    <td><a href="{{$list->content_link}}" class="btn btn-info btn-sm">Content Address</a></td>
                                    <td><span class="label label-success">{{$list->status}}</span></td>
                                    <td>{{$list->created_at->diffForHumans()}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order History</h4>
                        <h6 class="card-subtitle">Service Order History</h6>
                        <div class="table-responsive m-t-40">
                            <table id="orderTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Service Name</th>
                                    <th>Daily Limit</th>
                                    <th>Total Limit</th>
                                    <th>Status</th>
                                    <th>Expiry Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['order_history'] as $index => $item)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$item->site->site_name}}</td>
                                        <td>{{$item->daily_limit}}</td>
                                        <td>{{$item->total_limit}}</td>
                                        <td>
                                            @if($item->status=='used')
                                                <span class="label  label-success label-success ">Active</span>
                                            @else
                                                <span class="label  label-success label-danger ">Inactive</span>
                                            @endif
                                          </td>
                                        <td>{{$item->expiry_date}}</td>
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
    </script>
@endpush
