<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Prod;
use App\Review;

class ReviewController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
	   abort(404, "");
	}

	public function newreview(\Illuminate\Http\Request $request, $prod_id)
	{
		if (Auth::check()) {
			$fill = [
				'user_id' => Auth::id(),
				'prod_id' => $prod_id,
				'name' => Request::get('name'),
				'details' => Request::get('details'),
				'rating' => Request::get('rating'),
				'aproved' => 0,
			];
			$rules = [
				'name' => 'required',
				'details' => 'required',
				'rating' => 'required|numeric|min:1|max:5',
			];

			$this->validate($request, $rules);
			$review = new Review($fill);
			$review->save();

			return back()->with('status', 'creado!');
		}
		abort(404, 'Debes estar logeado, para hacer una reseña');
		
	}

	public function aproved(\Illuminate\Http\Request $request)
	{
		if (isAdmin()) {
			// return $this->newreview()
			$review_id = Request::get('review_id');
			$review = Review::find($review_id);
			$review->aproved = 1;
			$review->save();

			return back()->with('status', 'aprobado!');		
		}
	}
	
	public function denied()
	{
		if (isAdmin()) {
			$id = Request::get('review_id');		
			$to_delete = Review::find($id);
			$to_delete->delete();

			return back()->with('status', 'BORRADO!');	
		}  else {
			abort(404, 'debes ser admin para estar aca');
		}
	}
}
