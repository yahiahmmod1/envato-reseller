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
                            <a class="btn btn-info text-white" href="https://youtu.be/1XWKWy21ius" target="_blank"><i class="mdi mdi-video"> </i> Watch promo video </a>
                        </div>

                        @if($data['service']!=='envato')
                            <div class="row mx-1 my-4 p-2" style="border: 1px solid red">
                                <div class="col-12">
                                    <div>
                                        <h5 class="text-danger text-center justify-content-center align-content-center"> This Service is currently not running.</h5>
                                    </div>
                                </div>
                            </div>

                        @elseif( count($data['license_check'])===0 || strtotime($data['expiry_date']) == null || strtotime(date('Y-m-d')) < strtotime($data['expiry_date'] || $data['remaining_download'] <= 0) )

                            <div class="row mx-1 my-4 p-2" style="border: 1px solid red">
                                <div class="col-8 align-content-center">
                                    <div>
                                        <h5 class="text-danger"> Oops! Download limits crossed or no active services. Click the Buy Now button to purchase this service and resume uninterrupted access.</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <a class="btn   pull-right btn-danger" href="https://digitaltoolsbd.com/"  target="_blank"><i class="mdi mdi-check"> </i> Buy Now </a>
                                </div>
                            </div>
                        @else

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-info">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white"> {{ $data['remaining_download'] }} <i class="ti-angle-down font-14  text-default"></i></h2>
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
                                            <div class="col-12"><h2 class=" text-white"> {{$data['expiry_date']}} <i class="ti-angle-down font-14  text-default"></i></h2>
                                                <h6 class=" text-white">Service End Date</h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-warning">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white">{{ $data['total_download_limit']  }} ({{$data['total_download_limit'] - $data['total_download']}}) <i class="ti-angle-down font-14  text-default"></i></h2>
                                                <h6 class=" text-white">Total download limit</h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-danger">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white">{{ $data['total_download']}} <i class="ti-angle-up font-14  text-default"></i></h2>
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
                                <div id="loader" style="height: 50px; display:none" >
                                    <img src="{{asset('images/loader.gif')}}"
                                         style="width: 50px;
                                            height: 50px;
                                            position: absolute;
                                            left: 44%;">
                                </div>
                                <div id="warning-message"></div>
                                <div id="download-url" class="m-2"></div>
                                <form id="download_form"  accept-charset="UTF-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-9 col-sm-12 col-xs-12">
                                            <input type="text" id="content_url" class="form-control" placeholder="Enter your Envato Element content url" style="width: 100%" required>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-xs-12 pull-right float-right">
                                            <input id="download_button" type="submit" class="btn" style="background: #28a745; color: #fff" value="Generate download link">
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

        const cookie_count = "{{ $data['cookie_count'] }}";
        let counter =  1;

      async function processDownload(content_url){
          counter++;
            let {data} = await axios.post('{{route('download.process')}}', {"action":"download", "content_url": content_url }, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

          if(data.status=='inactive'){
              if(cookie_count > counter){
                  data =  processDownload(content_url);
              }else{
                  data.status = 'no-cookie';
              }
          }
          return data;
        }

        $('#download_form').on('submit',async function (e) {
            e.preventDefault();

            $("#loader").show();
            $("#download_button").attr('disabled','disabled');

            const content_url = $('#content_url').val();
            const responseData = await processDownload(content_url);

            $("#loader").hide();
            $("#download_button").removeAttr('disabled');
            $("#content_url").val('');

            if(responseData.status=='failed'){
                $("#warning-message").html('<div class="alert alert-danger"> Download Failed <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>');
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Download  Failed!",
                    confirmButtonColor: "#F27474",
                    footer: '<a href="#">Download failed</a>'
                });
                return;
            }

            if(responseData.status=='daily-limit-crossed'){
                $("#warning-message").html('<div class="alert alert-danger"> Your Daily Limit is Crossed  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>');
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Server Failed!",
                    confirmButtonColor: "#F27474",
                    footer: '<a href="#">Your Daily Limit is Crossed</a>'
                });
                return;
            }

            if(responseData.status=='success'){
                $("#warning-message").html('<div class="alert alert-success"> Your Download Started <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>');
                window.open(responseData?.download_url);
                $("#download-url").html(`<a href="${responseData?.download_url}" target="_blank"> Download not starting Automatically? Click to Download  </a>`);

                Swal.fire({
                    icon: "success",
                    title: "Download is starting Automatically",
                    showConfirmButton: false,
                    timer: 3000
                });
            }

            return false;
        });

        setTimeout(()=>{
            $("#warning-message").html('');
            $("#download-url").html('');

        },10000);

    </script>
@endpush
