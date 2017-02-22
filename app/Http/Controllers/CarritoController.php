<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;

use App\Prod;
use App\Category;
use App\Tag;
use App\Review;

class CarritoController extends Controller
{
    public function compras() {
    	$allItems = Request::session()->get('cart', []);
    	$content = Prod::with('tags', 'category')->findMany($allItems);
    	// $conector = \PhpConsole\Handler::getInstance();

    	// \PC::debug($content);

    	if (Auth::user()) {
    		return view('prod.carrito', ['content' => $content]);
    	} else {
    		abort(404, 'Debes estar logeado para ver tu carrito de compras');
    	}
    }

    public function addShop() {
    	Request::session()->push('cart', (int)Request::get('cart'));
       
	    return back()->with('status', 'añadido!');
	    
    }

    // public function shop() {

    // }
}
