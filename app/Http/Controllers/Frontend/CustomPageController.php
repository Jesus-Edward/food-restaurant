<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomPageBuilder;
use Illuminate\Http\Request;

class CustomPageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($slug)
    {
        $customPage = CustomPageBuilder::where(['status' => 1, 'slug' => $slug])->firstOrFail();
        return view('frontend.pages.custom-page', compact('customPage'));
    }
}
