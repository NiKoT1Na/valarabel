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
		$find = Tag::find($tag_id);	
		if ($find === null) {
			abort(404, 'el tag seleccionado no existe');
		}
		$content = $find->prods;
		return view('prod.index', ['content' => $content]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function showbycategory($category_id = null)
	{	
		if (Category::find($category_id) === null) {
			abort(404, 'la categoria seleccionada, no existe');
		}
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
		$arguments = ['category_array' => $category_array];
		if ( $id !== null ) {
			$prod = Prod::find($id);
			$arguments['prod'] = $prod;
		}
		return view('prod.create', $arguments);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(\Illuminate\Http\Request $request, $id = null)
	{
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

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$reviews = Review::all();
		$post = Prod::with('tags', 'category')->find($id);
		return view('prod.show', ['post' => $post, 'reviews' => $reviews]);
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
	public function update(\Illuminate\Http\Request $request, $id)
	{
		// va la validacion de update $_POST
		// Request::
		return $this->store($request, $id);
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