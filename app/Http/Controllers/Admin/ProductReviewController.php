<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductRatingDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    function productReviewIndex(ProductRatingDataTable $dataTable)
    {
        return $dataTable->render('admin.product.product-review.index');
    }

    function reviewStatusUpdate(Request $request)
    {
        $review = ProductRating::findOrFail($request->id);
        $review->status = $request->status;

        $review->save();
        return response(['status' => 'success', 'message' => 'Status Updated']);
    }

    function reviewDestroy($id)
    {
        try {
            $review = ProductRating::findOrFail($id);
            $review->delete();

            return response(['status' => 'success', 'message' => 'Review Deleted']);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong in the frontend']);
        }
    }
}
