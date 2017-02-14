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
		$content = Prod::with('tags', 'category');
		return view('prod.index', ['content' => $content->get()]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function showbytag($tag_id = null)
	{	
		// exit($tag_id);
		DB::enableQueryLog();
		// $content = Tag::whereIn('id', [$tag_id,12])->with('prods')->get();
		$content = Prod::where('id', '>', 0)->with('withTag')->get();
		// foreach ($content as $m) {
		// 	$content = $m->prods;
		// }
		// $content = (new Prod())->withTag()->newQuery()->get(['*']);
		// $content = Prod::with(['tags' => function ($query)
		// {
		// 	$query->where('id', 23)
		// }])->get();
		echo "<pre>";
		dd(DB::getQueryLog());
				exit();
		return view('prod.index', ['content' => $content->get()]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function showbycategory($category_id = null)
	{	
		$content = Prod::with('tags', 'category')->where('category_id', '=', $category_id);
		return view('prod.index', ['content' => $content->get()]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id = null)
	{
		$category_array = Category::all()->pluck('name', 'id');
		return view('prod.create', ['category_array' => $category_array]);
	}

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
		    'category_id' => 'exists:categories,id'
		], [
			'required' => 'Este campo es obligatorio!',
			'numeric' => 'Este campo tiene que ser numerico'
		]);


		// dd($request);
		$prod = new Prod([
			'user_id' => 1,
			'name' => Request::get('name'),
			'file' => '',
			'details' => Request::get('details'),
			'price' => Request::get('price'),
			'inv' => Request::get('inv'),
			'category_id' => Request::get('category_id')
		]);


		$prod->save();
		$ext = $request->file('file')->getClientOriginalExtension();
		$imageName = $prod->id . '_' . time() . '_' . $prod->user_id . '.' . $ext;
		Request::file('file')->move(base_path() . '/public/images/catalog', $imageName);
        $prod->file = $imageName;
        $tag_array = explode(",", Request::get('tags'));
        
        foreach ($tag_array as $tag_name) {
        	$tag_name = ucfirst(strtolower(trim($tag_name)));
	        $tag = Tag::firstOrCreate(['name' => $tag_name]);
	        $prod->tags()->attach($tag->id);
        }

		$prod->save();

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