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
use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\Auth\Middleware\Authenticate;

use App\Prod;
use App\Category;
use App\Tag;
use App\Review;
use App\Images;


class ProdController extends Controller
 {

	protected $perPage = 3;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{	
		return $this->filter();
	}

	private function getNonEmptyCategories() {
		return Category::withCount('Prods')->get()->where('prods_count', '>', 0);
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
		
		$tags = Request::get('tag') ?: Request::route('tag');

		$category_id = Request::route('category') ?: Request::get('category');

		$minPrice = Request::input('minprice') ?: 0;
		$maxPrice = Request::input('maxprice') ?: PHP_INT_MAX;

		$query = Prod::with('tags', 'category');

		if ($category_id) {
			$query = $query->where('category_id', $category_id);
		}

		if ($tags) {
			if (!is_array($tags)) {
				$tags = [$tags];
			}
			$query->whereHas('tags', function ($subquery) use ($tags) {
				$subquery->whereIn('id', $tags);
			});
		}

		if (Request::has('minprice') || Request::has('maxprice')) {
			$query = $query->where([
				['price', '>', intval($minPrice)],
				['price', '<=', intval($maxPrice)]
			]);
		}

		$result = $query->with('tags', 'category')->paginate($this->perPage);

		$params = [
			'content' => $result,
			'tags' => Tag::all(),
			'categories' => $this->getNonEmptyCategories()
		];

		if(!empty($category_id)) { 
			$params['category'] = Category::find($category_id)->name;
		}

		return view('prod.index', $params);
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
	public function store(\Illuminate\Http\Request $request, Number $id = null)
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

			$files = Request::file('images');
			$allImages = [];
			foreach ($files as $key => $file) {
				$ext = $file->getClientOriginalExtension();
				$imageName = $model->id . '_' . time() . '_' . $model->user_id . '_' . $key . '.' . $ext;
				$file->move(base_path() . '/public/images/catalog', $imageName);
				$allImages[] = $imageName;
			}

			$model->file = json_encode($allImages);

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
		$pendingApproval = (bool)$prod_with_reviews->reviews->where('user_id', Auth::id())->count();
		$reviews = $prod_with_reviews->reviews;
		$rating = $reviews->where('aproved', 1)->avg('rating');
		$star = prodStar($id);

		$post = Prod::with('tags', 'category')->find($id);
		return view('prod.show', ['post' => $post, 'reviews' => $reviews, 'rating' => $rating, 'star' => $star, 'pendingApproval' => $pendingApproval]);
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
			unlink(base_path() . '/public/images/catalog/' . $post_to_delete->file);
			$post_to_delete->delete();
			return redirect()->route('products.index')->with('status', 'Borrado con Exito!!');
		}
	}
	// CRUD
	// Create, Read, Update, Delete
 
}