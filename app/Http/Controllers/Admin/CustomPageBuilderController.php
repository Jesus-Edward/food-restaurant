<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CustomPageBuilderDataTable;
use App\Http\Controllers\Controller;
use App\Models\CustomPageBuilder;
use Illuminate\Http\Request;

class CustomPageBuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CustomPageBuilderDataTable $dataTable)
    {
        return $dataTable->render('admin.custom-page-builder.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.custom-page-builder.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:custom_page_builders,name'],
            'content' => ['required'],
            'status' => ['required', 'boolean']
        ]);

        $customPage = new CustomPageBuilder();
        $customPage->name = $request->name;
        $customPage->slug = generateUniqueSlug('CustomPageBuilder', $request->name);
        $customPage->content = $request->content;
        $customPage->status = $request->status;

        $customPage->save();

        toastr()->success('Custom Page Created');
        return redirect()->route('admin.custom-page-builder.index');
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
        $customPage = CustomPageBuilder::findOrFail($id);
        return view('admin.custom-page-builder.edit', compact('customPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:custom_page_builders,name,'.$id],
            'content' => ['required'],
            'status' => ['required', 'boolean']
        ]);

        $customPage = CustomPageBuilder::findOrFail($id);
        $customPage->name = $request->name;
        $customPage->content = $request->content;
        $customPage->status = $request->status;

        $customPage->update();

        toastr()->success('Custom Page Updated');
        return redirect()->route('admin.custom-page-builder.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $customPage = CustomPageBuilder::findOrFail($id);
            $customPage->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong in the frontend']);
        }
    }
}
