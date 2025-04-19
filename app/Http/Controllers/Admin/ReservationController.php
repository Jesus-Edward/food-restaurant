<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReservationDataTable;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    function reservationsIndex(ReservationDataTable $dataTable)
    {
        return $dataTable->render('admin.reservation.index');
    }

    function reservationsUpdate(Request $request)
    {
        $reservation = Reservation::findOrFail($request->id);
        $reservation->status = $request->status;

        $reservation->save();
        return response(['status' => 'success', 'message' => 'Status Updated']);
    }

    function reservationsDestroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();

            return response(['status' => 'success', 'message' => 'Reservation Deleted']);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong in the frontend']);
        }
    }
}
