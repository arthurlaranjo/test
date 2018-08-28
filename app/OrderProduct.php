<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id', 'quantity', 'order_id'
    ];

    public function product() {
        return $this->belontsTo(Product::class);
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
    
}
