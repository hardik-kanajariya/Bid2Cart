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
                            <h4 class="card-title">Manage Categories</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Order #</th>
                                                    <th>Thumbnail</th>
                                                    <th style="display: none;">old Thumbnail</th>
                                                    <th>Category Name</th>
                                                    <th>Products</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach ($category as $row)
                                                    <tr>
                                                        <td>{{ $row['cat_id'] }}</td>
                                                        <td>
                                                            @if ($row['category_thumbnail'] == '')
                                                                No Image
                                                            @else
                                                                <input type="file" class="dropify" disabled
                                                                    data-default-file="{{ url('/') }}/uploads/category_thumbnail/{{ $row['category_thumbnail'] }}"
                                                                    data-max-file-size="30kb" data-height="100">
                                                            @endif
                                                        </td>
                                                        <td style="display: none;">{{ $row['category_thumbnail'] }}</td>
                                                        <td>{{ $row['category_name'] }}</td>
                                                        <td>{{ $pCount[$i] }}</td>
                                                        <td>
                                                            <button
                                                                class="btn btn-outline-primary p-2 update">Update</button>
                                                            <a href="{{ url('/') }}/delete-category/{{ $row['cat_id'] }}/{{ $row['category_thumbnail'] }}"
                                                                class="btn btn-outline-danger p-2">Delete</a>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                    @endphp
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
                <!-- Add New Category Modal Starts -->
                <div class="modal fade" id="addNewCategory" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form class="forms-sample material-form" method="POST"
                                    action="{{ url('/') }}/add-new-category" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input name="category_name" type="text" placeholder="Enter Category name"
                                            required />
                                        <br><br>
                                        <input name="thumbnail" type="file" class="form-control"
                                            accept=".jpg, .png, .jpeg" required />
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
                <!-- Add New Category Modal -->
                <!-- Update Category Modal Starts -->
                <div class="modal fade" id="updateCategory" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form class="forms-sample material-form" method="POST"
                                    action="{{ url('/') }}/update-category" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="" id="categroyId" name="category_id">
                                    <div class="form-group">
                                        <input id="categroyName" name="category_name" type="text"
                                            placeholder="Enter Category name" required />
                                        <br><br>
                                        <input id="image" name="thumbnail" type="file" class="form-control"
                                            accept=".jpg, .png, .jpeg" />
                                        <input type="hidden" name="old_thumbnail" value="" id="old_thumbnail">
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
                `<button type="button" class="btn btn-primary p-3 text-white shadow-sm" style="width: 200px;" id="addRecordBtn" data-bs-toggle="modal" data-bs-target="#addNewCategory">Add New Record</button>`;
        })
        // Updates
        update = document.getElementsByClassName('update');
        Array.from(update).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                name = tr.getElementsByTagName("td")[3].innerText;
                id = tr.getElementsByTagName("td")[0].innerText;
                oldPhoto = tr.getElementsByTagName("td")[2].innerText;
                console.log("Old Photo: " + oldPhoto);
                $("#categroyName").val(name);
                $("#categroyId").val(id);
                $('#old_thumbnail').val(oldPhoto);
                $('#updateCategory').modal('toggle');
            })
        })
    </script>
</body>

</html>
