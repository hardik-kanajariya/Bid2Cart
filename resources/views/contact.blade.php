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
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th style="display: none;">Message</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list as $row)
                                            <tr>
                                                <td>{{ $row->id }}</td>
                                                <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                                <td>{{ $row->mobile }}</td>
                                                <td>{{ $row->email }}</td>
                                                <td>{{ $row->subject }}</td>
                                                <td style="display: none;">{{ $row->message }}</td>
                                                <td>
                                                    @if ($row->status == 'pending')
                                                        <label class="badge badge-warning">Pending</label>
                                                    @elseif ($row->status == 'resolved')
                                                        <label class="badge badge-success">Resolved</label>
                                                    @elseif ($row->status == 'active')
                                                        <label class="badge badge-primary">Active</label>
                                                    @elseif ($row->status == 'not-solved')
                                                        <label class="badge badge-danger">Not Solved</label>
                                                    @endif
                                                </td>
                                                <td><button class="edit btn btn-outline-behance p-2"
                                                        style="width: 100px;">View</button></td>
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

                {{-- Contact Message View Modal --}}
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="subject">Modal title</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p id="msg">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsum
                                    voluptatem est laborum similique? Esse officia cupiditate nulla adipisci, fugiat,
                                    molestiae iusto debitis maiores, error magnam exercitationem modi minima excepturi
                                    ut sed magni ducimus quis?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#" id="active" class="btn btn-primary">Mark as Active</a>
                                <a href="#" id="resolved" class="btn btn-success">Mark as Resolved</a>
                                <a href="#" id="not-solved" class="btn btn-danger">Mark as Not Solved</a>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <!-- Common JS Files -->
    @include('includes.common-js')
    <script src="{{ url('/') }}/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                tr = e.target.parentNode.parentNode;
                id = tr.getElementsByTagName("td")[0].innerText;
                title = tr.getElementsByTagName("td")[4].innerText;
                message = tr.getElementsByTagName("td")[5].innerText;
                // console.log(name, title, msg);
                subject.innerText = title;
                msg.innerText = message;
                $('#active').attr('href', "{{ url('/') }}/request/contact/" + id + "/active");
                $('#resolved').attr('href', "{{ url('/') }}/request/contact/" + id + "/resolved");
                $('#not-solved').attr('href', "{{ url('/') }}/request/contact/" + id + "/not-solved");
                $('#exampleModal').modal('toggle');
            })
        })
    </script>
</body>

</html>
