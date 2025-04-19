<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubscriberDataTable;
use App\Http\Controllers\Controller;
use App\Mail\Newsletter;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    function index(SubscriberDataTable $dataTable)
    {
        return $dataTable->render('admin.news-letter.index');
    }

    function sendNewsletter(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'max:255'],
            'message' => ['required']
        ]);

        $subscribers = Subscriber::pluck('email')->toArray();

        Mail::to($subscribers)->send(new Newsletter($request->subject, $request->message));

        toastr()->success('Newsletter sent successfully');
        return redirect()->back();
    }
}
