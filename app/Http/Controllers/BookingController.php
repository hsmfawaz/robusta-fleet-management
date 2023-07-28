<?php

namespace App\Http\Controllers;

use App\Datatables\BookingDatatable;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index(BookingDatatable $datatable)
    {
        return $datatable->render('dashboard.bookings.index');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json(['status' => true]);
    }
}
