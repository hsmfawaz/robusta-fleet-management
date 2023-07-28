<?php

namespace App\Http\Controllers\Dashboard;

use App\Datatables\BookingDatatable;
use App\Http\Controllers\Controller;
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
