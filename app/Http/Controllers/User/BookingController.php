<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function create(Vehicle $vehicle)
    {
        return view('user.booking-create', compact('vehicle'));
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'rent_start' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $rentStart = \Carbon\Carbon::parse($value);
                    if ($rentStart->isBefore(now()->addHours(24))) {
                        $fail('Pemesanan harus dilakukan minimal 1x24 jam sebelum waktu penyewaan.');
                    }

                    $time = $rentStart->format('H:i');
                    if ($time < '06:00' || $time > '22:00') {
                        $fail('Waktu mulai sewa harus berada di antara jam 06:00 hingga 22:00.');
                    }
                },
            ],
            'duration_days' => 'required|integer|min:1|max:5',
            'pickup_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $rentStart = Carbon::parse($request->rent_start);
        $durationDays = (int) $request->duration_days;
        $rentEnd = $rentStart->copy()->addDays($durationDays);

        $totalAmount = $durationDays * $vehicle->price_per_day;

        // Generate Booking Code
        do {
            $bookingCode = 'BK-'.Str::upper(Str::random(2)).rand(100, 999);
        } while (Booking::where('booking_code', $bookingCode)->exists());

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'vehicle_id' => $vehicle->id,
            'user_id' => auth()->id(),
            'booking_date' => now(),
            'rent_start' => $rentStart,
            'rent_end' => $rentEnd,
            'duration_days' => $durationDays,
            'price_per_day' => $vehicle->price_per_day,
            'discount_amount' => 0,
            'total_amount' => $totalAmount,
            'booking_status_id' => 1, // pending_payment
            'pickup_address' => $request->pickup_address,
            'notes' => $request->notes,
        ]);

        return redirect()->route('booking.checkout', $booking->id);
    }

    public function checkout(Booking $booking)
    {
        // booking milik user yang sedang login
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->load(['vehicle.vehicle_category', 'user']);

        return view('user.booking-checkout', compact('booking'));
    }

    public function history()
    {
        $bookings = Booking::with('vehicle')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.booking-history', compact('bookings'));
    }
}
