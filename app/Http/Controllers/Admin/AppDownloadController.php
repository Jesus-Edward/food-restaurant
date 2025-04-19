<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppDownloadCreateRequest;
use App\Models\AppDownload;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class AppDownloadController extends Controller
{
    use FileUploadTrait;
    function index() {
        $apps = AppDownload::first();
        return view('admin.app-download.index', compact('apps'));
    }

    function store(AppDownloadCreateRequest $request) {

        $imagePath = $this->uploadImage($request, 'image', $request->old_image);
        $backgroundPath = $this->uploadImage($request, 'background', $request->old_background);

        AppDownload::updateOrCreate(
            ['id' => 1],
            [
                'image' => !empty($imagePath) ? $imagePath : $request->old_image,
                'background' => !empty($backgroundPath) ? $backgroundPath : $request->old_background,
                'title' => $request->title,
                'short_description' => $request->short_description,
                'play_store_link' => $request->play_store_link,
                'app_store_link' => $request->app_store_link
            ]
        );

        toastr()->success('Done');
        return redirect()->back();
    }
}
