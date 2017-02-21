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

Route::post('reviews/{prod_id}', 'ReviewController@newreview');

