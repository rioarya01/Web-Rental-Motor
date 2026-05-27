<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class LaporanBookingController extends Controller
{
    public static function middleware(): array
    {
        return [
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ];
    }

    public function index()
    {
        $booking = Booking::whereHas('status', function ($query) {
            $query->where('name', 'paid');
        })->with('vehicle', 'user')->orderBy('id', 'desc')->paginate(10);
        return view('admin.laporanBooking', compact('booking'));
    }
}
