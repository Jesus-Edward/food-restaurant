<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DailyOfferDataTable;
use App\Http\Controllers\Controller;
use App\Models\DailyOffer;
use App\Models\Product;
use App\Models\SectionTitles;
use Illuminate\Http\Request;

class DailyOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DailyOfferDataTable $dataTable)
    {
        $keys = ['daily_offer_top_title', 'daily_offer_main_title', 'daily_offer_sub_title'];

        $titles = SectionTitles::whereIn('key', $keys)->get()->pluck('value', 'key');

        return $dataTable->render('admin.daily-offer.index', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.daily-offer.create');
    }

    
    function productSearch(Request $request)
    {
        $product = Product::select('id', 'name', 'thumb_image')->where('name', 'LIKE', '%'.$request->search.'%')->get();
        return response($product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product' => ['required', 'integer'],
            'status' => ['required', 'boolean']
        ]);

        $daily_offer = new DailyOffer();
        $daily_offer->product_id = $request->product;
        $daily_offer->status = $request->status;
        $daily_offer->save();

        toastr()->success('Daily Offer Created Successfully');
        return to_route('admin.daily-offer.index');
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
        $daily_offer = DailyOffer::with('product')->findOrFail($id);
        return view('admin.daily-offer.edit', compact('daily_offer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product' => ['required', 'integer'],
            'status' => ['required', 'boolean']
        ]);

        $daily_offer = DailyOffer::findOrFail($id);
        $daily_offer->product_id = $request->product;
        $daily_offer->status = $request->status;
        $daily_offer->update();

        toastr()->success('Daily Offer Updated Successfully');
        return to_route('admin.daily-offer.index');
    }

    /**
     * Handles title updating
     */
    public function updateTitle(Request $request){
       $validatedData = $request->validate([
           'daily_offer_top_title' => ['max:100'],
           'daily_offer_main_title' => ['max:200'],
           'daily_offer_sub_title' => ['max:500']
       ]);

        foreach ($validatedData as $key => $value) {
            SectionTitles::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

       toastr()->success('Updated successfully!');

       return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $daily_offer = DailyOffer::findOrFail($id);
            $daily_offer->delete();

            return response(['status' =>'success', 'message' => 'Deleted Successfully']);
        }catch(\Exception $e){
            logger($e);
            return response(['status' =>'error', 'message' => 'Something went from the frontend']);
        }
    }
}
