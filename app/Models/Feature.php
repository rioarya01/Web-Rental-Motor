<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_id',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function vehicles()
    {
        return $this->belongsToMany(
            Vehicle::class,
            'vehicles_features',
            'feature_id',
            'vehicle_id'
        )->withPivot('qty');
    }
}
