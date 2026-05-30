<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\PaymentSetting;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;

class PaymentDiscountController extends Controller
{
    public function index()
    {
        $paymentSetting = PaymentSetting::first();
        $discounts = Discount::with(['vehicle', 'brand', 'category'])->latest()->get();
        
        $vehicles = Vehicle::all();
        $brands = VehicleBrand::all();
        $categories = VehicleCategory::all();

        return view('admin.payment-discount', compact(
            'paymentSetting', 'discounts', 'vehicles', 'brands', 'categories'
        ));
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'bank_bca' => 'nullable|string',
            'bank_mandiri' => 'nullable|string',
            'account_name' => 'nullable|string',
            'whatsapp_number' => 'nullable|string',
        ]);

        $setting = PaymentSetting::first();
        if (!$setting) {
            $setting = new PaymentSetting();
        }
        
        $setting->update($request->only([
            'bank_bca', 'bank_mandiri', 'account_name', 'whatsapp_number'
        ]));

        return back()->with('success', 'Pengaturan pembayaran berhasil diperbarui.');
    }

    public function storeDiscount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|integer|min:1|max:100',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'brand_id' => 'nullable|exists:vehicle_brands,id',
            'category_id' => 'nullable|exists:vehicle_categories,id',
        ]);

        Discount::create($request->all());

        return back()->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function updateDiscount(Request $request, Discount $discount)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|integer|min:1|max:100',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'brand_id' => 'nullable|exists:vehicle_brands,id',
            'category_id' => 'nullable|exists:vehicle_categories,id',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        // Handle nulls if empty
        $data['vehicle_id'] = $request->vehicle_id ?: null;
        $data['brand_id'] = $request->brand_id ?: null;
        $data['category_id'] = $request->category_id ?: null;

        $discount->update($data);

        return back()->with('success', 'Diskon berhasil diperbarui.');
    }

    public function destroyDiscount(Discount $discount)
    {
        $discount->delete();
        return back()->with('success', 'Diskon berhasil dihapus.');
    }
}
