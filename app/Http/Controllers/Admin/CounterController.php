<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CounterUpdateRequest;
use App\Models\Counter;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    use FileUploadTrait;
    function index() {
        $counter = Counter::first();
        return view('admin.counter.index', compact('counter'));
    }

    function store(CounterUpdateRequest $request) {

        $backgroundPath = $this->uploadImage($request, 'background', $request->old_background);

        Counter::updateOrCreate(
            ['id' => 1],
            [
                'background' => !empty($backgroundPath) ? $backgroundPath : $request->old_background,
                'counter_title_one' => $request->counter_title_one,
                'counter_count_one' => $request->counter_count_one,
                'counter_icon_one' => $request->counter_icon_one,

                'counter_title_two' => $request->counter_title_two,
                'counter_count_two' => $request->counter_count_two,
                'counter_icon_two' => $request->counter_icon_two,

                'counter_title_three' => $request->counter_title_three,
                'counter_count_three' => $request->counter_count_three,
                'counter_icon_three' => $request->counter_icon_three,

                'counter_title_four' => $request->counter_title_four,
                'counter_count_four' => $request->counter_count_four,
                'counter_icon_four' => $request->counter_icon_four,
            ]
        );

        toastr()->success('Updated Successfully');
        return redirect()->back();
    }
}
