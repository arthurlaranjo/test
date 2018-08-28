<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'cnpj', 'phone', 'mobile', 'email'
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'product_suppliers');
    }

    public function pedidos() {
        return $this->hasMany(ProductSupplier::class);
    }
}
