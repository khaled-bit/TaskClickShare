<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['name', 'type'];
    protected $table = 'attributes';
    public function productValues()
    {
        return $this->hasMany(ProductValue::class);
    }

    public function orderValues()
    {
        return $this->hasMany(OrderValue::class);
    }
}
