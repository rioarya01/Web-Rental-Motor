<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $booking->payment_notes = null; // Clear any previous rejection notes

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

    public function uploadProofAdmin(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'payment_proof.required' => 'Bukti pembayaran wajib diunggah.',
            'payment_proof.image' => 'File harus berupa gambar.',
            'payment_proof.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'payment_proof.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('payment_proof')) {
            if ($booking->payment_proof && Storage::disk('local')->exists($booking->payment_proof)) {
                Storage::disk('local')->delete($booking->payment_proof);
            }

            $file = $request->file('payment_proof');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('payments', $fileName, 'local');

            $booking->update([
                'payment_proof' => $filePath,
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah oleh Admin.');
    }

    public function rejectProof(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'payment_notes' => 'required|string|max:255',
        ], [
            'payment_notes.required' => 'Alasan penolakan wajib diisi.',
            'payment_notes.max' => 'Alasan maksimal 255 karakter.'
        ]);

        $failedStatus = BookingStatus::where('name', 'payment_failed')->first();

        $booking->update([
            'booking_status_id' => $failedStatus->id,
            'payment_notes' => $request->payment_notes,
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran ditolak. Status dikembalikan dan alasan telah dikirimkan ke penyewa.');
    }
}
