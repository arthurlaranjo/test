<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'phone', 'mobile', 'birthday', 'cpf', 'facebook', 
        'instagram', 'email', 'address', 'number', 'district', 'city', 
        'state', 'observation', 'cep'
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
