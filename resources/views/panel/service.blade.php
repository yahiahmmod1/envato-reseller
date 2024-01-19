@extends('panel.main.master')
@section('breadchrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Service: <span class="text-capitalize">{{ $data['service'] }} </span></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">Dashboard</li>
                <li class="breadcrumb-item active">Service</li>
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

                        <div class="d-flex justify-content-between mb-2">
                            <button class="btn btn-primary"><i class="mdi mdi-check"> </i> Service Status: Running </button>
                            <a class="btn btn-info text-white" href="https://youtu.be/N3446X-MV3o" target="_blank"><i class="mdi mdi-video"> </i> Watch promo video </a>
                        </div>

                        @if($data['service']!=='envato')
                            <div class="row mx-1 my-4 p-2" style="border: 1px solid red">
                                <div class="col-12">
                                    <div>
                                        <h5 class="text-danger text-center justify-content-center align-content-center"> This Service is currently not running.</h5>
                                    </div>
                                </div>
                            </div>

                        @elseif(strtotime($data['expiry_date']) == null || strtotime(date('Y-m-d')) < strtotime($data['expiry_date'] || $data['remaining_download'] <= 0) )

                            <div class="row mx-1 my-4 p-2" style="border: 1px solid red">
                                <div class="col-8 align-content-center">
                                    <div>
                                        <h5 class="text-danger"> Oops! Download limits crossed or no active services. Click the Buy Now button to purchase this service and resume uninterrupted access.</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button class="btn   pull-right btn-danger" ><i class="mdi mdi-check"> </i> Buy Now </button>
                                </div>
                            </div>
                        @else

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-info">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white"> {{ $data['remaining_download'] }} <i class="ti-angle-down font-14  text-default""></i></h2>
                                                <h6 class="text-white">Remaining Daily Download</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white"> {{$data['expiry_date']}} <i class="ti-angle-down font-14  text-default""></i></h2>
                                                <h6 class=" text-white">Service End Date</h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-warning">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white">{{ $data['total_download_limit']  }} ({{$data['total_download_limit'] - $data['total_download']}}) <i class="ti-angle-down font-14  text-default""></i></h2>
                                                <h6 class=" text-white">Total download limit</h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-danger">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white">{{ $data['total_download']}} <i class="ti-angle-up font-14  text-default""></i></h2>
                                                <h6 class=" text-white">Total downloads file</h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-lg-12">
                                <div class="p-2" style="background-color: #cee5d6; color: #000; border-radius: 5px;     font-size: 14px; ">
                                    <span class="font-bold text-danger"> ATTENTION </span> Download links are valid for 1 minute. If you click the link after 1 minute, it will not work.
                                    After downloading your content from here, you can download the license through the download history on the 'Dashboard' tab.
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-lg-12">
                                <div class="p-2" style="font-size: 14px; background: #d1ecf1">Make sure the link you entered goes to the envato elements content page.</div>
                            </div>
                        </div>
                        <div class="row my-5">
                            <div class="col-lg-12">
                                <div id="warning-message"></div>
                                <div id="download-url" class="m-2"></div>
                                <form id="download_form"  accept-charset="UTF-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-9 col-sm-12 col-xs-12">
                                            <input type="text" id="content_url" class="form-control" placeholder="Enter your Envato Element content url" style="width: 100%" required>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-xs-12 pull-right float-right">
                                            <input type="submit" class="btn" style="background: #28a745; color: #fff" value="Generate download link">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#download_form').on('submit',function (e){
            e.preventDefault();
            const content_url =  $('#content_url').val();

            $.ajax({
                type:'POST',
                url:"{{route('download.process')}}",
                data:{"action":"download", "content_url": content_url },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response){
                    if(response.status=='server-fail'){
                        $("#warning-message").html('<div class="alert alert-danger"> Server Down Please try later  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>');
                        return;
                    }

                    if(response.status=='daily-limit-crossed'){
                        $("#warning-message").html('<div class="alert alert-danger"> Your Daily Limit is Crossed  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>');
                        return;
                    }

                    if(response.status=='success'){
                        $("#warning-message").html('<div class="alert alert-success"> Your Download Started <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>');
                        window.open(response?.download_url);
                        $("#download-url").html(`<a href="${response?.download_url}" target="_blank"> Download not starting Automatically? Click to Download  </a>`);
                    }
                },
                error: function(err){
                    $("#warning-message").html('<div class="alert alert-danger"> Server Failed  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>');
                }
            });

            return false;
        });

        setTimeout(()=>{
            $("#warning-message").html('');
            $("#download-url").html('');
        },10000);

    </script>
@endpush
