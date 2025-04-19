<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ChefTeamDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChefTeamCreateRequest;
use App\Http\Requests\Admin\ChefTeamUpdateRequest;
use App\Models\ChefTeam;
use App\Models\SectionTitles;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class ChefTeamController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ChefTeamDataTable $dataTable)
    {
        $keys = ['chef_team_top_title', 'chef_team_main_title', 'chef_team_sub_title'];

        $titles = SectionTitles::whereIn('key', $keys)->get()->pluck('value', 'key');
        
        return $dataTable->render('admin.chef-team.index', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.chef-team.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChefTeamCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image');
        $chefTeam = new ChefTeam();
        $chefTeam->image = $imagePath;
        $chefTeam->name = $request->name;
        $chefTeam->title = $request->title;
        $chefTeam->fb = $request->fb;
        $chefTeam->in = $request->in;
        $chefTeam->x_link = $request->x_link;
        $chefTeam->web = $request->web_url;
        $chefTeam->show_at_home = $request->show_at_home;
        $chefTeam->status = $request->status;
        $chefTeam->save();

        toastr()->success('Created Successfully');
        return to_route('admin.chef-team.index');
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
        $chefTeam = ChefTeam::findOrFail($id);
        return view('admin.chef-team.edit', compact('chefTeam'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChefTeamUpdateRequest $request, string $id)
    {
        $chefTeam = ChefTeam::findOrFail($id);
        $imagePath = $this->uploadImage($request, 'image', $chefTeam->image);
        
        $chefTeam->image = !empty($imagePath) ? $imagePath : $chefTeam->image;
        $chefTeam->name = $request->name;
        $chefTeam->title = $request->title;
        $chefTeam->fb = $request->fb;
        $chefTeam->in = $request->in;
        $chefTeam->x_link = $request->x_link;
        $chefTeam->web = $request->web_url;
        $chefTeam->show_at_home = $request->show_at_home;
        $chefTeam->status = $request->status;
        $chefTeam->update();

        toastr()->success('Updated Successfully');
        return to_route('admin.chef-team.index');
    }

    public function updateTitle(Request $request){
        $validatedData = $request->validate([
            'chef_team_top_title' => ['max:100'],
            'chef_team_main_title' => ['max:200'],
            'chef_team_sub_title' => ['max:500']
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
            $chefTeam = ChefTeam::findOrFail($id);
            $this->removeImage($chefTeam->image);
            $chefTeam->delete();

            return response(['status' => 'success', 'message' => 'Deleted Successfully']);

        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong from thr frontend']);
        }
    }
}
