<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\WhyChooseUsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WhyChooseUsCreateRequest;
use App\Models\SectionTitles;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;

class WhyChooseUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WhyChooseUsDataTable $dataTable)
    {
        $keys = ['why_choose_top_title', 'why_choose_main_title', 'why_choose_sub_title'];

        $titles = SectionTitles::whereIn('key', $keys)->get()->pluck('value', 'key');

        return $dataTable->render('admin.why-choose-us.index', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.why-choose-us.create_why_choose');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WhyChooseUsCreateRequest $request)
    {
       $why_choose = new WhyChooseUs();

       $why_choose->icon = $request->icon;
       $why_choose->title = $request->title;
       $why_choose->short_message = $request->short_message;
       $why_choose->status = $request->status;

       $why_choose->save();

       /**
        * Another easy way to validate our form is this;
        WhyChooseUs::create($request->validated()); but make sure to allow for mass assignment
        in the model file.
        */

       toastr()->success('Why Choose US Section added successfully', 'Added');
       return to_route('admin.why-choose-us.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $why_choose = WhyChooseUs::findOrFail($id);
        return view('admin.why-choose-us.edit_why_choose', compact('why_choose'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WhyChooseUsCreateRequest $request, string $id)
    {
        $why_choose = WhyChooseUs::findOrFail($id);

       $why_choose->icon = $request->icon;
       $why_choose->title = $request->title;
       $why_choose->short_message = $request->short_message;
       $why_choose->status = $request->status;

       $why_choose->update();

       toastr()->success('Why Choose US Section updated successfully', 'Updated');
       return to_route('admin.why-choose-us.index');
    }
    /**
     * Handles title updating
     */
    public function updateTitle(Request $request){
        $request->validate([
            'why_choose_top_title' => ['max:100'],
            'why_choose_main_title' => ['max:200'],
            'why_choose_sub_title' => ['max:500']
        ]);

        SectionTitles::updateOrCreate(
            ['key' => 'why_choose_top_title'],
            ['value' => $request->why_choose_top_title]
        );

        SectionTitles::updateOrCreate(
            ['key' => 'why_choose_main_title'],
            ['value' => $request->why_choose_main_title]
        );

        SectionTitles::updateOrCreate(
            ['key' => 'why_choose_main_title'],
            ['value' => $request->why_choose_main_title]
        );

        toastr()->success('Updated successfully!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        $why_choose = WhyChooseUs::findOrFail($id);

        $why_choose->delete($id);
        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'Something went wrong in the frontend']);
        }
    }
}
