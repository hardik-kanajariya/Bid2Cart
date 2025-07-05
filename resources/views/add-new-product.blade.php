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
    </style>
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
                    {{-- <div class="alert alert-danger">{{ $message }}</div> --}}
                    {{-- validation Errors --}}
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
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
                            <h4 class="card-title">Add New Product</h4>
                            <form class="forms-sample" method="POST" enctype="multipart/form-data"
                                action="{{ route('add-new-product') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Select Product
                                        Category</label>
                                    <div class="col-sm-9">
                                        <select name="category_id" id="id"
                                            class="form-control @error('category_id') is-invalid @enderror" required>
                                            <option value="">Select Category</option>
                                            @foreach ($category as $data)
                                                <option value="{{ $data['cat_id'] }}">{{ $data['category_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Select Brand name</label>
                                    <div class="col-sm-9">
                                        <select name="brand_name" id="id"
                                            class="form-control @error('brand_name') is-invalid @enderror">
                                            @foreach ($brands as $data)
                                                <option value="{{ $data['brand_name'] }}">{{ $data['brand_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Enter Product Title</label>
                                    <div class="col-sm-9">
                                        <script>
                                            function validateCharacter() {
                                                document.addEventListener('keydown', (event)=> {
                                                    if (event.key == '/') {
                                                        document.getElementById('character_validation').innerHTML = '" / " is not allowed use <b></b>" | " </b> instead of " / "';
                                                    }else{
                                                        document.getElementById('character_validation').innerHTML = '';
                                                    }
                                                });
                                            }
                                        </script>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            placeholder="Product title" name="title" value="{{ old('title') }}"
                                            required onkeyup="validateCharacter()">

                                        <div class="text-danger" id="character_validation"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Select product
                                        Thumbnail</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="dropify" accept="image/*" capture name="thumbnail"
                                            required>
                                        {{-- <input type="file" class="dropify" multiple  accept="image/*" capture name="image[]" required> --}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Select product Gallary
                                        Images</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" multiple accept="image/*" capture
                                            name="image[]" max="5">
                                        {{-- <input type="file" class="dropify" multiple  accept="image/*" capture name="image[]" required> --}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Enter Product Website</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            class="form-control @error('website') is-invalid @enderror"
                                            placeholder="https://www.example.com/product" name="website"
                                            value="{{ old('website') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Condition Rating</label>
                                    <div class="col-sm-9">
                                        <select id="example-fontawesome" name="rating" autocomplete="off" required>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3" selected>3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Condition Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="conditionDesc" name="condition_desc"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Condition Note</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            class="form-control @error('condition_note') is-invalid @enderror"
                                            placeholder="Some Important Note about Products" name="condition_note"
                                            value="None">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Minimum Bid Value</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="min_bid"
                                            class="form-control @error('min_bid') is-invalid @enderror"
                                            placeholder="1" value="{{ old('min_bid') }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Enter Product Purchase
                                        Price</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="purchase_price"
                                            class="form-control @error('purchase_price') is-invalid @enderror"
                                            placeholder="1" value="{{ old('purchase_price') }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Retail Value</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="retail_value"
                                            class="form-control @error('retail_value') is-invalid @enderror"
                                            placeholder="999" value="{{ old('retail_value') }}" required>
                                    </div>
                                </div>

                                <div class="float-end">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </div>
                            </form>
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
