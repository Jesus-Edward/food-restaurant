<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCreateRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\SectionTitles;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Str;

class ProductController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        $keys = ['menu_item_top_title', 'menu_item_main_title', 'menu_item_sub_title'];

        $titles = SectionTitles::whereIn('key', $keys)->get()->pluck('value', 'key');
        return $dataTable->render('admin.product.index', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('admin.product.create-product', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request): RedirectResponse
    {
        $imagePath = $this->uploadImage($request, 'image');
        $product = new Product();

        $product->thumb_image = $imagePath;
        $product->name = $request->name;
        $product->slug = generateUniqueSlug('Product', $request->name);
        $product->category_id = $request->category;
        $product->quantity = $request->quantity;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price ?? 0;
        $product->sku = $request->sku;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->show_at_home = $request->show_at_home;
        $product->status = $request->status;

        $product->save();

        toastr()->success('Product Created Successfully', 'Created');
        return to_route('admin.product.index');
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
    public function edit(string $id): View
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product.edit-product', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $product = Product::findOrFail($id);

        $imagePath = $this->uploadImage($request, 'image', $product->thumb_image);

        $product->thumb_image = !empty($imagePath) ? $imagePath : $product->thumb_image;
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->quantity = $request->quantity;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price ?? 0;
        $product->sku = $request->sku;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->show_at_home = $request->show_at_home;
        $product->status = $request->status;

        $product->update();

        toastr()->success('Product Updated Successfully', 'Updated');
        return to_route('admin.product.index');
    }

    /**
     * Handles title updating
     */
    public function updateTitle(Request $request)
    {
        $validatedData = $request->validate([
            'menu_item_top_title' => ['max:100'],
            'menu_item_main_title' => ['max:200'],
            'menu_item_sub_title' => ['max:500']
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
        try {
            $product = Product::findOrFail($id);
            $this->removeImage($product->thumb_image);
            $product->delete($id);

            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong in the frontend']);
        }
    }
}
