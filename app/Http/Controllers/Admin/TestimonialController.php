<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TestimonialDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialCreateRequest;
use App\Http\Requests\Admin\TestimonialUpdateRequest;
use App\Models\SectionTitles;
use App\Models\Testimonial;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(TestimonialDataTable $dataTable)
    {
        $keys = ['testimonial_top_title', 'testimonial_main_title', 'testimonial_sub_title'];

        $titles = SectionTitles::whereIn('key', $keys)->get()->pluck('value', 'key');

        return $dataTable->render('admin.testimonial.index', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image');
        $testimonial = new Testimonial();
        $testimonial->image = $imagePath;
        $testimonial->name = $request->name;
        $testimonial->location = $request->location;
        $testimonial->review = $request->review;
        $testimonial->rating = $request->rating;
        $testimonial->show_at_home = $request->show_at_home;
        $testimonial->status = $request->status;
        $testimonial->save();

        toastr()->success('Testimonial Created Successfully');
        return to_route('admin.testimonial.index');
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
        $testimonials = Testimonial::findOrFail($id);
        return view('admin.testimonial.edit', compact('testimonials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TestimonialUpdateRequest $request, string $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $imagePath = $this->uploadImage($request, 'image', $testimonial->image);
       
        $testimonial->image = !empty($imagePath) ? $imagePath : $testimonial->image;
        $testimonial->name = $request->name;
        $testimonial->location = $request->location;
        $testimonial->review = $request->review;
        $testimonial->rating = $request->rating;
        $testimonial->show_at_home = $request->show_at_home;
        $testimonial->status = $request->status;
        $testimonial->update();

        toastr()->success('Testimonial Updated Successfully');
        return to_route('admin.testimonial.index');
    }

    public function updateTitle(Request $request){
        $validatedData = $request->validate([
            'testimonial_top_title' => ['max:100'],
            'testimonial_main_title' => ['max:200'],
            'testimonial_sub_title' => ['max:500']
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
            $testimonial = Testimonial::findOrFail($id);
            $this->removeImage($testimonial->image);
            $testimonial->delete();

            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }
        catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong in the frontend']);
        }
    }
}
