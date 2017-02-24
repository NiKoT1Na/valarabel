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
use App\Carrito;

class CarritoController extends Controller
{
	public function compras() {
		$allItems = Request::session()->get('cart', []);
		$content = Prod::with('tags', 'category')->findMany($allItems);
		$stars = prodStar($allItems);
		$sum = $content->sum('price');	

		if (Auth::user()) {
			return view('prod.carrito', ['content' => $content, 'stars' => $stars, 'sum' => $sum]);
		} else {
			abort(404, 'Debes estar logeado para ver tu carrito de compras');
		}
	}

	public function addShop() {
		Request::session()->push('cart', (int)Request::get('cart'));
	   
		return back()->with('status', 'añadido!');
		
	}

	public function shop(\Illuminate\Http\Request $request) {
		// exit('principio');
		$model = new Carrito();
		$rules = [
			// 'products' => 'required|array',
			'price' => 'required|array',
			'telephone' => 'required',
			'adress' => 'required',
			'amount' => 'required|array',
			'notes' => 'required',
		];
		$shop = [
			'id' => Auth::id() . time(),
			'user_id' => Auth::id(),
			'products' => json_encode(Request::session()->get('cart', [])),
			'price' => json_encode(array_map('intval' ,Request::get('price'))),
			'telephone' => Request::get('telephone'),
			'adress' => Request::get('adress'),
			'amount' => json_encode(Request::get('amount')),
			'notes' => Request::get('notes'),
		];
		$this->validate($request, $rules, [
			'required' => 'Este campo es obligatorio!',
			'numeric' => 'Este campo tiene que ser numerico'
		]);
		$model->fill($shop);
		$model->save();
		Request::session()->forget('cart');
		return redirect()->route('products.index');
	}
}
