<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductSupplier extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_id', 'supplier_id', 'value', 'quantity','request_id'
    ];
}
