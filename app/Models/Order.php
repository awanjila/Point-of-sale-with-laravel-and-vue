<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'invoice_no',
        'order_date',
        'order_status',
        'total_products',
        'sub_total',
        'vat',
        'total',
        'payment_status',
        'payment_method',
        'pay',
        'due'
    ];

    // Relationship with order details
    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Relationship with customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
