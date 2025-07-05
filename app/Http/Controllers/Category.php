<?php

namespace App\Http\Controllers;

use App\Models\Category as ModelsCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use ImageOptimizer;

class Category extends Controller
{
    // View Functions 
    public function viewCategory()
    {
        $category = ModelsCategory::all();

        // Counting Total Products from category 
        $pCount = array();
        foreach ($category as $key) {
            $pdata = Product::where('category_id', $key['cat_id'])->count();
            array_push($pCount, $pdata); 
        }
        // return $pCount;
        $data = compact('category', 'pCount');
        return view('manage-category')->with($data);
    }

    // Action Functions 
    public function addNewCategory(Request $request)
    {
        $request->validate([
            "category_name" => "required|string|max:255",
            "thumbnail" => "required|image"
        ]);

        // uploading Image
        $fileName = "";
        if ($file = $request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = 'category_thumbnail_' . time() . '_' . $request->file('thumbnail')->getClientOriginalName();
            $destinationPath = public_path() . '/uploads/category_thumbnail';
            $pathToImage = $destinationPath . '/' . $fileName;
            // ImageOptimizer::optimize($pathToImage);
            $file->move($destinationPath, $fileName);
        }

        // Storing Data into database 
        $cat = new ModelsCategory();
        $cat->category_name = $request['category_name'];
        $cat->category_thumbnail = $fileName;
        $cat->save();
        return back()->with('msg', 'New Category inserted');
    }

    // Updating Category 
    public function updateCategory(Request $request){
        print_r($request->all());
        // return 0;
        $request->validate([
            "category_id" => "required",
            "category_name" => "required|string|max:255",
            "old_thumbnail" => "required_with:thumbnail"
        ]);

        // uploading Image
        $fileName = $request['old_thumbnail'];
        if ($file = $request->hasFile('thumbnail')) {
            File::delete(public_path('/uploads/category_thumbnail/' . $request['old_thumbnail']));
            $file = $request->file('thumbnail');
            $fileName = 'category_thumbnail_' . time() . '_' . $request->file('thumbnail')->getClientOriginalName();
            $destinationPath = public_path() . '/uploads/category_thumbnail';
            $file->move($destinationPath, $fileName);
        }

        // Storing Data into database 
        $id = $request['category_id'];
        $cat = ModelsCategory::find($id);
        $cat->category_name = $request['category_name'];
        $cat->category_thumbnail = $fileName;
        $cat->save();
        return back()->with('msg', 'Category Updated');
    }

    // Deleting Category
    public function deleteCategory($id, $img){
        $cat = ModelsCategory::find($id);
        // echo var_dump($cat);
        if($cat == NULL){
            return back()->with('msg', 'category Not Found or it was already Deleted try to refresh web page');
        }else{
            File::delete(public_path('/uploads/category_thumbnail/' . $img));
            $cat->delete();
            return back()->with('msg', 'Category Deleted');
        }
    }
}
