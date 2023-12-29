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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Download History</h4>
                        <div class="alert alert-dark" style="background-color: #FFE0DB; color: #e63946">
                            <strong>Important:</strong>
                            <ul style="margin-bottom: -3px;">
                                <li>Files that you have already downloaded, can be re-download within 24 hours by clicking the License Download button.</li>
                                <li>If do not showing the Licensed Download button, possible reasons is it has been over 24 hours or the licensed download link is not ready yet.</li>
                                <li>Depending on the file sizes, time may take longer to show the License Download option.</li>
                            </ul>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
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
                                <tr>
                                    <td>1</td>
                                    <td>Deshmukh</td>
                                    <td>Prohaska</td>
                                    <td><span class="label label-success">Success</span></td>
                                    <td>1 week 1 day before (2023-12-20 22:49:07) </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Deshmukh</td>
                                    <td>Gaylord</td>
                                    <td><span class="label label-success">Success</span></td>
                                    <td>1 week 1 day before (2023-12-20 22:49:07) </td>
                                </tr>
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
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Service Name</th>
                                    <th>Daily Limit</th>
                                    <th>Asset Name</th>
                                    <th>Expiry Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>License Key</td>
                                    <td>Envato</td>
                                    <td><span class="label label-danger">Expired</span></td>
                                    <td>2023-10-01</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
