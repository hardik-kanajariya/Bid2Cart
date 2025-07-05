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
                                            <th>#User Id</th>
                                            <th>username</th>
                                            <th>Product</th>
                                            <th>Message</th>
                                            <th>schedule</th>
                                            <th>status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pickups as $data)
                                        <tr>
                                            <td>{{ $data->id }}</td>
                                            <td>{{ $data->username }}</td>
                                            <td>
                                                <a href="{{ url('/') }}/product/{{ $data->product_id }}/{{ $data->username }}">View
                                                    Product</a>
                                            </td>
                                            <td>
                                                @if ($data->message)
                                                {{ $data->message }}
                                                @else
                                                NO Messages
                                                @endif
                                            </td>
                                            <td>{{ $data->schedule }}</td>
                                            <td>
                                                @if ($data->status == 'pending')
                                                <label class="badge badge-warning">Pending</label>
                                                @elseif ($data->status == 'accepted')
                                                <label class="badge badge-success">Accepted</label>
                                                @elseif ($data->status == 'rejected')
                                                <label class="badge badge-danger">Rejected</label>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-inverse-success p-2" href="{{ url('/') }}/request/pickup/status/{{ $data->id }}/accepted">
                                                    Accept</a>
                                                <a class="btn btn-inverse-danger p-2" href="{{ url('/') }}/request/pickup/status/{{ $data->id }}/rejected">
                                                    Reject</a>
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
