<?php

/*

pagina de vistas con 4 productos x fila
ver cada product con 4 fotos
fotos clickeables pa q se agranden
parecido a http://www.tous.com/

formulaio nuevo producto. medio cuco
y si algo editar xD!!!
pre-llenado-
	(populado)
	hidden -> ID 

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


class ProdController extends Controller
 {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{	
		$content = Prod::with('tags', 'category')->get();
		$tags = Tag::all();
		$categories = Category::all();
    // The current user can update the post...
		
			return view('prod.index', ['content' => $content, 'tags' => $tags, 'categories' => $categories]);
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
			    'file' => 'required|image',
			    'details' => 'required',
			    'price' => 'required|numeric',
			    'inv' => 'required|numeric',
			    'tags' => 'required',
			    'category_id' => 'exists:categories,id'	   
			];
			$prod = [
				'user_id' => 1,
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
				'numeric' => 'Este campo tiene que ser numerico'
			]);

			$model->fill($prod);
			$model->save();
			if ($request->hasFile('file')) {
				if ($model->file) {
					unlink(base_path() . '/public/images/catalog/' . $model->file);
				}
				$ext = $request->file('file')->getClientOriginalExtension();
				$imageName = $model->id . '_' . time() . '_' . $model->user_id . '.' . $ext;
				Request::file('file')->move(base_path() . '/public/images/catalog', $imageName);
		        $model->file = $imageName;
	        }
	        $tag_array = explode(",", Request::get('tags'));
	        
	        foreach ($tag_array as $tag_name) {
	        	$tag_name = ucfirst(strtolower(trim($tag_name)));
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
		$rating = $prod_with_reviews->reviews->avg('rating');
		$reviews = $prod_with_reviews->reviews;
		
		function star($rating) {
			$num = floor($rating * 2);
			$file_name = $num . 'est.png';
			return "/body/$file_name";
		}
		$star = star($rating);
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