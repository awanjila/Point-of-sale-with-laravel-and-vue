<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_cost',
        'total'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
