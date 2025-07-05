<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bid2Cart Admin</title>
    @include('includes.common-css')
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <div class="col-lg-12 d-flex align-items-center justify-content-center">
                        <div class="auth-form-transparent text-left p-3 w-50">
                            <h2>Welcome to Bid2Cart!</h2>
                            <h3 class="font-weight-light">Made every day in this place so much brighter!</h3>
                            <form class="pt-3" action="{{ url('/') }}/0Auth2/login" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail">Username</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="ti-user text-primary"></i>
                                            </span>
                                        </div>
                                        <input name="username" type="text"
                                            class="form-control form-control-lg border-left-0" id="exampleInputEmail"
                                            placeholder="Username" value="{{ old('username') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword">Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="ti-lock text-primary"></i>
                                            </span>
                                        </div>
                                        <input name="password" type="password"
                                            class="form-control form-control-lg border-left-0" id="exampleInputPassword"
                                            placeholder="Password">
                                    </div>
                                </div>
                                <div class="my-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOGIN</button>
                                </div>
                            </form>
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                            @if (session()->has('msg'))
                                <div class="alert alert-info">{{ session('msg') }}</div>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="col-lg-6 login-half-bg d-flex flex-row">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2021  All rights reserved.</p>
          </div> --}}
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ url('/') }}/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ url('/') }}/js/off-canvas.js"></script>
    <script src="{{ url('/') }}/js/hoverable-collapse.js"></script>
    <script src="{{ url('/') }}/js/template.js"></script>
    <script src="{{ url('/') }}/js/settings.js"></script>
    <script src="{{ url('/') }}/js/todolist.js"></script>
    <!-- endinject -->
</body>

</html>
