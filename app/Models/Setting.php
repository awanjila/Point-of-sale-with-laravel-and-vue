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
        'tax_percentage',
        'currency',
        'till_number',
        'receipt_header',
        'receipt_footer',
        'logo_path'
    ];

    // Optional: Cast certain fields
    protected $casts = [
        'tax_percentage' => 'float'
    ];
}
