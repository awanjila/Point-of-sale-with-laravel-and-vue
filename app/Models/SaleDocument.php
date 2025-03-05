<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SaleDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'document_path',
        'document_name',
        'document_type'
    ];

    /**
     * Get the sale that owns the document.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Get the full URL for the document.
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->document_path);
    }

    /**
     * Delete the file when the model is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($document) {
            Storage::disk('public')->delete($document->document_path);
        });
    }
} 