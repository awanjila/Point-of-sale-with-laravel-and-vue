<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function getSettings()
    {
        $settings = Setting::first();
        
        // If no settings exist, create default
        if (!$settings) {
            $settings = Setting::create([
                'business_name' => 'Wabe Point',
                'business_email' => 'info@wabepoint.com',
                'business_phone' => '0781312070',
                'business_address' => 'Parklands, Nairobi',
                'tax_percentage' => 16,
                'currency' => 'KES',
                'receipt_header' => 'Thank you for your business!',
                'receipt_footer' => 'Powered by Wabe Point POS'
            ]);
        }

        // Ensure logo path is a full URL if it exists
        if ($settings->logo_path) {
            $settings->logo_url = asset($settings->logo_path);
        }

        return response()->json($settings);
    }

    public function updateSettings(Request $request)
    {
        \Log::info('Update Settings Request', [
            'all_data' => $request->all(),
            'has_file' => $request->hasFile('logo'),
            'logo_file_details' => $request->file('logo') ? [
                'original_name' => $request->file('logo')->getClientOriginalName(),
                'extension' => $request->file('logo')->getClientOriginalExtension(),
                'size' => $request->file('logo')->getSize()
            ] : null
        ]);

        $validator = Validator::make($request->all(), [
            'business_name' => 'sometimes|string|max:255',
            'business_email' => 'sometimes|email|max:255',
            'business_phone' => 'sometimes|string|max:20',
            'business_address' => 'sometimes|string|max:500',
            'tax_percentage' => 'sometimes|numeric|min:0|max:100',
            'currency' => 'sometimes|string|max:10',
            'till_number' => 'sometimes|string|max:20',
            'receipt_header' => 'sometimes|string|max:500',
            'receipt_footer' => 'sometimes|string|max:500',
            'logo' => 'sometimes|image|max:2048|mimes:jpeg,png,jpg,gif'
        ]);

        if ($validator->fails()) {
            \Log::error('Validation Errors', [
                'errors' => $validator->errors()
            ]);
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $settings = Setting::first() ?? new Setting();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo_path && file_exists(public_path($settings->logo_path))) {
                unlink(public_path($settings->logo_path));
            }

            // Generate unique filename
            $logoFile = $request->file('logo');
            $logoName = Str::uuid() . '.' . $logoFile->getClientOriginalExtension();
            
            // Move to public/upload/logo directory
            $logoPath = 'upload/logo/' . $logoName;
            $logoFile->move(public_path('upload/logo'), $logoName);
            
            // Save relative path
            $settings->logo_path = $logoPath;

            \Log::info('Logo Uploaded', [
                'original_name' => $logoFile->getClientOriginalName(),
                'saved_path' => $logoPath,
                'full_public_path' => public_path('upload/logo/' . $logoName)
            ]);
        }

        // Update other settings
        $settings->fill($request->except('logo'));
        $settings->save();

        \Log::info('Settings After Save', [
            'settings_id' => $settings->id,
            'logo_path' => $settings->logo_path
        ]);

        // Add logo URL to the response
        $settings->logo_url = $settings->logo_path ? asset($settings->logo_path) : null;

        return response()->json([
            'message' => 'Settings updated successfully',
            'settings' => $settings
        ]);
    }

    public function index()
    {
        return view('settings');
    }
}
