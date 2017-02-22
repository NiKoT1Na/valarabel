<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'ventas';
	protected $fillable = ['id', 'products', 'price', 'telephone', 'adress'];
}
