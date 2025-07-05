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
                    <div class="card">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table id="order-listing" class="table">
                              <thead>
                                <tr>
                                    <th>#Id</th>
                                    <th>UserName</th>
                                    <th>Question</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($supports as $data)
                                  <tr>
                                    <td>{{ $data->support_id }}</td>
                                    <td>{{ $data->username }}</td>
                                    <td>{{ $data->question }}</td>
                                    <td>{{ $data->status }}</td>
                                    <td>
                                      @if ($data->status == 'pending')
                                        <label class="badge badge-warning">Pending</label>
                                      @elseif ($data->status == 'resolved')
                                        <label class="badge badge-success">Resolved</label>
                                      @elseif ($data->status == 'active')
                                        <label class="badge badge-primary">Active</label>
                                      @endif
                                    </td>
                                    <td>
                                      <a href="{{ url('/') }}/request/supports/{{ $data->support_id }}/{{ $data->product_id }}/{{ $data->username }}" class="btn btn-outline-primary btn-sm rounded-0 p-3">View</a>
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
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
    <script src="{{ url('/') }}/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
</body>

</html>
