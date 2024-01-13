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
                            <a class="btn btn-info text-white"><i class="mdi mdi-video"> </i> Watch promo video </a>
                        </div>

                        <div class="row mx-2 p-2" style="border: 1px solid red">
                            <div class="col-8">
                                <div>
                                    <h2 class="text-danger">You don't have any active services or you've cross your download limits.
                                        To purchase this service, click on Buy Now button.</h2>
                                </div>
                            </div>
                            <div class="col-4">
                               <button class="btn btn-primary  pull-right"><i class="mdi mdi-check"> </i> Buy Now </button>
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-info">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white">24 <i class="ti-angle-down font-14 text-danger"></i></h2>
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
                                            <div class="col-12"><h2 class=" text-white"> 22-01-2024 <i class="ti-angle-down font-14 text-danger"></i></h2>
                                                <h6 class=" text-white">Service End Date</h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-warning">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white">10 <i class="ti-angle-down font-14 text-danger"></i></h2>
                                                <h6 class=" text-white">Total download limit</h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-danger">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12"><h2 class=" text-white">2376 <i class="ti-angle-down font-14 text-danger"></i></h2>
                                                <h6 class=" text-white">Total downloads file</h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row my-2">
                            <div class="col-lg-12">
                                <div class="alert alert-primary">Download links are valid for ...</div>
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-12">
                                <div class="alert alert-danger">Make sure ...</div>
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-12">
                            <form id="download_form"  accept-charset="UTF-8" class="form-inline">
                                @csrf
                                <div class="col-9 mb-2">
                                    <input type="text" id="content_url" class="form-control" placeholder="Enter your Envato Element content url" style="width: 100%" required>
                                </div>
                                <div class="col-3 mb-2">
                                    <input type="submit" class="btn btn-success" value="Generate download link">
                                </div>
                            </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('custom-scripts')
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
                    console.log("sma",response);
                    if(response.status=='success'){
                        console.log("shaua",response.download_url);
                        window.open(response.download_url);
                    }
                },
                error: function(err){
                    console.log('error');
                }
            });

            return false;
        });

    </script>
@endpush
