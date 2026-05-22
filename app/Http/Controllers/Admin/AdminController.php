<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminMiddleware;

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
        return view('admin.dashboard-admin');
    }
}
