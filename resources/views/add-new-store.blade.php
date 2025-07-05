<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bid2Cart Admin Panel</title>
    <!-- Common Head Files -->
    @include('includes.common-css')
    <link rel="stylesheet" href="{{ url('/') }}/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/vendors/jquery-bar-rating/bootstrap-stars.css">
    <link rel="stylesheet" href="{{ url('/') }}/vendors/jquery-bar-rating/css-stars.css">
    <link rel="stylesheet" href="{{ url('/') }}/vendors/jquery-bar-rating/examples.css">
    <link rel="stylesheet" href="{{ url('/') }}/vendors/jquery-bar-rating/fontawesome-stars-o.css">
    <link rel="stylesheet" href="{{ url('/') }}/vendors/jquery-bar-rating/fontawesome-stars.css">
    <style>
        .ck-editor__editable_inline {
            height: 350px !important;
        }
    </style>
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
                    {{-- <div class="alert alert-danger">{{ $message }}</div> --}}
                    {{-- validation Errors --}}
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                    {{-- validation Error Ends Here --}}
                    {{-- Displaying Notifications --}}
                    @if (session()->has('msg'))
                        <div class="alert alert-success">{{ session('msg') }}</div>
                    @endif
                    @if (session()->has('errmsg'))
                        <div class="alert alert-danger">{{ session('errmsg') }}</div>
                    @endif
                    {{-- Notifications Ends Here --}}
                    {{-- Body Content Starts --}}
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Store</h4>
                            <form class="forms-sample" method="POST" enctype="multipart/form-data"
                                action="{{url('/')}}/auctions/stores/new">
                                @csrf
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Enter Store Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            placeholder="store name" name="name" value="{{ old('name') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Enter Store Contact Number</label>
                                    <div class="col-sm-9">
                                        <input type="number" min="0" max="99999999999" class="form-control @error('phone') is-invalid @enderror"
                                            placeholder="Store Phone Number" name="phone"
                                            value="{{ old('phone') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Enter Street Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('street') is-invalid @enderror" placeholder="1, New Building" name="street">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Enter City</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" placeholder="City" value="{{ old('city') }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Enter State</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="state" class="form-control @error('state') is-invalid @enderror"
                                            placeholder="Enter State" value="{{ old('state') }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Enter Pincode</label>
                                    <div class="col-sm-9">
                                        <input type="number" min="111111" max="999999" name="pincode" class="form-control @error('pincode') is-invalid @enderror" placeholder="361320" value="{{ old('pincode') }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Enter Country</label>
                                    <div class="col-sm-9">
                                        <input type="text "name="country" class="form-control @error('country') is-invalid @enderror" value="canada" value="{{ old('country') }}" required>
                                    </div>
                                </div>



                                <div class="float-end">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </div>
                            </form>
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
    <script src="{{ url('/') }}/vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
    <script src="{{ url('/') }}/vendors/jquery-tags-input/jquery.tagsinput.min.js"></script>
    <script src="{{ url('/') }}/vendors/jquery.repeater/jquery.repeater.min.js"></script>
    <script src="{{ url('/') }}/js/form-addons.js"></script>
    <script src="{{ url('/') }}/js/formpickers.js"></script>
    <script src="{{ url('/') }}/js/form-repeater.js"></script>

    <script>
        ClassicEditor.create(document.querySelector('#conditionDesc')).then(editor => {
            console.log(editor);
        }).catch(error => {
            console.error(error);
        });
    </script>
</body>

</html>
