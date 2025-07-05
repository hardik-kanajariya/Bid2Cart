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
                    {{-- Notification Area --}}
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                    {{-- Errors and Success messages --}}
                    @if (session()->has('msg'))
                        <div class="alert alert-success">{{ session('errmsg') }}</div>
                    @endif
                    @if (session()->has('errmsg'))
                        <div class="alert alert-danger">{{ session('errmsg') }}</div>
                    @endif
                    {{-- Body Content Starts --}}
                    <div class="card p-2 shadow-sm">
                        <form action="{{ url('/') }}/update/gallery" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="pid" value="{{ $id }}">
                            <input type="hidden" name="title" value="{{ $title }}">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Select product Gallary
                                    Images</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" multiple accept="image/*" capture
                                        name="image[]" max="5">
                                    <hr>
                                    <div class="parent p-3 shadow-sm">
                                        @php
                                            $img = json_decode($product['images']);
                                            $count = count($img);
                                        @endphp
                                        @for ($j = 0; $j < $count; $j++)
                                            <span class="position-relative m-3"
                                                id="image_{{ $j }}">
                                                <img class="m-1 border-separate"
                                                    src="{{ url('/') }}/uploads/product_image/{{ $img[$j] }}"
                                                    alt="" width="95" height="95">
                                                <input type="hidden" readonly value="{{ $img[$j] }}"
                                                    name="i{{ $j }}" id="delete_{{ $j }}">
                                                <i type="button"
                                                    class="icon-trash menu-icon position-absolute text-danger top-0 start-100 pointer"
                                                    style="font-size: 20px;"
                                                    onclick="remove('image_{{ $j }}', 'delete_{{ $j }}')"></i>
                                            </span>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 ">
                                    <a href="{{ back() }}"
                                        class="btn btn-inverse-secondary  float-right">Cancel</a>
                                    <button type="submit" class="btn btn-inverse-primary  float-right">Save
                                        Changes</button>
                                </div>
                            </div>
                        </form>
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
        function remove(id, did) {
            // alert(e);
            // let id = ;
            $("#" + did).attr("name","delete[]");
            $("#" + id).hide();
        }
    </script>
</body>

</html>
