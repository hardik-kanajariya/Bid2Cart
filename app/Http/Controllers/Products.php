<?php

namespace App\Http\Controllers;

use App\Models\AskedQuestion;
use App\Models\Auction;
use App\Models\AuctionHistory;
use App\Models\BidHistory;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MaxBid;
use App\Models\Notification;
use App\Models\Pickup;
use App\Models\Product;
use App\Models\Result;
use App\Models\Support;
use App\Models\User;
use App\Models\WatchList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Products extends Controller
{
    // View Functions
    public function viewProducts(Request $request)
    {
        if (isset($request['search'])) {
            $products = Product::where('title', 'Like', '%' . request('search') . '%')->orderBy('prd_id', 'DESC')->paginate(10);
            $data = compact('products');
            return view('view-auction-product')->with($data);
        } else {
            $products = Product::paginate(4);
            $data = compact('products');
            return view('view-auction-product')->with($data);
        }
    }

    public function viewAddProduct()
    {
        $category = Category::all();
        $brands = Brand::all();
        $data = compact('category', 'brands');
        return view('add-new-product')->with($data);
    }

    public function viewUpdateProduct(Request $request, $id, $title)
    {
        $product = Product::find($id);
        $category = Category::all();
        $data = compact('product', 'id', 'category');
        return view('view-update-product')->with($data);
    }

    public function viewUpdateGallery($id, $title)
    {
        $product = Product::find($id);
        $data = compact('product', 'id', 'title');
        return view('update-gallary-view')->with($data);
    }

    // Auto Bid
    public function autoBid($sku, $minBid)
    {
        // Inserting First record for given product
        $user = User::find(rand(0, 49));

        // Getting Currently listed product details
        $pData = Product::orderBy('prd_id', 'desc')->first();

        $bid = new BidHistory();
        $bid->user_id = $user->userid;
        $bid->product_id = $pData->prd_id;
        $bid->bidder = $user->username;
        $bid->amount = $pData->current_bid;
        $bid->status = 'winning';
        $bid->save();

        // Setting Max bid amount for user
        $max = new MaxBid();
        $max->user_id = $user->userid;
        $max->product_id = $pData->prd_id;
        $max->max_bid = $minBid;
        $max->save();
    }

    // Action Functions
    public function addProduct(Request $request)
    {
        $request->validate([
            'category_id' => 'required|numeric',
            'title' => 'required|max:254',
            'thumbnail' => 'required|image|mimes:png,jpg,jpeg,gif,svg,webp',
            'image' => 'array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'website' => 'url|max:254|nullable',
            'rating' => 'required|numeric',
            'condition_desc' => 'nullable|max:254',
            'condition_note' => 'nullable|max:254',
            'min_bid' => 'nullable|numeric|min:1',
            'purchase_price' => 'required|numeric|min:1',
            'retail_value' => 'required|numeric|min:1'
        ]);

        // Get Auction Details From Auction Table
        $checkCount = Auction::where('status', 'active')->count();
        // echo "Check Count = " . $checkCount;
        if (!$checkCount == 1) {
            return back()->with('errmsg', 'No Auction is Running Please Start Auction to Insert new products');
        }

        // storing Thumbnail Image
        $thumbnail = "";
        if ($file = $request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $thumbnail = 'product_thumbnail_' . time() . '_' . $request->file('thumbnail')->getClientOriginalName();
            $destinationPath = public_path() . '/uploads/product_thumbnail';
            $file->move($destinationPath, $thumbnail);
        }

        // if there is no images set in gallery than by default thumbnail will be added as a gallary image
        $images = array();
        if ($request['image']) {
            // Storing images in JSON
            // Restricting from uploading more then 5 Images
            if (count($request['image']) > 5) {
                return back()->with('errmsg', 'You can not upload more then 5 Images');
            } else {
                for ($i = 0; $i < count($request['image']); $i++) {
                    $imageKey = 'image.' . $i;
                    $file = $request->file($imageKey);
                    $fileName = 'product_image_' . time() . '_' . $request->file($imageKey)->getClientOriginalName();
                    $destinationPath = public_path() . '/uploads/product_image';
                    $file->move($destinationPath, $fileName);
                    array_push($images, $fileName);
                }
            }
        } else {
            // $thumbnail = str_replace('product_thumbnail_', 'product_image_', $thumbnail);
            $source = public_path() . '/uploads/product_thumbnail/' . $thumbnail;
            $destination = public_path() . '/uploads/product_image';
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0777, true, true);
            }
            File::copy($source, public_path('/uploads/product_image/') . $thumbnail);
            array_push($images, $thumbnail);
        }
        // If Auction is Running get that auction id
        $aid = Auction::where('status', 'active')->get();
        // Getting Auction id from running Auction
        // Note: there are always one Auction Running
        $endDate = $aid[0]['end_date'];
        $endTime = $aid[0]['end_time'];

        $startDate = $aid[0]['start_date'];
        $startTime = $aid[0]['start_time'];

        // Getting End Time
        $end = $endDate . ' ' . $endTime . ':00';
        $start = $startDate . ' ' . $startTime . ':00';
        $auctionId = $aid[0]['aid'];

        // Getting Unique SKU id for New Product
        $sku = 'SKU-' . time();

        // Inserting Data into Database
        $title = str_replace('/', '-', $request['title']);
        $p = new Product();
        $p->auction_id = $auctionId;
        $p->category_id = $request['category_id'];
        $p->brand_name = $request['brand_name'];
        $p->title = $title;
        $p->thumbnail = $thumbnail;
        $p->images = json_encode($images);
        $p->website = $request['website'] ? $request['website'] : url('/');
        $p->condition_rating = $request['rating'];
        $p->condition_desc = $request['condition_desc'];
        $p->condition_note = $request['condition_note'];
        $p->sku = $sku;
        $p->minimum_bid = $request['min_bid'];
        $p->purchase_price = $request['purchase_price'];
        $p->retail_value = $request['retail_value'];
        $p->end_time = $end;
        $p->start_time = $start;
        $p->save();

        // Adding Minimum Bid Value
        Products::autoBid($sku, $request['min_bid']);

        return back()->with('msg', 'New Product Inserted');
    }


    public function updateProduct(Request $request)
    {
        $request->validate([
            'update_id' => 'required',
            'category_id' => 'required|numeric',
            'title' => 'required',
            'thumbnail' => 'image|mimes:png,jpg,jpeg,gif,svg,webp|max:1024',
            'old_thumbnail' => 'required',
            'website' => 'url',
            'rating' => 'required|numeric',
            'condition_desc' => 'nullable',
            'condition_note' => 'nullable',
            'min_bid' => 'required|numeric|min:1',
            'purchase_price' => 'required|numeric|min:1',
            'retail_value' => 'required|numeric|min:1',
        ]);

        // storing New Thumbnail Image if it updates
        $thumbnail = $request['old_thumbnail'];
        if ($file = $request->hasFile('thumbnail')) {
            File::delete(public_path('/uploads/product_thumbnail/' . $request['old_thumbnail']));
            $file = $request->file('thumbnail');
            $thumbnail = 'product_thumbnail_' . time() . '_' . $request->file('thumbnail')->getClientOriginalName();
            $destinationPath = public_path() . '/uploads/product_thumbnail';
            $file->move($destinationPath, $thumbnail);
        }

        // updating record
        $p = Product::find($request['update_id']);
        $p->category_id = $request['category_id'];
        $p->title = $request['title'];
        $p->thumbnail = $thumbnail;
        $p->website = $request['website'];
        $p->condition_rating = $request['rating'];
        $p->condition_desc = $request['condition_desc'];
        $p->condition_note = $request['condition_note'];
        $p->minimum_bid = $request['min_bid'];
        $p->purchase_price = $request['purchase_price'];
        $p->retail_value = $request['retail_value'];
        $p->save();
        return back()->with('msg', 'Product Updated successfully');
    }

    // currently working but if user tries to perform insert and delete both operation at same time it will delete images but new image will replaced by array index starting from 0
    public function updateGallery(Request $request)
    {
        $request->validate([
            'pid' => 'required|numeric',
            'title' => 'required|max:254',
            'image' => 'array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $id = $request['pid'];
        $title = $request['title'];

        // Storing images in JSON
        $images = array();

        // Restricting from uploading more then 5 Images
        $oldImageCount = $newImageCount = $same =  0;
        $space = 5; // upload limit

        // Counting Old Images
        for ($i = 0; $i < $space; $i++) {
            $oldImageKey = 'i' . $i;
            if (isset($request[$oldImageKey])) {
                $oldImageCount += 1;
            }
        }

        // checking left slot with new uploaded image
        if (isset($request['image'])) {
            $newImageCount = count($request['image']);
            $left = $space - $oldImageCount;
            if ($newImageCount > $left) {
                return back()->with('errmsg', 'Upload Limit reached');
            }
        }

        // checking if there are any slot left to insert new image or not
        if ($oldImageCount > $space || $newImageCount > $space) {
            return back()->with('errmsg', 'You can only upload 5 images, Max Image upload limit reached');
        }

        $product = Product::find($id);

        // Deleting Images
        for ($i = 0; $i < $space; $i++) {
            $deleteKey = 'delete.' . $i;
            if (isset($request[$deleteKey])) {
                File::delete(public_path('/uploads/product_image/' . $request[$deleteKey]));
                // echo "<br> $request[$deleteKey] is deleted";
            }
        }

        // Uploading New images
        for ($k = 0; $k < $space; $k++) {
            $imageKey = 'image.' . $k;
            $oldImageKey = 'i' . $k;
            if (isset($request[$imageKey])) {
                $file = $request->file($imageKey);
                $fileName = 'product_image_' . time() . '_' . $request->file($imageKey)->getClientOriginalName();
                $destinationPath = public_path() . '/uploads/product_image';
                $file->move($destinationPath, $fileName);
            } else {
                $fileName = $request[$oldImageKey];
            }
            array_push($images, $fileName);
        }

        // Removing NULL Arrays
        $images = array_filter($images);
        // Reindexed Arrays
        $images = array_values($images);

        // Debugging
        echo "<pre>";
        print_r($request->all());
        echo "<hr>";
        print_r($images);

        // Updating Images
        $product->images = $images;
        $product->save();

        // Redirecting back to update product page
        $url = "/auction/product/update/$id/$title";
        return redirect($url)->with('msg', 'Gallery Updated');
    }

    // Delete Products
    public function deleteProduct(Request $request, $id)
    {
        // Deleting All Product related Data
        // asked question
        AskedQuestion::where('product_id', $id)->delete();
        // bid history
        BidHistory::where('product_id', $id)->delete();
        // max_bid
        MaxBid::where('product_id', $id)->delete();
        // pickup
        Pickup::where('product_id', $id)->delete();
        // result
        Result::where('product_id', $id)->delete();
        // watchlist
        WatchList::where('product_id', $id)->delete();
        // support
        Support::where('product_id', $id)->delete();

        // Getting Product data by id
        $pData = Product::find($id);
        if ($pData) {
            // Deleting Product thumbnails
            File::delete(public_path('/uploads/product_thumbnail/' . $pData['thumbnail']));

            // Deleting product Gallary Images
            $gallary = json_decode($pData['images'], true);
            foreach ($gallary as $key) {
                File::delete(public_path('/uploads/product_image/' . $key));
            }

            $pData->delete();
            return back()->with('msg', 'Product Deleted');
        } else {
            return back()->with('msg', 'Product not Found');
        }
    }

    // Function to repost product
    public function repostProduct($id)
    {
        $product = Product::find($id);

        $aid = Auction::where('status', 'active')->get();
        // Getting Auction id from running Auction
        // Note: there are always one Auction Running
        $endDate = $aid[0]['end_date'];
        $endTime = $aid[0]['end_time'];

        $startDate = $aid[0]['start_date'];
        $startTime = $aid[0]['start_time'];

        // Getting End Time
        $end = $endDate . ' ' . $endTime . ':00';
        $start = $startDate . ' ' . $startTime . ':00';
        $auctionId = $aid[0]['aid'];

        // Getting Unique SKU id for New Product
        $sku = 'SKU-' . time();

        // add new product with same data
        $p = new Product;
        $p->auction_id = $auctionId;
        $p->category_id = $product['category_id'];
        $p->title = $product['title'];
        $p->thumbnail = $product['thumbnail'];
        $p->images = $product['images'];
        $p->website = $product['website'];
        $p->condition_rating = $product['condition_rating'];
        $p->condition_desc = $product['condition_desc'];
        $p->condition_note = $product['condition_note'];
        $p->sku = $sku;
        $p->minimum_bid = $product['minimum_bid'];
        $p->purchase_price = $product['purchase_price'];
        $p->retail_value = $product['retail_value'];
        $p->end_time = $end;
        $p->start_time = $start;
        $p->save();

        Products::autoBid($sku, $product['minimum_bid']);

        // delete old product
        $product->delete();

        return back()->with('msg', 'Product Reposted');

    }
}
