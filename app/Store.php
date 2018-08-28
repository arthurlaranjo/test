<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Store extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'cnpj', 'name', 'trade_name', 'ie', 'address', 'number', 'district', 'city',
      'state', 'phone', 'mobile_phone', 'observation', 'interest', 'cep'
    ];
}
