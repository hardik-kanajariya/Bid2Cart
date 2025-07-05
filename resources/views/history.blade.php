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
                    {{-- Body Content Starts --}}
                    <div class="card">
                        <div class="card-body">
                            <h2>{{ $productData->title }}</h2>
                            <div class="row align-items-center justify-content-center">
                                <div class="mb-1 col-6">
                                    <label for="">SKU Code: </label>
                                    <input type="text" class="form-control" readonly value="{{ $productData->sku }}">
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="">Minimum Bid</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $productData->minimum_bid }}">
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="">Retail Value</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $productData->retail_value }}">
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="">End time</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $productData->end_time }}">
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="">Brand Name</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $productData->brand_name }}">
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="">Purchase Price</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $productData->purchase_price }}">
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="">Highest Bid Amount</label>
                                    <input type="text" class="form-control is-valid" readonly value="{{ $highestBid }}">
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="">Highest Bidder</label>
                                    <input type="text" class="form-control is-valid" readonly
                                        value="{{ $maxBidder }}">
                                </div>
                                <div class="mb-1 col-6">
                                    
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table id="order-listing" class="table">
                                    <thead>
                                        <tr>
                                            <th>#Id</th>
                                            <th>Bidder</th>
                                            <th>Amount</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($historyData as $data)
                                            <tr>
                                                <td>{{ $data->id }}</td>
                                                <td>{{ $data->bidder }}</td>
                                                <td>{{ $data->amount }}</td>
                                                <td>{{ $data->created_at }}</td>
                                                <td> 
                                                    @if ($data->status == 'winning')
                                                        <label class="badge badge-outline-success">Winning</label>
                                                    @elseif ($data->status == 'loosing')
                                                        <label class="badge badge-outline-danger">Loosing</label>
                                                    @endif
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
    <script src="{{ url('/') }}/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="{{ url('/') }}/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="{{ url('/') }}/vendors/dropify/dropify.min.js"></script>
    <script src="{{ url('/') }}/js/dropify.js"></script>
</body>

</html>
