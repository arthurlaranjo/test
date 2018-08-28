<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'customer_id', 'user_id'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    
}
