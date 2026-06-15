<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Feature;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'code',
        'name',
        'slug',
        'plate_number',
        'fuel_tank_capacity',
        'description',
        'price_per_day',
        'is_featured',
        'operational_status',
        'image',
    ];

    public function getOperationalStatusLabelAttribute()
    {
        return match ($this->operational_status) {
            'active' => 'Tersedia',
            'inactive' => 'Tidak Tersedia',
            'maintenance' => 'Pemeliharaan',
            default => '-',
        };
    }

    public function getOperationalStatusColorAttribute()
    {
        return match ($this->operational_status) {
            'active' => 'background-color:#dcfce7; color:#15803d;',
            'inactive' => 'background-color:#fee2e2; color:#b91c1c;',
            'maintenance' => 'background-color:#fef9c3; color:#a16207;',
            default => 'background-color:#f3f4f6; color:#374151;',
        };
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('img/default/defaultIMG.png');
        }

        if (str_starts_with($this->image, 'vehicles/')) {
            return asset('storage/' . $this->image);
        }

        return asset('img/vehicles/' . $this->image);
    }

    public function vehicle_category() // many to 1 relationship with VehicleCategory model
    {
        return $this->belongsTo(VehicleCategory::class, 'category_id');
    }

    public function vehicle_brand() // many to 1 relationship with VehicleBrand model
    {
        return $this->belongsTo(VehicleBrand::class, 'brand_id');
    }

    public function features()
    {
        return $this->belongsToMany(
            Feature::class,
            'vehicle_features',
            'vehicle_id',
            'feature_id'
        )
            ->withPivot('qty')
            ->withTimestamps();
    }
}
