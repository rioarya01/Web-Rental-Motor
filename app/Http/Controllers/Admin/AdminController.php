<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Booking;
use App\Models\User;
use App\Models\Vehicle;

class AdminController extends Controller
{
    public static function middleware(): array
    {
        return [
            'admin' => AdminMiddleware::class,
        ];
    }

    public function index()
    {
        $customers = User::where('role', 'user')->orderBy('id', 'desc')->paginate(10);
        $totalCustomers = User::where('role', 'user')->count();
        $vehicles = Vehicle::all();
        $totalVehicles = Vehicle::count();
        $bookings = Booking::with('vehicle', 'user')->orderBy('id', 'desc')->paginate(5);
        $totalBookings = Booking::count();
        return view('admin.dashboard-admin', compact('customers', 'totalCustomers', 'vehicles', 'totalVehicles', 'bookings', 'totalBookings'));
    }
}
