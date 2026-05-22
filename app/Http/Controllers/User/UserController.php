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
        $query = Vehicle::with('vehicle_category', 'vehicle_brand')
            ->orderBy('id', 'desc');

        $category = VehicleCategory::all();
        $brands = VehicleBrand::all();
        // Search Filter
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        // Filter berdasarkan kategori
        if ($request->has('vehicle_category') && $request->vehicle_category != '') {
            $query->where('category_id', $request->vehicle_category);
        }

        // Filter brand
        if ($request->has('vehicle_brand') && $request->vehicle_brand != '') {
            $query->where('brand_id', $request->vehicle_brand);
        }

        // Filter status
        $query->when($request->operational_status, function ($q, $status) {
            $q->where('operational_status', $status);
        });

        // Filter harga (range)
        $query->when($request->min_price, function ($q, $min) {
            $q->where('price_per_day', '>=', $min);
        });

        $query->when($request->max_price, function ($q, $max) {
            $q->where('price_per_day', '<=', $max);
        });

        $vehicles = $query->paginate(6)->withQueryString();

        return view('user.dashboard-user', compact(
            'vehicles',
            'category',
            'brands'
        ));
    }
}
