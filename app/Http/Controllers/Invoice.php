<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\BrandInvoice;
use App\Models\Invoice as ModelsInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class Invoice extends Controller
{
    // View Functions
    public function viewInvoices()
    {
        $invoice = ModelsInvoice::all();
        $data = compact('invoice');
        return view('view-invoice')->with($data);
    }

    public function viewBrandInvoice()
    {
        $invoice = BrandInvoice::all();
        $data = compact('invoice');
        return view('view-brand-invoice')->with($data);
    }

    // Action Functions
    public function deleteInvoices($id)
    {
        $in = ModelsInvoice::find($id);
        File::delete(public_path('/invoice' . '/' . $in->pdf));
        $in->delete();
        return back()->with('msg', 'Invoice deleted');
    }

    public function deleteBrandInvoice($id)
    {
        $in = BrandInvoice::find($id);
        File::delete(public_path('/invoice/brand/' . $in->pdf));
        $in->delete();
        return back()->with('msg', 'Invoice deleted');
    }
}
