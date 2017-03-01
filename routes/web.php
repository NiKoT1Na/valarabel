<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::Auth();

Route::resource('products', 'ProdController');

Route::get('tag/{tag}', ['uses' => 'ProdController@filter', 'as' => 'tag']);

Route::get('category/{category}', ['uses' => 'ProdController@filter', 'as' => 'category']);

Route::get('tag/{tag}/category/{category}', ['uses' => 'ProdController@filter', 'as' => 'filter']);

Route::post('filter', ['uses' => 'ProdController@filter', 'as' => 'post_filter']);

Route::post('reviews/{prod_id}', ['uses' => 'ReviewController@newreview', 'as' => 'newreview']);

Route::get('dashboard/{id}', 'DashController@administrate');

Route::get('tags', 'ProdController@tags');

Route::get('carrito', 'CarritoController@compras');

Route::post('added_product', ['uses' => 'CarritoController@addShop', 'as' => 'shopping_cart']);

Route::post('comprar', ['uses' => 'CarritoController@shop', 'as' => 'shopping']);

Route::post('apr_review', ['uses' => 'ReviewController@aproved', 'as' => 'aproved']);
Route::post('den_review', ['uses' => 'ReviewController@denied', 'as' => 'denied']);

