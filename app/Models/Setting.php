<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'business_name',
        'business_email',
        'business_phone',
        'business_address',
        'logo_path',
        'receipt_header',
        'receipt_footer'
    ];

    // Singleton pattern method to get settings
    public static function getSettings()
    {
        return self::first() ?? new self();
    }
}
