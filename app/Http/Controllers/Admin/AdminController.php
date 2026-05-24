<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Booking;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public static function middleware(): array
    {
        return [
            'admin' => AdminMiddleware::class,
        ];
    }

    public function index(Request $request)
    {
        $customers = User::where('role', 'user')->orderBy('id', 'desc')->paginate(10);
        $totalCustomers = User::where('role', 'user')->count();
        $vehicles = Vehicle::all();
        $totalVehicles = Vehicle::count();
        $bookings = Booking::with('vehicle', 'user')->orderBy('id', 'desc')->paginate(5);
        $totalBookings = Booking::count();
        // buatkan count total revenue dari booking yang sudah paid
        // total paid
        $totalPaid = Booking::whereHas('status', function ($query) {
            $query->where('name', 'paid');
        })->sum('total_amount');

        // filter chart
        $filter = $request->filter ?? 'month';

        $query = Booking::where('booking_status_id', 2);

        // ========================
        // Grafik Harian
        // ========================
        if ($filter == 'day') {

            $revenues = $query->select(
                DB::raw('DATE(created_at) as label'),
                DB::raw('SUM(total_amount) as total')
            )
                ->where('booking_status_id', 2)
                ->groupBy('label')
                ->orderBy('label')
                ->get();

            $labels = [];
            $totals = [];

            foreach ($revenues as $revenue) {
                $labels[] = date('d M', strtotime($revenue->label));
                $totals[] = $revenue->total;
            }
        }

        // ========================
        // Grafik Tahunan
        // ========================
        elseif ($filter == 'year') {

            $revenues = $query->select(
                DB::raw('YEAR(created_at) as label'),
                DB::raw('SUM(total_amount) as total')
            )
                ->where('booking_status_id', 2)
                ->groupBy('label')
                ->orderBy('label')
                ->get();

            $labels = [];
            $totals = [];

            foreach ($revenues as $revenue) {
                $labels[] = $revenue->label;
                $totals[] = $revenue->total;
            }
        }

        // ========================
        // Grafik Bulanan
        // ========================
        else {

            $revenues = $query->select(
                DB::raw('MONTH(created_at) as label'),
                DB::raw('SUM(total_amount) as total')
            )
                ->where('booking_status_id', 2)
                ->groupBy('label')
                ->orderBy('label')
                ->get();

            $labels = [];
            $totals = [];

            foreach ($revenues as $revenue) {
                $labels[] = date('M', mktime(0, 0, 0, $revenue->label, 1));
                $totals[] = $revenue->total;
            }
        }

        return view('admin.dashboard-admin', compact(
            'customers',
            'totalCustomers',
            'vehicles',
            'totalVehicles',
            'bookings',
            'totalBookings',
            'totalPaid',
            'totals',
            'labels',
            'filter'
        ));
    }
}
