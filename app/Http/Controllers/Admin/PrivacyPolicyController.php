<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    function index()
    {
        $privatePolicy = PrivacyPolicy::first();
        return view('admin.privacy-policy.index', compact('privatePolicy'));
    }

    function privacyPolicyUpdate(Request $request)
    {
        $request->validate([
            'privacy_policy' => ['required']
        ]);

        PrivacyPolicy::updateOrCreate(
            ['id' => 1],
            [
                'privacy_policy' => $request->privacy_policy
            ]
        );

        toastr()->success('Updated Successfully');
        return redirect()->back();
    }
}
