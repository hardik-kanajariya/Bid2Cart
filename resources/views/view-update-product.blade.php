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
    <style>
        .ck-editor__editable_inline {
            height: 350px !important;
        }
        .parent {
          display: grid;
          grid-template-columns: repeat(5, 1fr);
          grid-template-rows: repeat(1, 1fr);
          grid-column-gap: 0px;
          grid-row-gap: 0px;
      }
    </style>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.2.1/classic/ckeditor.js"></script>
    {{-- Product Count Down Timer --}}
    <script>
        async function endCountDownTimer(time, id) {
            // Set the date we're counting down to
            var countDownDate = new Date(time).getTime();

            // Update the count down every 1 second
            var x = setInterval(function(callback) {

                // Get today's date and time
                var now = new Date().getTime();

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
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(id).innerHTML = "EXPIRED";
                }
                callback();
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
                    {{-- validation Errors --}}
                    @error('update_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('website')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('rating')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('condition_desc')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('condition_note')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('min_bid')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('retail_value')
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
                    <div class="card p-2">
                        <form action="{{ route('update-product') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $id }}" name="update_id">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Product SKU code</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $product['sku'] }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Product Expiry Time</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $product['end_time'] }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Select Product Category</label>
                                <div class="col-sm-9">
                                    <select name="category_id" id="id"
                                        class="form-control @error('category_id') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($category as $data)
                                            @if ($data['cat_id'] == $i)
                                                <option selected value="{{ $data['cat_id'] }}">
                                                    {{ $data['category_name'] }}</option>
                                            @else
                                                <option value="{{ $data['cat_id'] }}">{{ $data['category_name'] }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Enter Product Title</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Product title" name="title" value="{{ $product['title'] }}"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Select product Thumbnail</label>
                                <div class="col-sm-9">
                                    <input type="file" class="dropify" accept="image/*" capture name="thumbnail" data-default-file="{{ url('/') }}/uploads/product_thumbnail/{{ $product['thumbnail'] }}">
                                    <input type="hidden" value="{{ $product['thumbnail'] }}" name="old_thumbnail">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Update Gallery Images</label>
                                <div class="col-sm-9">
                                    <a href="{{ url('/') }}/auction/product/update/gallery/{{ $id }}/{{ $product['title'] }}" class="btn btn-outline-primary">Edit Images</a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Enter Product Website</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('website') is-invalid @enderror"
                                        placeholder="https://www.example.com/product" name="website"
                                        value="{{ $product['website'] }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Condition Rating</label>
                                <div class="col-sm-9">
                                    <select id="example-fontawesome" name="rating" autocomplete="off">
                                        @for ($i = 1; $i <= 6; $i++)
                                            @if ($i == $product['condition_rating'])
                                                <option selected value="{{ $i }}">{{ $i }}
                                                </option>
                                            @else
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endif
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Condition Description</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="conditionDesc" name="condition_desc">{{ $product['condition_desc'] }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Condition Note</label>
                                <div class="col-sm-9">
                                    <input type="text"
                                        class="form-control @error('condition_note') is-invalid @enderror"
                                        placeholder="Some Important Note about Products" name="condition_note" value="{{ $product['condition_note'] }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Minimum Bid Value</label>
                                <div class="col-sm-9">
                                    <input type="number" name="min_bid"
                                        class="form-control @error('min_bid') is-invalid @enderror" placeholder="1"
                                        value="{{ $product['minimum_bid'] }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">purchase Price</label>
                                <div class="col-sm-9">
                                    <input type="number" name="purchase_price"
                                        class="form-control @error('purchase_price') is-invalid @enderror" placeholder="1"
                                        value="{{ $product['purchase_price'] }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Retail Value</label>
                                <div class="col-sm-9">
                                    <input type="number" name="retail_value"
                                        class="form-control @error('retail_value') is-invalid @enderror"
                                        placeholder="999" value="{{ $product['retail_value'] }}" required>
                                </div>
                            </div>

                            <div class="float-end">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
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
    <script src="{{ url('/') }}/vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
    <script src="{{ url('/') }}/vendors/jquery-tags-input/jquery.tagsinput.min.js"></script>
    <script src="{{ url('/') }}/vendors/jquery.repeater/jquery.repeater.min.js"></script>
    <script src="{{ url('/') }}/js/form-addons.js"></script>
    <script src="{{ url('/') }}/js/formpickers.js"></script>
    <script src="{{ url('/') }}/js/form-repeater.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#conditionDesc')).then(editor => {
            console.log(editor);
        }).catch(error => {
            console.error(error);
        });
    </script>
</body>

</html>
