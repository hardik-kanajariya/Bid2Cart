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
                    {{-- validation Errors --}}
                    @error('aid')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('start-date')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('start-time')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('end-date')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('end-time')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
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
                            <h4 class="card-title">Manage Auction schedules</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Order #</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($auction as $data)
                                                    <tr>
                                                        <td>{{ $data['aid'] }}</td>
                                                        <td>{{ $data['start_date'] }}&nbsp;{{ $data['start_time'] }}
                                                        </td>
                                                        <td>{{ $data['end_date'] }}&nbsp;{{ $data['end_time'] }}</td>
                                                        <td>
                                                            @if ($data['status'] == 'pending')
                                                                <label class="badge badge-danger">scheduled</label>
                                                            @elseif ($data['status'] == 'active')
                                                                <label class="badge badge-primary">Running</label>
                                                            @else
                                                                <label class="badge badge-success">Completed</label>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button
                                                                class="btn btn-sm p-2 btn-outline-primary mx-1 update">Update</button>
                                                            <a href="{{ url('/') }}/auctions/schedule/delete/{{ $data['aid'] }}"
                                                                class="btn btn-sm p-2 btn-outline-danger mx-1">Delete</a>
                                                            @if ($data['status'] == 'pending')
                                                                <a href="{{ url('/') }}/auctions/status/{{ $data['aid'] }}/active"
                                                                    class="btn btn-sm p-2 btn-outline-success mx-1">Activate</a>
                                                            @elseif ($data['status'] == 'active')
                                                                <a href="{{ url('/') }}/auctions/status/{{ $data['aid'] }}/pending"
                                                                    class="btn btn-sm p-2 btn-outline-warning mx-1">Stop</a>
                                                            @else
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
                <!-- Update Category Modal Starts -->
                <div class="modal fade" id="updateCategory" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md " role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form class="forms-sample material-form" method="POST"
                                    action="{{ route('schedule-update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="" id="aid" name="aid">
                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 col-form-label">Start Time</label>
                                        <div class="col-sm-9">
                                            <input type="date"
                                                class="form-control col-sm-6 d-inline @error('start-date') is-invalid @enderror"
                                                name="start-date" value="{{ old('start-date') }}">
                                            <input type="time"
                                                class="form-control col-sm-5 d-inline @error('start-time') is-invalid @enderror"
                                                name="start-time" value="{{ old('start-time') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 col-form-label">End Time</label>
                                        <div class="col-sm-9">
                                            <input type="date"
                                                class="form-control col-sm-6 d-inline @error('start-date') is-invalid @enderror"
                                                name="end-date" value="{{ old('end-time') }}">
                                            <input type="time"
                                                class="form-control col-sm-5 d-inline @error('start-date') is-invalid @enderror"
                                                name="end-time" value="{{ old('end-time') }}">
                                        </div>
                                    </div>
                                    <div class="button-container d-flex justify-content-center align-items-center">
                                        <button type="submit"
                                            class="button btn btn-primary"><span>Submit</span></button>
                                        &nbsp;&nbsp;&nbsp;
                                        <button type="button" class="button btn btn-light"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Update Category Modal -->
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
                `<a href="{{ url('/') }}/auctions/add/schedule" type="button" class="btn btn-primary p-3 text-white shadow-sm" style="width: 200px" >Add New Record</a>`;
        })

        // Updates
        update = document.getElementsByClassName('update');
        Array.from(update).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                id = tr.getElementsByTagName("td")[0].innerText;
                console.log('Auction id = ' + id);
                $("#aid").val(id);
                $('#updateCategory').modal('toggle');
            })
        })
    </script>
</body>

</html>
