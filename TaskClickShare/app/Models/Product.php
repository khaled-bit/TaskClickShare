<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $fillable = ['product_name', 'description', 'country', 'product_code'];

    public function values()
    {
        return $this->hasMany(ProductValue::class);
    }

}
