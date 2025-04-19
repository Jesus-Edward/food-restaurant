<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactDetailsUpdateRequest;
use App\Models\contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    function contact()
    {
        $contact = contact::first();
        return view('admin.contact.index', compact('contact'));
    }

    function contactUpdate(ContactDetailsUpdateRequest $request)
    {
        contact::updateOrCreate(
            ['id' => 1],
            [
                'phone_one' => $request->phone_one,
                'phone_two' => $request->phone_two,
                'email_one' => $request->email_one,
                'email_two' => $request->email_two,
                'location' => $request->location,
                'map_link' => $request->map_link
            ]
        );

        toastr()->success('Updated Successfully');
        return redirect()->back();
    }
}
