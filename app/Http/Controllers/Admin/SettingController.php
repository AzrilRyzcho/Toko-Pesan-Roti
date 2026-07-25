<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SettingService::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'maintenance_mode' => 'nullable|boolean',
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string|max:1000',
            'contact_email' => 'required|email|max:255',
            'whatsapp_number' => 'required|string|max:50',
            'store_address' => 'required|string|max:1000',
            'shipping_fee' => 'required|numeric|min:0',
            'free_shipping_km' => 'required|numeric|min:0',
            'shipping_notes' => 'nullable|string|max:1000',
        ]);

        // Checkbox handling for maintenance_mode
        $validated['maintenance_mode'] = $request->has('maintenance_mode');

        SettingService::setMany($validated);

        $statusMsg = $validated['maintenance_mode'] 
            ? 'Pengaturan berhasil disimpan. MODE MAINTENANCE SEKARANG AKTIF!' 
            : 'Pengaturan website berhasil diperbarui!';

        return back()->with('success', $statusMsg);
    }
}
