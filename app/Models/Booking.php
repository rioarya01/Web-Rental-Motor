<?php

namespace App\Models;

use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'vehicle_id',
        'user_id',
        'booking_date',
        'rent_start',
        'rent_end',
        'duration_days',
        'price_per_day',
        'discount_amount',
        'total_amount',
        'booking_status_id',
        'payment_proof',
        'payment_notes',
        'pickup_address',
        'notes',
    ];

    public function getBookingStatusLabelAttribute() //accessor untuk mendapatkan label status booking
    {
        if ($this->status->name === 'pending_payment' && $this->payment_proof) {
            return 'Menunggu Konfirmasi';
        }

        return match ($this->status->name) {
            'pending_payment' => 'Belum Bayar',
            'paid' => 'Sudah Bayar',
            'payment_failed' => 'Pembayaran Ditolak',
            'cancelled' => 'Dibatalkan',
            default => '-',
        };
    }
    public function getBookingStatusBadgeAttribute(): string
    {
        if ($this->status->name === 'pending_payment' && $this->payment_proof) {
            return 'bg-info text-white border border-info';
        }

        return match ($this->status->name) {
            'pending_payment' => 'bg-light text-secondary border',
            'paid' => 'bg-success-light text-success border border-success',
            'payment_failed' => 'bg-danger-light text-danger border border-danger',
            'cancelled' => 'bg-warning text-dark border border-warning',
            default => 'bg-secondary text-white',
        };
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(BookingStatus::class, 'booking_status_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
