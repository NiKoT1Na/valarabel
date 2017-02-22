<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;

class CarritoController extends Controller
{
    public function compras() {

    	if (Auth::user()) {
    		return view('Prod.carrito');
    	} else {
    		abort(404, 'Debes estar logeado para ver tu carrito de compras');
    	}
    }

    public function addShop() {

    	if (!empty($cart)) {
    		array_push($cart, Session::flash('cart'));
    	} else {
    		$cart = Session::flash('cart');
    	}
	    
	    // return back()->with('status', 'creado!');
	    echo "<pre>";
	    print_r($cart);
	    exit();
    }
}
