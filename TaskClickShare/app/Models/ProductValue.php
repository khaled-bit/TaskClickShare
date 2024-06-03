<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductValue extends Model
{
    protected $fillable = ['country_id', 'attribute_id','product_id','value'];
    protected $with = ['product', 'attribute'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

}
