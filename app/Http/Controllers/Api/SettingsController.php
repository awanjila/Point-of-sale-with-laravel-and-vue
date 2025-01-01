<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::getSettings();
        
        return response()->json([
            'status' => 'success',
            'settings' => $settings
        ]);
    }
} 