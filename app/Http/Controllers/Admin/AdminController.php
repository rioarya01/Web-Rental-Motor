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
        $customers = User::where('role', 'user')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $totalCustomers = User::where('role', 'user')->count();

        $vehicles = Vehicle::all();
        $totalVehicles = Vehicle::count();

        $bookings = Booking::with('vehicle', 'user')
            ->orderBy('id', 'desc')
            ->paginate(5);

        $totalBookings = Booking::count();

        $totalPendingBookings = Booking::whereHas('status', function ($query) {
            $query->where('name', 'pending_payment');
        })->count();

        $totalPaidBookings = Booking::whereHas('status', function ($query) {
            $query->where('name', 'paid');
        })->count();

        // Filter Total Pendapatan Card
        $revenueFilter = $request->revenue_filter ?? 'month';

        $totalRevenueQuery = Booking::whereHas('status', function ($query) {
            $query->where('name', 'paid');
        });

        if ($revenueFilter == 'day') {
            $totalRevenueQuery->whereDate('created_at', now()->toDateString());
        } elseif ($revenueFilter == 'year') {
            $totalRevenueQuery->whereYear('created_at', now()->year);
        } else {
            $totalRevenueQuery->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        }

        $totalRevenuePaid = $totalRevenueQuery->sum('total_amount');

        // Filter Chart Pendapatan
        $filter = $request->filter ?? 'month';

        $query = Booking::whereHas('status', function ($query) {
            $query->where('name', 'paid');
        });

        if ($filter == 'day') {
            $revenues = $query->select(
                DB::raw('DATE(created_at) as label'),
                DB::raw('SUM(total_amount) as total')
            )
                ->groupBy('label')
                ->orderBy('label')
                ->get();

            $labels = [];
            $totals = [];

            foreach ($revenues as $revenue) {
                $labels[] = date('d M', strtotime($revenue->label));
                $totals[] = $revenue->total;
            }
        } elseif ($filter == 'year') {
            $revenues = $query->select(
                DB::raw('YEAR(created_at) as label'),
                DB::raw('SUM(total_amount) as total')
            )
                ->groupBy('label')
                ->orderBy('label')
                ->get();

            $labels = [];
            $totals = [];

            foreach ($revenues as $revenue) {
                $labels[] = $revenue->label;
                $totals[] = $revenue->total;
            }
        } else {
            $revenues = $query->select(
                DB::raw('MONTH(created_at) as label'),
                DB::raw('SUM(total_amount) as total')
            )
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
            'totalPendingBookings',
            'totalPaidBookings',
            'totalRevenuePaid',
            'totals',
            'labels',
            'filter',
            'revenueFilter'
        ));
    }
}
