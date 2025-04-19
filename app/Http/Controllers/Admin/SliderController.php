<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderCreateRequest;
use App\Http\Requests\Admin\SliderUpdateRequest;
use App\Models\Slider;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.slider.create-slider');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image');

        $slider = new Slider();
        $slider->offer = $request->offer;
        $slider->image = $imagePath;
        $slider->title = $request->title;
        $slider->sub_title = $request->sub_title;
        $slider->short_description = $request->short_description;
        $slider->button_link = $request->button_link;
        $slider->status = $request->status;

        $slider->save();
        toastr()->success('Slider Created Successfully', 'Created');
        return to_route('admin.slider.index');
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
        $sliders = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('sliders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderUpdateRequest $request, string $id): RedirectResponse
    {
        $sliders = Slider::findOrFail($id);

        /**Handle Image Upload */
        $imagePath = $this->uploadImage($request, 'image', $sliders->image);

        $sliders->offer = $request->offer;
        $sliders->image = !empty($imagePath) ? $imagePath : $sliders->image;
        $sliders->title = $request->title;
        $sliders->sub_title = $request->sub_title;
        $sliders->short_description = $request->short_description;
        $sliders->button_link = $request->button_link;
        $sliders->status = $request->status;

        $sliders->save();

        toastr()->success('Slider Updated Successfully', 'Updated');
        return to_route('admin.slider.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sliders = Slider::findOrFail($id);
            $this->removeImage($sliders->image);
            $sliders->delete($id);

            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }
        catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong in the frontend']);
        }
    }
}
