<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bid2Cart Admin Panel</title>
    <!-- Common Head Files -->
    @include('includes.common-css')
    <link rel="stylesheet" href="{{ url('/') }}/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/vendors/jquery-bar-rating/bootstrap-stars.css">
    <link rel="stylesheet" href="{{ url('/') }}/vendors/jquery-bar-rating/css-stars.css">
    <link rel="stylesheet" href="{{ url('/') }}/vendors/jquery-bar-rating/examples.css">
    <link rel="stylesheet" href="{{ url('/') }}/vendors/jquery-bar-rating/fontawesome-stars-o.css">
    <link rel="stylesheet" href="{{ url('/') }}/vendors/jquery-bar-rating/fontawesome-stars.css">

    {{-- Custom Css --}}
    <style>
        .parent {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* grid-template-rows: repeat(4, 1fr); */
            grid-column-gap: 0px;
            grid-row-gap: 0px;
        }

        .ratings {
            margin-right: 10px;
        }

        .ratings i {

            color: #cecece;
            font-size: 32px;
        }

        .rating-color {
            color: #fbc634 !important;
        }
    </style>
    {{-- Product Count Down Timer --}}
    <script>
        async function endCountDownTimer(start, end, id) {
            // Set the date we're counting down to
            var countDownDate = new Date(end).getTime();
            var startDate = new Date(start).getTime();
            // Update the count down every 1 second
            var x = setInterval(function() {
                var now = new Date().getTime();
                // console.log('Start: ' + startDate);
                // console.log('Now: ' + now);
                if (startDate > now) {
                    document.getElementById(id).innerHTML = "SCHEDULED";
                } else {
                    // Find the distance between now and the count down date
                    var distance = countDownDate - now;

                    // Time calculations for days, hours, minutes and seconds
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Output the result in an element with id=id
                    document.getElementById(id).innerHTML = days + "d " + hours + "h " +
                        minutes + "m " + seconds + "s ";

                    // If the count down is over, write some text
                    // console.log(distance);
                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById(id).innerHTML = "EXPIRED";
                    }
                }

            }, 1000);
        }
    </script>
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
                    <div class="bg-white shadow-sm row">
                        <form class="col-6 d-flex p-2">
                            <input type="text" name="search" class="form-control" placeholder="Search Products">
                            <button type="submit" class="btn btn-outline-success mx-2">Search</button>
                        </form>
                        <div class="p-2 col-6 d-flex flex-row w-100">
                            <select class="form-control form-control-sm|form-control-lg">
                                <option>Filter Auctions</option>
                                <option>Newly Arrived</option>
                                <option>Expiring Soon</option>
                                <option>Price: High to Low</option>
                                <option>Price: Low to High</option>
                            </select>
                            {{-- <a href="{{ url('/') }}/auctions/add/product" class="btn btn-primary mx-1"
                                style="width: 150px;">Add New</a> --}}
                        </div>
                    </div>
                    {{-- products Parts Starts from here --}}
                    <div class="parent">
                        {{-- Single Product Cards --}}
                        @foreach ($products as $product)
                            <div class="card p-2 m-2 shadow-sm d-flex flex-row rounded-none">
                                <img loading="lazy" loading=lazy
                                    src="{{ url('/') }}/uploads/product_thumbnail/{{ $product['thumbnail'] }}"
                                    alt="Products Image" width="200" height="200" class="image rounded-lg">
                                <div class="p-2">
                                    <b>{{ $product['title'] }}</b>
                                    <div class="d-flex">
                                        <div class="ratings">
                                            @php
                                                $rating = true;
                                            @endphp
                                            @for ($i = 1; $i <= 6; $i++)
                                                @if ($rating)
                                                    <i class="fa fa-star rating-color" style="font-size: 20px;"></i>
                                                    @if ($i == $product['condition_rating'])
                                                        @php
                                                            $rating = false;
                                                        @endphp
                                                    @endif
                                                @else
                                                    <i class="fa fa-star" style="font-size: 20px;"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    @php
                                        $id = Str::random(10) . time();
                                    @endphp
                                    <p class="card-description mx-2">Time Left: <span><b id="{{ $id }}">12d
                                                04:21:49</b></span> </p>
                                    <p class="card-description mx-2">Ends on:
                                        <span><b>{{ $product['end_time'] }}</b></span>
                                    </p>
                                    {{-- Calling count Down Timer Function --}}
                                    <script>
                                        endCountDownTimer('{{ $product['start_time'] }}', '{{ $product['end_time'] }}', '{{ $id }}');
                                    </script>
                                    <div class="d-flex">
                                        <a href="{{ url('/') }}/product/{{ $product['prd_id'] }}/{{ $product['title'] }}"
                                            class="btn btn-sm btn-outline-primary mx-1">View</a>
                                        <a href="{{ url('/') }}/auction/product/update/{{ $product['prd_id'] }}/{{ $product['title'] }}"
                                            class="btn btn-sm btn-outline-secondary mx-1">Update</a>
                                        <a href="{{ url('/') }}/auction/product/delete/{{ $product['prd_id'] }}"
                                            class="btn btn-sm btn-outline-danger mx-1">Delete</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{-- Single Product cards ends here --}}
                    </div>
                    {{ $products->links('vendor.pagination.product-pagination') }}
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
    <script src="{{ url('/') }}/vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
    <script src="{{ url('/') }}/vendors/jquery-tags-input/jquery.tagsinput.min.js"></script>
    <script src="{{ url('/') }}/js/form-addons.js"></script>
    <script src="{{ url('/') }}/js/form-repeater.js"></script>

</body>

</html>