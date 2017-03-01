<?php

/*

tabla ventas id aleatorio.
columna con el Id de los productos que se compraron quemada
cuanto costo en el momento
(un codigo = id para hacer la consignacion a la cuenta. para la venta precio anyway)
carrito de compras, checkout, codigo de compras cuenta bancaria quemada.

direccion a donde va a llegar
telefono



*/

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;
// use Illuminate\Auth\Middleware\Authenticate;

use App\Prod;
use App\Category;
use App\Tag;
use App\Review;
use App\Images;


class ProdController extends Controller
 {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{	
		$content = Prod::with('tags', 'category')->paginate(3);
		$tags = Tag::all();
		$categories = Category::all();
    // The current user can update the post...
		
		return view('prod.index', 
			['content' => $content, 'tags' => $tags, 'categories' => $categories]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function tags($tag_id = null)
	{	
		$find = Tag::find($tag_id);	
		if ($find === null) {
			abort(404, 'el tag seleccionado no existe');
		}
		$content = $find->prods;
		return view('prod.index', ['content' => $content]);
	}

	public function filter() {
		$tags = Request::route('tag');
		if (empty($tags)) {
			$tags = Request::get('tag');
		}

		if ($tags && !is_array($tags)) {
			$tags = [$tags];
		}
		
		$category_id = Request::route('category');
		if (empty($category_id)) {
			$category_id = Request::get('category_id');
		}

		if ($tags) {
			$result = Tag::whereIn('id', $tags)->get();
			$result = $result->map(function ($tag, $key){
				return $tag->prods()->with('tags', 'category')->get();
			})->flatten(1)->unique('id');


			// // map (...)
			// $result = [];
			// foreach ($result as $key => $tag) {
			// 	$result[$key] = $tag->prods;
			// }
			// // flatten(1)
			// $result_2 = [];
			// foreach ($result as $key => $r) {
			// 	if (is_array($r)) {
			// 		$result_2 = array_merge($result_2, $r);
			// 	} else {
			// 		array_push($result_2, $r);
			// 	}
			// }
			// // unique('id')
			// $result_3 = [];
			// $ids = [];
			// foreach ($result as $key => $r) {
			// 	if (!$ids[$r['id']]) {
			// 		array_push($result_3, $r);
			// 	}
			// }

			if ($category_id) {
				$result = $result->where('category_id', $category_id);
			}

		} else if ($category_id) {
			$result = Prod::where('category_id', '=', $category_id)->with('tags', 'category')->get();
		}
			$category_name = false;
			if(isset($category_id)) { 
				$category_name = (Category::find($category_id)->name);
			}
		$categories = Category::all();

		return view('prod.index', ['content' => $result, 'tags' => Tag::all(), 'category' => $category_name, 'categories' => $categories] );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id = null)
	{
		

		if (isAdmin()) {
			$category_array = Category::all()->pluck('name', 'id');
			$arguments = ['category_array' => $category_array];
			if ( $id !== null ) {
				$prod = Prod::find($id);
				$arguments['prod'] = $prod;
			}
			return view('prod.create', $arguments);
		}
		abort(404, 'Debes estar logeado y ser administrador para subir tus productos');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(\Illuminate\Http\Request $request, $id = null)
	{
		if (isAdmin()) {
			$model = Prod::findOrNew($id);			

			$rules = [
			    'name' => 'required',
			    'images.0' => 'image|required',
			    'images.*' => 'image',
			    'details' => 'required',
			    'price' => 'required|numeric',
			    'inv' => 'required|numeric',
			    'tags' => 'required',
			    'category_id' => 'exists:categories,id'	   
			];
			$prod = [
				'user_id' => Auth::id(),
				'name' => Request::get('name'),
				'file' => '',
				'details' => Request::get('details'),
				'price' => Request::get('price'),
				'inv' => Request::get('inv'),
				'category_id' => Request::get('category_id')
			];
			if ($id !== null && !$request->hasFile('file')) {
				unset($rules['file']);
				unset($prod['file']);
			}
			$this->validate($request, $rules, [
				'required' => 'Este campo es obligatorio!',
				'numeric' => 'Este campo tiene que ser numerico', 
				'image' => 'Este archivo no es una imagen valida'
			]);

			$model->fill($prod);
			$model->save();
			// if ($request->hasFile('file')) {
			// 	if ($model->file) {
			// 		unlink(base_path() . '/public/images/catalog/' . $model->file);
			// 	}
			$files = Request::file('images');
			$allImages = [];
			foreach ($files as $key => $file) {
				\PC::debug($file);
				$ext = $file->getClientOriginalExtension();
				$imageName = $model->id . '_' . time() . '_' . $model->user_id . '_' . $key . '.' . $ext;
				$file->move(base_path() . '/public/images/catalog', $imageName);
				$allImages[] = $imageName;

			}
			$model->file = json_encode($allImages);
	        // }
	        $tag_array = explode(",", Request::get('tags'));
	        
	        foreach ($tag_array as $tag_name) {
	        	$tag_name = mb_ucfirst(mb_strtolower(trim($tag_name)));
		        $tag = Tag::firstOrCreate(['name' => $tag_name]);
		        $model->tags()->attach($tag->id);
	        }

			$model->save();

			return redirect()->route('products.show', ['id' => $model->id])->with('status', 'Exito creando!');
		}
		abort(404, 'Debes estar logeado, para subir tus productos');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$prod_with_reviews = Prod::with('reviews')->find($id);
		$reviews = $prod_with_reviews->reviews;
		$rating = $reviews->avg('rating');
		$star = prodStar($id);

		$post = Prod::with('tags', 'category')->find($id);
		return view('prod.show', ['post' => $post, 'reviews' => $reviews, 'rating' => $rating, 'star' => $star]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (isAdmin()) {
			return $this->create($id);
		}
		abort(404, 'Debes estar logeado, para editar tus productos');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(\Illuminate\Http\Request $request, $id)
	{
		// va la validacion de update $_POST
		// Request::
		if (isAdmin()) {

			return $this->store($request, $id);			
		}
		abort(404, 'Debes estar logeado, para editar tus productos');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (isAdmin()) {
			$post_to_delete = Prod::find($id);
			unlink(base_path() . '/public/images/catalog/'.$post_to_delete->file);
			$post_to_delete->delete();

			return redirect()->route('products.index')->with('status', 'Borrado con Exito!!');
		}
	}
	// CRUD
	// Create, Read, Update, Delete
 
}