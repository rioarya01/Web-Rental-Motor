<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function vehicles() // 1 to many relationship with Vehicle model
    {
        return $this->hasMany
        (Vehicle::class, 'category_id');
    }
}
