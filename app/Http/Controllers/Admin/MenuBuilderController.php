<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuBuilderController extends Controller
{
    function index()
    {
        return view('admin.menu-builder.index');
    }
}
