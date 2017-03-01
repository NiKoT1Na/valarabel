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

		if (Auth::user()) {
			return view('prod.carrito', ['content' => $content, 'stars' => $stars]);
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
		// $rules['amount.0'] = 'max:30';
		$ids = Request::session()->get('cart', []);
		$prods = Prod::findOrFail($ids);
		$amount = Request::get('amount');

		$rules = [
			'price' => 'required|array',
			'telephone' => 'required',
			'adress' => 'required',
			'notes' => 'required',
		];

		foreach($prods as $key => $prod) {
			$rules['amount.' . $key] = 'required|numeric|min:1|max:' . $prod->inv;
		}

		$this->validate($request, $rules, [
			'required' => 'Este campo es obligatorio!',
			'numeric' => 'Este campo tiene que ser numerico'
		]);

		if (count($ids) !== count($amount)) {
			abort(403, 'el numero de productos no coincide con el numero de cantidades');
		}

		$totalPrices = 0;
		foreach ($prods as $key => $one_prod) {
			$totalPrices += $one_prod->price * $amount[$key];
		}

		$model = new Carrito([
			'id' => Auth::id() . time(),
			'user_id' => Auth::id(),
			'products' => json_encode(Request::session()->get('cart', [])),
			'price' => json_encode($totalPrices),
			'telephone' => Request::get('telephone'),
			'adress' => Request::get('adress'),
			'amount' => json_encode(array_map('intval', $amount)),
			'notes' => Request::get('notes'),
		]);

		$model->save();
		Request::session()->forget('cart');
		return redirect()->route('products.index');
	}
}
