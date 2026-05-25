<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatus;
use Illuminate\Http\Request;

class BookingDataController extends Controller
{
    public static function middleware(): array
    {
        return [
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ];
    }

    public function index()
    {
        $booking = Booking::with('vehicle', 'user')->orderBy('id', 'desc')->paginate(10);
        return view('admin.bookingData', compact('booking'));
    }

    public function updateStatus($id)
    {
        $booking = Booking::findOrFail($id);
        $paidStatus = BookingStatus::where('name', 'paid')->first();

        $booking->booking_status_id = $paidStatus->id;

        $booking->save();

        return redirect()->route('booking.index')->with('success', 'Booking status updated successfully.');
    }
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $cancelledStatus = BookingStatus::where('name', 'pending_payment')->first();

        $booking->booking_status_id = $cancelledStatus->id;

        $booking->save();

        return redirect()->route('booking.index')->with('success', 'Booking cancelled successfully.');
    }
}
