<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\UserMiddleware;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public static function middleware(): array
    {
        return [
            'user' => UserMiddleware::class,
        ];
    }
    public function index(Request $request)
    {
        $vehicles = Vehicle::with('vehicle_category', 'vehicle_brand')
            ->inRandomOrder()
            ->take(3)
            ->get();
        $category = VehicleCategory::all();
        $brands = VehicleBrand::all();
        return view('user.home-user', compact(
            'vehicles',
            'category',
            'brands'
        ));
    }
}