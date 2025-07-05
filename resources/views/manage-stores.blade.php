<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bid2Cart Admin Panel</title>
    <!-- Common Head Files -->
    @include('includes.common-css')
    {{-- Custom CSS For this Page --}}
    <style>
        .table td img,
        .jsgrid .jsgrid-table td img {
            width: auto;
            height: auto;
            border-radius: 0%;
        }
    </style>
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
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                    {{-- {{ dd(session()->all()) ;}} --}}
                    @if (session()->has('msg'))
                        <div class="alert alert-success">{{ session('msg') }}</div>
                    @endif

                    {{-- Body Content Starts --}}
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Manage Stores</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Store Id#</th>
                                                    <th>Store Name</th>
                                                    <th>Store Description</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($stores as $row)
                                                    <tr>
                                                        <td>{{ $row['id'] }}</td>
                                                        <td>{{ $row['store_name'] }}</td>
                                                        <td>{{ $row['phone'] }}</td>
                                                        <td>
                                                            @if ($row['status'] == 'open')
                                                                <label class="badge badge-success">Open</label>
                                                            @elseif ($row['status'] == 'closed')
                                                                <label class="badge badge-danger">Closed</label>
                                                            @else
                                                                <label class="badge badge-warning">No Status</label>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('/') }}/auctions/stores/update/{{ $row['id'] }}/{{ $row['store_name'] }}"
                                                                class="btn btn-outline-primary p-2 update">Update</a>
                                                            <a href="{{ url('/') }}/auctions/stores/delete/{{ $row['id'] }}"
                                                                class="btn btn-outline-danger p-2">Delete</a>
                                                            @if ($row['status'] == 'open')
                                                                <a href="{{ url('/') }}/auctions/stores/status/{{ $row['id'] }}/closed"
                                                                    class="btn btn-outline-secondary p-2">Close Store</a>
                                                            @elseif ($row['status'] == 'closed')
                                                                <a href="{{ url('/') }}/auctions/stores/status/{{ $row['id'] }}/open"
                                                                    class="btn btn-outline-secondary p-2">Open Store</a>
                                                            @else
                                                                <label class="badge badge-warning">No Status</label>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
    {{-- Custom JS For this Page --}}
    <!-- Plugin js for this page-->
    <script src="{{ url('/') }}/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script>
        $(document).ready(function() {
            const element = document.getElementById("order-listing_filter");
            var tag = document.createElement("div");
            tag.setAttribute("id", "addRecordElement");
            tag.setAttribute("class", "mx-2");
            element.setAttribute("class", "d-flex justify-content-end");
            element.setAttribute("style", "");
            element.appendChild(tag);
            document.getElementById("addRecordElement").innerHTML =
                `<a href="{{ url('/') }}/auctions/stores/new" class="btn btn-primary p-3 text-white shadow-sm" style="width: 200px;">Add New Record</a>`;
        })
    </script>
</body>

</html>
