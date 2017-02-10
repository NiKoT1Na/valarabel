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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', 'ProdController');



// Route::get('valerie', 'ProdController@index');

// Auth::routes();

// Route::get('/home', 'HomeController@index');

// //index
// // Route::resource('/prod', 'ProdController');

// Route::get('/vale', function() {

// 	echo "sisas parce";
// });
