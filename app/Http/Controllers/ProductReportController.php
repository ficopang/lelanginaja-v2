<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReportController extends Controller
{
    public function index()
    {
        $product = Product::all();

        return view('product.report', compact('product'));
    }

    public function show(Product $product)
    {
        return view('product.report', compact('product', 'product'));
    }

    public function store(Request $request, Product $product)
    {
        $this->validate($request, [
            'report_text' => 'required|min:5|max:100'
        ]);

        $report = new ProductReport();
        $report->user_id = auth()->user()->id;
        $report->product_id = $product->id;
        $report->reason = $request->report_text;
        $report->save();
        return redirect('/');
    }
}
