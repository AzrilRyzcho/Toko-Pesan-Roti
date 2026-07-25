<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class SettingService
{
    protected static string $filePath = 'settings.json';

    public static function defaults(): array
    {
        return [
            'maintenance_mode' => false,
            'store_name' => 'Toko Pesan Roti',
            'store_description' => 'Kehangatan di Setiap Gigitan. Toko roti artisanal lingkungan yang menyajikan roti segar setiap hari.',
            'contact_email' => 'halo@tokopesanroti.com',
            'whatsapp_number' => '+62 812-3456-7890',
            'store_address' => 'Jl. Kenangan Manis No. 42, RT 03/RW 05, Kel. Roti Kismis, Kec. Oven Panas, Kota Bandung, Jawa Barat 40123',
            'shipping_fee' => 15000,
            'free_shipping_km' => 5,
            'shipping_notes' => 'Pengiriman dilakukan setiap hari mulai pukul 10.00 WIB. Pesanan di atas jam 15.00 WIB akan dikirim keesokan harinya.',
        ];
    }

    public static function all(): array
    {
        if (Storage::disk('local')->exists(self::$filePath)) {
            $json = Storage::disk('local')->get(self::$filePath);
            $data = json_decode($json, true) ?: [];
            return array_merge(self::defaults(), $data);
        }
        return self::defaults();
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = self::all();
        return $all[$key] ?? $default;
    }

    public static function setMany(array $settings): void
    {
        $current = self::all();
        $updated = array_merge($current, $settings);
        Storage::disk('local')->put(self::$filePath, json_encode($updated, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
