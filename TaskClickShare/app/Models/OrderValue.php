<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderValue extends Model
{
    protected $fillable = ['order_id','attribute_id','value'];

    protected $with = ['order', 'attribute'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
