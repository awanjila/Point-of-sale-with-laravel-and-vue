<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        // Check if settings already exist
        if (!Setting::exists()) {
            Setting::create([
                'business_name' => 'Your Business Name',
                'business_email' => 'info@yourbusiness.com',
                'business_phone' => '+254 700 000 000',
                'business_address' => '123 Business Street, City, Country',
                'receipt_footer' => 'We appreciate your business!'
            ]);
        }
    }
} 