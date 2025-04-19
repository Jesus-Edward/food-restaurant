<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Http\Request;

class ProductOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'names' => ['required', 'max:255'],
            'prices' => ['required', 'numeric'],
            'product_id' => ['required', 'integer']
        ], [
            'names.required' => 'Product option name is required!',
            'names.max' => 'Product option max length exceeded!',
            'prices.required' => 'Product option price is required!',
            'prices.numeric' => 'Product option price tag is numeric!'
        ]);

        $productOptions = new ProductOption();
        $productOptions->product_id = $request->product_id;
        $productOptions->names = $request->names;
        $productOptions->prices = $request->prices;

        $productOptions->save();

        toastr()->success('Product options added successfully!' , 'Added');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        $deleteOptions = ProductOption::findOrFail($id);
        $deleteOptions->delete();
            return response(['status' =>'success', 'message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response(['status' =>'error', 'message' => 'Something went wrong in the frontend']);
        }
    }
}
