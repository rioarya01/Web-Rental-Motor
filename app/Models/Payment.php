<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory.php> */
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_code',
        'method',
        'provider',
        'external_reference',
        'amount',
        'payment_status_id',
        'expired_at',
        'paid_at',
        'failure_reason',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function status()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }
}
