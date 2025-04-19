<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReservationTimeDataTable;
use App\Http\Controllers\Controller;
use App\Models\ReservationTime;
use Illuminate\Http\Request;

class ReservationTimeController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function index(ReservationTimeDataTable $dataTable)
    {
        return $dataTable->render('admin.reservation.reservation-time.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reservation.reservation-time.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'starting_time' => ['required'],
            'stoppage_time' => ['required'],
            'status' => ['required', 'boolean']
        ]);

        $reservationTime = new ReservationTime();
        $reservationTime->starting_time = $request->starting_time;
        $reservationTime->stoppage_time = $request->stoppage_time;

        $reservationTime->save();
        toastr()->success('Reservation Time Created');
        return to_route('admin.reservation-time.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reservationTime = ReservationTime::findOrFail($id);
        return view('admin.reservation.reservation-time.edit', compact('reservationTime'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'starting_time' => ['required'],
            'stoppage_time' => ['required'],
            'status' => ['required', 'boolean']
        ]);

        $reservationTime = ReservationTime::findOrFail($id);
        $reservationTime->starting_time = $request->starting_time;
        $reservationTime->stoppage_time = $request->stoppage_time;

        $reservationTime->save();
        toastr()->success('Reservation Time Updated');
        return to_route('admin.reservation-time.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $reservationTime = ReservationTime::findOrFail($id);
            $reservationTime->delete();

            return response(['status' => 'success', 'message' => 'Reservation Time Deleted']);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong in the frontend']);
        }
    }
}
