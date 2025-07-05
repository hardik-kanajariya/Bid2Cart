<?php

namespace App\Http\Controllers;

use App\Models\Brand as ModelsBrand;
use Illuminate\Http\Request;

class Brand extends Controller
{
    // View Functions
    public function viewBrands()
    {
        $brands = ModelsBrand::all();
        $data = compact('brands');
        return view('manage-brands')->with($data);
    }

    // Action Functions
    public function insertBrand(Request $request)
    {
        $request->validate([
            'brand_name' => 'required',
        ]);

        // Validate Brand Name
        $check = ModelsBrand::where('brand_name', $request['brand_name'])->count();
        if($check == 1){
            return back()->with('msg', 'Brand name already exist, kindly try to update or try to enter different Brand');
        }

        $new = new ModelsBrand();
        $new->brand_name = $request['brand_name'];
        $new->brand_desc = $request['brand_desc'];
        $new->save();

        return back()->with('msg', 'New Brand Inserted');
    }

    public function updateBrand(Request $request)
    {
        $request->validate([
            'brand_name' => 'required',
            'Brand_id' => 'required',
        ]);
        $new = ModelsBrand::find($request['Brand_id']);
        $new->brand_name = $request['brand_name'];
        $new->brand_desc = $request['brand_desc'];
        $new->save();

        return back()->with('msg', 'Brand Updated');
    }

    public function deleteBrand($id)
    {
        $new = ModelsBrand::find($id);
        $new->delete();
        return back()->with('msg', 'Brand Deleted');
    }
}
