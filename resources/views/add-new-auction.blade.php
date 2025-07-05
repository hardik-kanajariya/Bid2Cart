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
                            <h4 class="card-title">schedule new Auction</h4>
                            <form class="forms-sample" method="POST" enctype="multipart/form-data"
                                action="{{ route('schedule-new-auction') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Enter Start Time</label>
                                    <div class="col-sm-9">
                                        <input type="date"
                                            class="form-control col-sm-4 d-inline @error('start-date') is-invalid @enderror"
                                            name="start-date" value="{{ old('start-date') }}">
                                        <input type="time"
                                            class="form-control col-sm-4 d-inline @error('start-time') is-invalid @enderror"
                                            name="start-time" value="{{ old('start-time') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Select End Time</label>
                                    <div class="col-sm-9">
                                        <input type="date"
                                            class="form-control col-sm-4 d-inline @error('start-date') is-invalid @enderror"
                                            name="end-date" value="{{ old('end-time') }}">
                                        <input type="time"
                                            class="form-control col-sm-4 d-inline @error('start-date') is-invalid @enderror"
                                            name="end-time" value="{{ old('end-time') }}">
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
</body>

</html>
