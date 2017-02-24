<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'ventas';
	protected $fillable = ['id', 'user_id',  'products', 'price', 'telephone', 'adress', 'amount', 'notes'];
}
