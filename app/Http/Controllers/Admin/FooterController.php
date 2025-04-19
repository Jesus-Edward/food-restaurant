<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterInfo;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    function index()
    {
        $footer_info = FooterInfo::first();
        return view('admin.footer.index', compact('footer_info'));
    }

    function updateFooterInfo(Request $request)
    {
        $request->validate([
            'short_info' => ['nullable', 'max:1000'],
            'address' => ['nullable', 'max:255'],
            'phone' => ['nullable', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'copyright' => ['nullable', 'max:255']
        ]);

        FooterInfo::updateOrCreate(
            ['id' => 1],
            [
                'short_info' => $request->short_info,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'copyright' => $request->copyright
            ]
        );

        toastr()->success('Updated Successfully');
        return redirect()->back();
    }
}
