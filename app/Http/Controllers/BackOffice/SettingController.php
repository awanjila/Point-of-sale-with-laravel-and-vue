<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function getSettings()
    {
        try {
            // Attempt to retrieve settings
            $settings = Setting::first();

            // Log the retrieved settings
            Log::info('Settings retrieved:', [
                'settings' => $settings ? $settings->toArray() : 'No settings found'
            ]);

            // If no settings exist, create a default setting
            if (!$settings) {
                $settings = Setting::create([
                    'business_name' => 'Default Business',
                    'business_email' => 'info@defaultbusiness.com',
                    'business_phone' => '+254 700 000 000',
                    'business_address' => 'Default Address',
                    'receipt_footer' => 'Thank you for your business!'
                ]);

                Log::info('Default settings created:', $settings->toArray());
            }

            return response()->json([
                'status' => 'success',
                'settings' => $settings
            ]);
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Error retrieving settings: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve settings: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateSettings(Request $request)
    {
        try {
            $settings = Setting::first() ?? new Setting();

            $settings->fill($request->only([
                'business_name',
                'business_email',
                'business_phone',
                'business_address',
                'receipt_header',
                'receipt_footer'
            ]));

            $settings->save();

            return response()->json([
                'status' => 'success',
                'settings' => $settings
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating settings: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update settings: ' . $e->getMessage()
            ], 500);
        }
    }
}
