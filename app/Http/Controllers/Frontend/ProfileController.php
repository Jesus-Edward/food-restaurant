<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfilePasswordUpdateRequest;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Http\Requests\Frontend\ProfileUpdatePassword;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use FileUploadTrait;
    public function updateProfile(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->update();

        toastr()->success('Profile Updated successfully', 'Updated');
        return redirect()->back();
    }

    public function updatePassword(ProfileUpdatePassword $request): RedirectResponse
    {
        $user = Auth::user();
        $user->password = bcrypt($request->password);

        $user->update();

        toastr()->success('Password updated successfully', 'Updated');
        return redirect()->back();
    }

    public function updateAvatar(Request $request){
        $imagePath = $this->uploadImage($request, 'avatar');

        $user = Auth::user();
        $user->avatar = $imagePath;
        $user->update();

        return response(['status' => 'success', 'message' => 'Avatar updated successfully']);
    }
}
