<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id', 'client_name', 'phone_number', 'product_code', 'final_price', 'quantity'];

    public function values()
    {
        return $this->hasMany(OrderValue::class);
    }
}
