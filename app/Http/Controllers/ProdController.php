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

use App\Prod;
use App\Category;
use App\Tag;

class ProdController extends Controller
 {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// index
		// /productos
		// la lista completa de productos paginada
		//$content = DB::table('prod')->get();

		$content = Prod::all();
		// $tags = DB::table('prod')->leftJoin('prod_tags', 'prod_id', '=', 'id')->leftJoin('tags', 'tag_id', '=', 'tags.ID')->where('prod_tags.prod_id', '=', 'prod.id')
		// ->get();
		// ->select('prod.name', 'prod.id', 'tags.ID')
		// where('prod_id', '=', 'prod_tags')
		// $category = DB::table('categories')->leftJoin('prod_categories');

		return view('prod.index', ['content' => $content]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id = null)
	{
		// vista del formulario para crear un producto
		$categories = Category::all();

		$category_array = [];
	
		foreach ($categories as $category) {
			$id = $category['id'];
			$category_array[$id] = $category['name'];       	
		}
		 return view('prod.create', ['category_array' => $category_array]);
	}

	// github (git) -> codigo
	// codigo =/ data {esquema, squeme}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(\Illuminate\Http\Request $request, $id = null)
	{
		$this->validate($request, [
		    'name' => 'required',
		    'file' => 'required|image',
		    'details' => 'required',
		    'price' => 'required|numeric',
		    'inv' => 'required|numeric',
		    'tags' => 'required',
		], [
			'required' => 'Este campo es obligatorio!',
			'numeric' => 'Este campo tiene que ser numerico'
		]);

		// dd($request);
		$prod = new Prod();
		$prod->user_id = 1;
		$prod->name = Request::get('name');
		//json_decode($prod->file);
		$prod->file = "";
		$prod->details = Request::get('details');
		$prod->price = Request::get('price');
		$prod->inv = Request::get('inv');
		$prod->category_id = Request::get('categories');
		$prod->save();
		$imageName = $prod->id . '_' . time() . '_' . $prod->user_id . '.' . $request->file('file')->getClientOriginalExtension();
		Request::file('file')->move(base_path() . '/public/images/catalog', $imageName);
        $prod->file = $imageName ;
        $tag_array = explode(",", Request::get('tags'));
        
        foreach ($tag_array as $tag_name) {

        	$tag_name = trim($tag_name);
        	$tag_name = strtolower($tag_name);
        	$tag_name = ucfirst($tag_name);

	        $tag = new Tag();       	
	        $tag->name = $tag_name;
	        $tag->save();
	        $prod->tags()->attach($tag->id);
        }

        // $category = new Category();
        // $category->

		$prod->save();


		 // Request::all();
		 // save();
		// ["name" => "required|min:32|max:100"]
		// validacion para un nuevo producto (procedente de productos.create)
		// guarda en la db
		// la vista con el mensjae de exito, o devolverse con los errors (view("sdf")->withErrors($array))
		// products/1231

		return redirect()->route('products.show', ['id' => $prod->id])->with('status', 'Exito creando!');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// intentar coger el post con ese id de la db
		// y si falla retornar 404 view(404)
		// y si view("productos.show")->with('product' => $producto) // productos/show.blade.php

		$post = DB::table('prod')->find($id);

		return view('prod.show', ['post' => $post]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// va el formulario de edicion
		return $this->create($id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// va la validacion de update $_POST
		// Request::
		return $this->store($id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// donde veriva que si se puede borrar y lo borrar, 
		// devuelve un mensaje diciendo si se pudo borrar o no
	}
	// CRUD
	// Create, Read, Update, Delete
 
}