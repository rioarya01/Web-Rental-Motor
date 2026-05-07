<?php

namespace App\Models;

use Database\Factories\VehicleFeatureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'feature_id',
        'qty',
    ];
}
