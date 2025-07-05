<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bid2Cart Admin Panel</title>
    <!-- Common Head Files -->
    @include('includes.common-css')
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
                            <form class="forms-sample row" onsubmit="return false;">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Support Id</label>
                                        <input type="text" class="form-control" value="{{ $sid }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" value="{{ $username }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        @if ($status == 'pending')
                                            <label class="badge badge-warning">Pending</label>
                                        @elseif ($status == 'resolved')
                                            <label class="badge badge-success">Resolved</label>
                                        @elseif ($status == 'active')
                                            <label class="badge badge-primary">Active</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Product Title</label>
                                        <input type="text" class="form-control" value="{{ $pname }}" readonly>
                                        <a href="{{ url('/') }}/product/{{ $pid }}/{{ $pname }}">View
                                            Product</a>
                                    </div>
                                    <div class="form-group">
                                        <label>Question</label>
                                        <input type="text" class="form-control" value="{{ $question }}" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <h2>Reply user</h2>
                        </div>
                        <div class="card-body">
                            <form class="forms-sample" method="POST"
                                action="{{ url('/') }}/request/supports/reply">
                                @csrf
                                <div class="form-group">
                                    <label>Support Id</label>
                                    <input name="sid" type="text" class="form-control"
                                        value="{{ $sid }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username"
                                        value="{{ $username }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Notification Title</label>
                                    <input type="text" class="form-control" name="title">
                                </div>
                                <div class="form-group">
                                    <label>Notification Message</label>
                                    <textarea class="form-control" name="message" id="notificationMessage" cols="30" rows="10"></textarea>
                                </div>
                                <button type="submit" class="btn btn-outline-primary btn-sm rounded-0 p-3">Send
                                    Reply</button>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-2">
                        <div class="card-header">
                            <h2>Notification History</h2>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                @php
                                    $num = 0;
                                @endphp
                                @foreach ($notis as $noti)
                                    @if ($num % 2 == 0)
                                        <div class="timeline-wrapper timeline-wrapper-primary">
                                            <div class="timeline-badge"></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h6 class="timeline-title">{{ $noti->title }}</h6>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>{!! $noti->message !!}</p>
                                                </div>
                                                <div class="timeline-footer d-flex align-items-center flex-wrap">
                                                    <span class="text-success">{{ $noti->username }}</span>
                                                    <span class="ml-md-auto font-weight-bold">19 Oct 2017</span>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="timeline-wrapper timeline-inverted timeline-wrapper-danger">
                                            <div class="timeline-badge"></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h6 class="timeline-title">{{ $noti->title }}</h6>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>{!! $noti->message !!}</p>
                                                </div>
                                                <div class="timeline-footer d-flex align-items-center flex-wrap">
                                                    <span class="text-success">{{ $noti->username }}</span>
                                                    <span class="ml-md-auto font-weight-bold">{{ date('d-m-Y', strtotime($noti->created_at)) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @php
                                        $num++;
                                    @endphp
                                @endforeach
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
    <script>
        ClassicEditor.create(document.querySelector('#notificationMessage')).then(editor => {
            console.log(editor);
        }).catch(error => {
            console.error(error);
        });
    </script>
</body>

</html>
