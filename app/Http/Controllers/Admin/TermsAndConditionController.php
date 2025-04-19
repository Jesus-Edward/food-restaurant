<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class TermsAndConditionController extends Controller
{
    function index()
    {
        $termsAndCons = TermsAndCondition::first();
        return view('admin.terms&cons.index', compact('termsAndCons'));
    }

    function termsAndConditionsUpdate(Request $request)
    {
        $request->validate([
            'terms_and_cons' => ['required']
        ]);

        TermsAndCondition::updateOrCreate(
            ['id' => 1],
            [
                'terms_and_cons' => $request->terms_and_cons
            ]
        );

        toastr()->success('Updated Successfully');
        return redirect()->back();
    }
}
