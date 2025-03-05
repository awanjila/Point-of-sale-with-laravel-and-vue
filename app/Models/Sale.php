<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sale_no',
        'customer_id',
        'delivery_person_id',
        'sale_type',
        'status',
        'sale_date',
        'payment_terms',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'discount_type',
        'discount_amount',
        'shipping_charges',
        'total',
        'paid_amount',
        'due_amount',
        'payment_status',
        'payment_method',
        'payment_reference',
        'notes'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function deliveryPerson()
    {
        return $this->belongsTo(Employee::class, 'delivery_person_id');
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function documents()
    {
        return $this->hasMany(SaleDocument::class);
    }
} 