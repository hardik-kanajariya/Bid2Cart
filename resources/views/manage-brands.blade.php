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
                            <h4 class="card-title">Manage Brands</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Brand Id#</th>
                                                    <th>Brand Name</th>
                                                    <th>Brand Description</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach ($brands as $row)
                                                    <tr>
                                                        <td>{{ $row['id'] }}</td>
                                                        <td>{{ $row['brand_name'] }}</td>
                                                        <td>@if ($row['brand_desc'])
                                                            {{ $row['brand_desc'] }}
                                                        @else
                                                            No Description
                                                        @endif</td>
                                                        {{-- <td>{{ $pCount[$i] }}</td> --}}
                                                        <td>
                                                            <button class="btn btn-outline-primary p-2 update">Update</button>
                                                            <a href="{{ url('/') }}/delete/brand/{{ $row['id'] }}" class="btn btn-outline-danger p-2">Delete</a>
                                                            <a href="{{ url('/') }}/php/brand-invoice.php?brand={{ $row['brand_name'] }}" class="btn btn-outline-info p-2">Generate Invoice</a>
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
                <!-- Add New Brand Modal Starts -->
                <div class="modal fade" id="addNewBrand" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form class="forms-sample material-form" method="POST"
                                    action="{{ url('/') }}/insert/brand">
                                    @csrf
                                    <div class="form-group">
                                        <input name="brand_name" type="text" placeholder="Enter Brand name"
                                            required />
                                        <br><br>
                                        <textarea name="brand_desc" class="form-control" cols="30" rows="10" placeholder="Brand Description"></textarea>
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
                <!-- Add New Brand Modal -->
                <!-- Update Brand Modal Starts -->
                <div class="modal fade" id="updateBrand" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form class="forms-sample material-form" method="POST"
                                    action="{{ url('/') }}/update/brand">
                                    @csrf
                                    <input type="hidden" value="" id="BrandId" name="Brand_id">
                                    <div class="form-group">
                                        <input id="BrandName" name="brand_name" type="text"
                                            placeholder="Enter Brand name" required />
                                        <br><br>
                                        <textarea name="brand_desc" class="form-control" cols="30" rows="10" placeholder="Brand Description"></textarea>
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
                <!-- Update Brand Modal -->
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
                `<button type="button" class="btn btn-primary p-3 text-white shadow-sm" style="width: 200px;" id="addRecordBtn" data-bs-toggle="modal" data-bs-target="#addNewBrand">Add New Record</button>`;
        })
        // Updates
        update = document.getElementsByClassName('update');
        Array.from(update).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                id = tr.getElementsByTagName("td")[0].innerText;
                name = tr.getElementsByTagName("td")[1].innerText;
                desc = tr.getElementsByTagName("td")[2].innerText;
                $("#BrandId").val(id);
                $("#BrandName").val(name);
                $("#BrandDesc").val(desc);
                $('#updateBrand').modal('toggle');
            })
        })
    </script>
</body>

</html>
