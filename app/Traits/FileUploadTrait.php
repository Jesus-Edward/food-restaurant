<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait FileUploadTrait
{
    public function uploadImage(Request $request, $inputName, $oldPath = NULL, $path = "/uploads")
    {
        if ($request->hasFile($inputName)) {
            if ($oldPath && File::exists(public_path($oldPath))) {
                File::delete(public_path($oldPath));
            };
            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media' . uniqid() . '.' . $ext;

            $image->move(public_path($path), $imageName);

            return $path . '/' . $imageName;
        }
        return NULL;
    }

    public function removeImage(string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        };
    }
}
