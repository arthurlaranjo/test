<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'size', 'description', 'quantity','code','value',
        'forward_value','installments','interest','unity'
    ];

    public function suppliers(){
        return $this->belongsToMany(Supplier::class, 'product_suppliers');
    }

    public function pedidos() {
        return $this->hasMany(ProductSupplier::class);
    }
}
