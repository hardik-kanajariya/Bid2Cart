<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bid2Cart Admin Panel</title>
    <!-- Common Head Files -->
    @include('includes.common-css')
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
                    {{-- Notifications Area --}}
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                    {{-- Errors and success messages --}}
                    @if (session()->has('msg'))
                        <div class="alert alert-success">{{ session('msg') }}</div>
                    @endif
                    @if (session()->has('errmsg'))
                        <div class="alert alert-danger">{{ session('errmsg') }}</div>
                    @endif
                    {{-- Body Content Starts --}}
                    <form class="forms-sample row">
                        <div class="col-6">
                          <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" value="{{ $users->first_name }}" readonly>
                          </div>
                          <div class="form-group">
                            <label>Street Address</label>
                            <input type="text" class="form-control" value="{{ $users->address }}" readonly>
                          </div>
                          <div class="form-group">
                            <label>State</label>
                            <input type="text" class="form-control" value="{{ $users->state }}" readonly>
                          </div>
                          <div class="form-group">
                            <label>Zip</label>
                            <input type="text" class="form-control" value="{{ $users->zip }}" readonly>
                          </div>
                          <div class="form-group">
                            <label>How Did You Hear About Us</label>
                            <input type="text" class="form-control" value="{{ $users->ads }}" readonly>
                          </div>
                          <div class="form-group">
                            <label>News Later</label>
                            <input type="text" class="form-control" value="{{ $users->news_later }}" readonly placeholder="Not Subscribed">
                          </div>
                          <div class="form-group">
                            <label>Google-Id</label>
                            <input type="text" class="form-control" value="{{ $users->google_id }}" readonly>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control"  value="{{ $users->last_name }}" readonly>
                          </div>
                          <div class="form-group">
                            <label>City</label>
                            <input type="email" class="form-control" value="{{ $users->city }}" readonly>
                          </div>
                          <div class="form-group">
                            <label>Country</label>
                            <input type="text" class="form-control" value="{{ $users->country }}" readonly>
                          </div>
                          <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" value="{{ $users->phone }}" readonly>
                          </div>
                          <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ $users->email }}" readonly>
                          </div>
                          <div class="form-group">
                            <label>Email Verified</label>
                            <input type="text" class="form-control" value="{{ $users->email_verified_at }}" readonly>
                          </div>
                          <div class="form-group p-4">
                            <a class="float-end m-1 btn btn-outline-success btn-sm p-3" href="{{ url('/') }}/users/update/{{ $id }}/active">Activate Account</a>
                            <a class="float-end m-1 btn btn-outline-danger btn-sm p-3" href="{{ url('/') }}/users/update/{{ $id }}/declined">Deactivate Account</a>
                          </div>
                        </div>
                      </form>
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
    <script src="{{ url('/') }}/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
</body>

</html>
