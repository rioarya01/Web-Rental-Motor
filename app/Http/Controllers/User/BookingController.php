<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\UserMiddleware;
use App\Models\Booking;
use App\Models\Discount;
use App\Models\PaymentSetting;
use App\Models\PaymentAccount;
use App\Models\BookingStatus;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public static function middleware(): array
    {
        return [
            'user' => UserMiddleware::class,
        ];
    }
    public function create(Vehicle $vehicle)
    {
        $vehicle->load('features.unit');
        
        $activeDiscount = Discount::where('is_active', true)
            ->where(function($query) use ($vehicle) {
                $query->where('vehicle_id', $vehicle->id)
                      ->orWhere('brand_id', $vehicle->brand_id)
                      ->orWhere('category_id', $vehicle->category_id)
                      ->orWhere(function($q) {
                          $q->whereNull('vehicle_id')
                            ->whereNull('brand_id')
                            ->whereNull('category_id');
                      });
            })
            ->orderByRaw('
                CASE 
                    WHEN vehicle_id IS NOT NULL THEN 1 
                    WHEN brand_id IS NOT NULL THEN 2 
                    WHEN category_id IS NOT NULL THEN 3 
                    ELSE 4 
                END
            ')
            ->first();

        return view('user.booking-create', compact('vehicle', 'activeDiscount'));
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

        $baseTotal = $durationDays * $vehicle->price_per_day;
        
        $discountAmount = 0;
        $activeDiscount = Discount::where('is_active', true)
            ->where(function($query) use ($vehicle) {
                $query->where('vehicle_id', $vehicle->id)
                      ->orWhere('brand_id', $vehicle->brand_id)
                      ->orWhere('category_id', $vehicle->category_id)
                      ->orWhere(function($q) {
                          $q->whereNull('vehicle_id')
                            ->whereNull('brand_id')
                            ->whereNull('category_id');
                      });
            })
            ->orderByRaw('
                CASE 
                    WHEN vehicle_id IS NOT NULL THEN 1 
                    WHEN brand_id IS NOT NULL THEN 2 
                    WHEN category_id IS NOT NULL THEN 3 
                    ELSE 4 
                END
            ')
            ->first();

        if ($activeDiscount) {
            $discountAmount = ($baseTotal * $activeDiscount->percentage) / 100;
        }

        $totalAmount = $baseTotal - $discountAmount;

        // Generate Booking Code
        do {
            $bookingCode = 'BK-' . Str::upper(Str::random(2)) . rand(100, 999);
        } while (Booking::where('booking_code', $bookingCode)->exists());

        $vehicle->load('features.unit');

        $featuresSnapshot = $vehicle->features
        ->map(function ($feature) {
            return [
                'id' => $feature->id,
                'name' => $feature->name,
                'qty' => (int) ($feature->pivot->qty ?? 1),
                'unit' => $feature->unit?->name,
            ];
        })
        ->values()
        ->toArray();

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'vehicle_id' => $vehicle->id,
            'user_id' => Auth::id(),
            'booking_date' => now(),
            'rent_start' => $rentStart,
            'rent_end' => $rentEnd,
            'duration_days' => $durationDays,
            'price_per_day' => $vehicle->price_per_day,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'booking_status_id' => 1, // pending_payment
            'pickup_address' => $request->pickup_address,
            'notes' => $request->notes,
            'features_snapshot' => $featuresSnapshot,
        ]);

        return redirect()->route('booking.checkout', $booking->id);
    }

    public function edit(Booking $booking)
    {
        if ($booking->user_id !== Auth::id() || $booking->booking_status_id !== 1) {
            abort(403, 'Unauthorized action.');
        }

        $vehicle = $booking->vehicle;
        $activeDiscount = Discount::where('is_active', true)
            ->where(function($query) use ($vehicle) {
                $query->where('vehicle_id', $vehicle->id)
                      ->orWhere('brand_id', $vehicle->brand_id)
                      ->orWhere('category_id', $vehicle->category_id)
                      ->orWhere(function($q) {
                          $q->whereNull('vehicle_id')
                            ->whereNull('brand_id')
                            ->whereNull('category_id');
                      });
            })
            ->orderByRaw('
                CASE 
                    WHEN vehicle_id IS NOT NULL THEN 1 
                    WHEN brand_id IS NOT NULL THEN 2 
                    WHEN category_id IS NOT NULL THEN 3 
                    ELSE 4 
                END
            ')
            ->first();

        return view('user.booking-create', compact('vehicle', 'activeDiscount', 'booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id() || $booking->booking_status_id !== 1) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rent_start' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($booking) {
                    $rentStart = \Carbon\Carbon::parse($value);
                    if ($rentStart->isBefore(now()->addHours(24)) && $value !== \Carbon\Carbon::parse($booking->rent_start)->format('Y-m-d\TH:i')) {
                        $fail('Pemesanan harus dilakukan minimal 1x24 jam sebelum waktu penyewaan.');
                    }
                },
            ],
            'duration_days' => 'required|integer|min:1|max:30',
            'pickup_address' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ], [
            'rent_start.required' => 'Tanggal & Jam ambil wajib diisi.',
            'rent_start.date' => 'Format Tanggal & Jam ambil tidak valid.',
            'duration_days.required' => 'Durasi sewa wajib dipilih.',
            'duration_days.integer' => 'Durasi sewa harus berupa angka.',
            'duration_days.min' => 'Durasi sewa minimal 1 hari.',
            'duration_days.max' => 'Durasi sewa maksimal 30 hari.',
            'pickup_address.required' => 'Alamat pengambilan/pengiriman wajib diisi.',
            'pickup_address.max' => 'Alamat terlalu panjang (maksimal 255 karakter).',
        ]);

        $vehicle = $booking->vehicle;
        $rentStart = Carbon::parse($request->rent_start);
        $durationDays = (int) $request->duration_days;
        $rentEnd = $rentStart->copy()->addDays($durationDays);
        $baseTotal = $durationDays * $vehicle->price_per_day;
        
        $discountAmount = 0;
        $activeDiscount = Discount::where('is_active', true)
            ->where(function($query) use ($vehicle) {
                $query->where('vehicle_id', $vehicle->id)
                      ->orWhere('brand_id', $vehicle->brand_id)
                      ->orWhere('category_id', $vehicle->category_id)
                      ->orWhere(function($q) {
                          $q->whereNull('vehicle_id')
                            ->whereNull('brand_id')
                            ->whereNull('category_id');
                      });
            })
            ->orderByRaw('
                CASE 
                    WHEN vehicle_id IS NOT NULL THEN 1 
                    WHEN brand_id IS NOT NULL THEN 2 
                    WHEN category_id IS NOT NULL THEN 3 
                    ELSE 4 
                END
            ')
            ->first();

        if ($activeDiscount) {
            $discountAmount = ($baseTotal * $activeDiscount->percentage) / 100;
        }

        $totalAmount = $baseTotal - $discountAmount;

        $booking->update([
            'rent_start' => $rentStart,
            'rent_end' => $rentEnd,
            'duration_days' => $durationDays,
            'pickup_address' => $request->pickup_address,
            'notes' => $request->notes,
            'total_amount' => $totalAmount,
            'discount_amount' => $discountAmount,
        ]);

        return redirect()->route('booking.checkout', $booking->id);
    }

    public function checkout(Booking $booking)
    {
        // booking milik user yang sedang login
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->load(['vehicle.vehicle_category', 'user']);
        $paymentSetting = PaymentSetting::first();
        $paymentAccounts = PaymentAccount::where('is_active', true)->get();

        // Cari diskon untuk tampilan nama diskon
        $vehicle = $booking->vehicle;
        $activeDiscount = Discount::where('is_active', true)
            ->where(function($query) use ($vehicle) {
                $query->where('vehicle_id', $vehicle->id)
                      ->orWhere('brand_id', $vehicle->brand_id)
                      ->orWhere('category_id', $vehicle->category_id)
                      ->orWhere(function($q) {
                          $q->whereNull('vehicle_id')
                            ->whereNull('brand_id')
                            ->whereNull('category_id');
                      });
            })
            ->orderByRaw('
                CASE 
                    WHEN vehicle_id IS NOT NULL THEN 1 
                    WHEN brand_id IS NOT NULL THEN 2 
                    WHEN category_id IS NOT NULL THEN 3 
                    ELSE 4 
                END
            ')
            ->first();

        return view('user.booking-checkout', compact('booking', 'paymentSetting', 'activeDiscount', 'paymentAccounts'));
    }

    public function uploadProof(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'payment_proof.required' => 'Bukti pembayaran wajib diunggah.',
            'payment_proof.image' => 'File harus berupa gambar.',
            'payment_proof.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'payment_proof.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('payment_proof')) {
            // Hapus gambar lama jika ada
            if ($booking->payment_proof && Storage::disk('local')->exists($booking->payment_proof)) {
                Storage::disk('local')->delete($booking->payment_proof);
            }

            $file = $request->file('payment_proof');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Simpan di disk local (private)
            $filePath = $file->storeAs('payments', $fileName, 'local');

            $pendingStatus = BookingStatus::where('name', 'pending_payment')->first();

            $booking->update([
                'payment_proof' => $filePath,
                'payment_notes' => null, // Hapus alasan penolakan sebelumnya jika ada
                'booking_status_id' => $pendingStatus->id,
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    public function showPaymentProof(Booking $booking)
    {
        // Hanya pemilik booking atau admin yang bisa melihat
        if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if (!$booking->payment_proof || !Storage::disk('local')->exists($booking->payment_proof)) {
            abort(404, 'Payment proof not found.');
        }

        return Storage::disk('local')->response($booking->payment_proof);
    }

    public function history()
    {
        $bookings = Booking::with('vehicle', 'status')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.booking-history', compact('bookings'));
    }
}
