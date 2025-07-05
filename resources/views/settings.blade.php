<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bid2Cart Admin Panel</title>
    <!-- Common Head Files -->
    @include('includes.common-css')
    <style>
        .ck-editor__editable_inline {
            height: 350px !important;
        }
    </style>
    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/35.2.1/classic/ckeditor.js"></script>

</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include('includes.navbar')
        <div class="container-fluid page-body-wrapper">
            <!-- sidebar -->
            @include('includes.sidebar')
            <!-- Content Goes Here -->
            <div class="main-panel">
                <div class="content-wrapper">
                    {{-- Body Content Starts --}}
                    <div class="card">
                        <div class="card-body">
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                            @if (session()->has('msg'))
                                <div class="alert alert-success">{{ session('msg') }}</div>
                            @endif
                            <ul class="nav nav-pills nav-pills-success" id="pills-tab" role="tablist">
                                <li class="nav-item m-1">
                                    <a class="nav-link active" id="pills-invoice-tab" data-bs-toggle="pill"
                                        href="#pills-invoice" role="tab" aria-controls="pills-invoice"
                                        aria-selected="true">Invoice Settings</a>
                                </li>
                                <li class="nav-item m-1">
                                    <a class="nav-link" id="pills-about-tab" data-bs-toggle="pill" href="#pills-about"
                                        role="tab" aria-controls="pills-about" aria-selected="true">About us</a>
                                </li>
                                <li class="nav-item m-1">
                                    <a class="nav-link" id="pills-shipping-tab" data-bs-toggle="pill"
                                        href="#pills-shipping" role="tab" aria-controls="pills-shipping"
                                        aria-selected="true">Shipping Info</a>
                                </li>
                                <li class="nav-item m-1">
                                    <a class="nav-link" id="pills-consignment-tab" data-bs-toggle="pill"
                                        href="#pills-consignment" role="tab" aria-controls="pills-consignment"
                                        aria-selected="true">Consignment
                                        Notice</a>
                                </li>
                                <li class="nav-item m-1">
                                    <a class="nav-link" id="pills-suspension-tab" data-bs-toggle="pill"
                                        href="#pills-suspension" role="tab" aria-controls="pills-suspension"
                                        aria-selected="true">Account
                                        Suspension Notice</a>
                                </li>
                                <li class="nav-item m-1">
                                    <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        href="#pills-profile" role="tab" aria-controls="pills-profile"
                                        aria-selected="false">Terms</a>
                                </li>
                                <li class="nav-item m-1">
                                    <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                        href="#pills-contact" role="tab" aria-controls="pills-contact"
                                        aria-selected="false">Policy</a>
                                </li>
                                <li class="nav-item m-1">
                                    <a class="nav-link" id="pills-accessibility-tab" data-bs-toggle="pill"
                                        href="#pills-accessibility" role="tab" aria-controls="pills-accessibility"
                                        aria-selected="false">Accessibility</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade active show" id="pills-invoice" role="tabpanel"
                                    aria-labelledby="pills-invoice-tab">
                                    <h4>Manage Invoice Settings</h4>
                                    <form action="{{ url('/') }}/settings/invoice" method="POST" class="p-4">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="" class="col-sm-3 col-form-label">Enter Tax</label>
                                            <div class="col-sm-9">
                                                <input type="text" value="{{ $invoice->tax }}" class="form-control"
                                                    name="tax">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-3 col-form-label">Enter Bid2Cart
                                                Fees</label>
                                            <div class="col-sm-9">
                                                <input type="text" value="{{ $invoice->b2c_fee }}"
                                                    class="form-control" name="fee">
                                            </div>
                                        </div>
                                        <div class="float-right mt-2 clear-right">
                                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                                            <button class="btn btn-light">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-about" role="tabpanel"
                                    aria-labelledby="pills-about-tab">
                                    <h4>About Us</h4>
                                    <form action="{{ url('/') }}/settings/about" method="POST" class="p-4">
                                        @csrf
                                        <textarea class="form-control" name="update" id="aboutUS" cols="30" rows="10">{{ $settingsData['about_us'] }}</textarea>
                                        <div class="float-right mt-2 clear-right">
                                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                                            <button class="btn btn-light">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-shipping" role="tabpanel"
                                    aria-labelledby="pills-shipping-tab">
                                    <h4>Shipping info</h4>
                                    <form action="{{ url('/') }}/settings/shipping" method="POST"
                                        class="p-4">
                                        @csrf
                                        <textarea class="form-control" name="update" id="shippingInfo" cols="30" rows="10">{{ $settingsData['shipping_info'] }}</textarea>
                                        <div class="float-right mt-2 clear-right">
                                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                                            <button class="btn btn-light">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-consignment" role="tabpanel"
                                    aria-labelledby="pills-consignment-tab">
                                    <h4>consignment Notice</h4>
                                    <form action="{{ url('/') }}/settings/consignment" method="POST"
                                        class="p-4">
                                        @csrf
                                        <textarea class="form-control" name="update" id="consignmentNotice" cols="30" rows="10">{{ $settingsData['consignments'] }}</textarea>
                                        <div class="float-right mt-2 clear-right">
                                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                                            <button class="btn btn-light">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-suspension" role="tabpanel"
                                    aria-labelledby="pills-suspension-tab">
                                    <h4>suspension Notice</h4>
                                    <form action="{{ url('/') }}/settings/suspension" method="POST"
                                        class="p-4">
                                        @csrf
                                        <textarea class="form-control" name="update" id="suspensionNotice" cols="30" rows="10">{{ $settingsData['account_suspension'] }}</textarea>
                                        <div class="float-right mt-2 clear-right">
                                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                                            <button class="btn btn-light">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">
                                    <h4>Privacy Policy</h4>
                                    <form action="{{ url('/') }}/settings/policy" method="POST"
                                        class="p-4">
                                        @csrf
                                        <textarea class="form-control" name="update" id="Terms" cols="30" rows="10">{{ $settingsData['policy'] }}</textarea>
                                        <div class="float-right mt-2 clear-right">
                                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                                            <button class="btn btn-light">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">
                                    <h4>Terms & Conditions</h4>
                                    <form action="{{ url('/') }}/settings/terms" method="POST" class="p-4">
                                        @csrf
                                        <textarea class="form-control" name="update" id="Policy" cols="30" rows="10">{{ $settingsData['terms'] }}</textarea>
                                        <div class="float-right mt-2 clear-right">
                                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                                            <button class="btn btn-light">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-accessibility" role="tabpanel"
                                    aria-labelledby="pills-accessibility-tab">
                                    <h4>Accessibility</h4>
                                    <div class="card">
                                        <a href="{{ url('/') }}/bot.php?manual=true"
                                            onclick="return confirm('Are you sure you want to do this this activity can not UNDO once you confirm...')">Manually
                                            announce winning results</a>
                                    </div>
                                    <hr>
                                    <h5>Cron job logs</h5>
                                    <ul>
                                        @foreach ($logs as $data)
                                            @php
                                                $r = json_decode($data->record);
                                                echo "<pre><code>";
                                                print_r($r);
                                                echo "</code></pre>";
                                            @endphp
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Body Content Ends Here --}}
                </div>
                <!-- content-wrapper ends -->
                @include('includes.footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <!-- Common JS Files -->
    @include('includes.common-js')

    <script>
        ClassicEditor.create(document.querySelector('#appDesc')).then(editor => {
            console.log(editor);
        }).catch(error => {
            console.error(error);
        });
        ClassicEditor.create(document.querySelector('#aboutUS')).then(editor => {
            console.log(editor);
        }).catch(error => {
            console.error(error);
        });
        ClassicEditor.create(document.querySelector('#shippingInfo')).then(editor => {
            console.log(editor);
        }).catch(error => {
            console.error(error);
        });
        ClassicEditor.create(document.querySelector('#suspensionNotice')).then(editor => {
            console.log(editor);
        }).catch(error => {
            console.error(error);
        });
        ClassicEditor.create(document.querySelector('#consignmentNotice')).then(editor => {
            console.log(editor);
        }).catch(error => {
            console.error(error);
        });
        ClassicEditor.create(document.querySelector('#Terms')).then(editor => {
            console.log(editor);
        }).catch(error => {
            console.error(error);
        });
        ClassicEditor.create(document.querySelector('#Policy')).then(editor => {
            console.log(editor);
        }).catch(error => {
            console.error(error);
        });
    </script>
</body>

</html>
