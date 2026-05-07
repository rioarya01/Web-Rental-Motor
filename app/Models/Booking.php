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
        'pickup_address',
        'notes',
    ];

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
