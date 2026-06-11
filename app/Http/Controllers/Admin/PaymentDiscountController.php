<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\PaymentAccount;
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
        $paymentAccounts = PaymentAccount::latest()->get();
        $discounts = Discount::with(['vehicle', 'brand', 'category'])->latest()->get();
        
        $vehicles = Vehicle::all();
        $brands = VehicleBrand::all();
        $categories = VehicleCategory::all();

        return view('admin.payment-discount', compact(
            'paymentSetting', 'paymentAccounts', 'discounts', 'vehicles', 'brands', 'categories'
        ));
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'nullable|string',
        ]);

        $setting = PaymentSetting::first();
        if (!$setting) {
            $setting = new PaymentSetting();
        }
        
        $setting->update($request->only([
            'whatsapp_number'
        ]));

        return back()->with('success', 'Pengaturan WhatsApp berhasil diperbarui.');
    }

    public function storePaymentAccount(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
        ]);

        PaymentAccount::create([
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'is_active' => true,
        ]);

        return back()->with('success', 'Rekening Pembayaran berhasil ditambahkan.');
    }

    public function updatePaymentAccount(Request $request, PaymentAccount $paymentAccount)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $paymentAccount->update([
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Rekening Pembayaran berhasil diperbarui.');
    }

    public function destroyPaymentAccount(PaymentAccount $paymentAccount)
    {
        $paymentAccount->delete();
        return back()->with('success', 'Rekening Pembayaran berhasil dihapus.');
    }

    public function storeDiscount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|integer|min:1|max:100',
            'target_type' => 'required|string|in:global,vehicle,brand,category',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'brand_id' => 'nullable|exists:vehicle_brands,id',
            'category_id' => 'nullable|exists:vehicle_categories,id',
        ]);

        $data = $request->except('target_type');
        
        if ($request->target_type == 'global') {
            $data['vehicle_id'] = null;
            $data['brand_id'] = null;
            $data['category_id'] = null;
        } elseif ($request->target_type == 'vehicle') {
            $data['brand_id'] = null;
            $data['category_id'] = null;
        } elseif ($request->target_type == 'brand') {
            $data['vehicle_id'] = null;
            $data['category_id'] = null;
        } elseif ($request->target_type == 'category') {
            $data['vehicle_id'] = null;
            $data['brand_id'] = null;
        }

        Discount::create($data);

        return back()->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function updateDiscount(Request $request, Discount $discount)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|integer|min:1|max:100',
            'target_type' => 'required|string|in:global,vehicle,brand,category',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'brand_id' => 'nullable|exists:vehicle_brands,id',
            'category_id' => 'nullable|exists:vehicle_categories,id',
            'is_active' => 'boolean'
        ]);

        $data = $request->except('target_type');
        $data['is_active'] = $request->has('is_active');
        
        if ($request->target_type == 'global') {
            $data['vehicle_id'] = null;
            $data['brand_id'] = null;
            $data['category_id'] = null;
        } elseif ($request->target_type == 'vehicle') {
            $data['vehicle_id'] = $request->vehicle_id ?: null;
            $data['brand_id'] = null;
            $data['category_id'] = null;
        } elseif ($request->target_type == 'brand') {
            $data['vehicle_id'] = null;
            $data['brand_id'] = $request->brand_id ?: null;
            $data['category_id'] = null;
        } elseif ($request->target_type == 'category') {
            $data['vehicle_id'] = null;
            $data['brand_id'] = null;
            $data['category_id'] = $request->category_id ?: null;
        }

        $discount->update($data);

        return back()->with('success', 'Diskon berhasil diperbarui.');
    }

    public function destroyDiscount(Discount $discount)
    {
        $discount->delete();
        return back()->with('success', 'Diskon berhasil dihapus.');
    }
}
