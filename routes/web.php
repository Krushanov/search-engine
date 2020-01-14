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

use App\Http\Controllers\IndexController;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    return view('welcome');
});

// Route::post('search', 'SearchController@index');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('file_index', function () {
    	echo 'Обработка. Пожалуйста, подождите...';
    	flush();
    	ob_flush();
    	$index_controller = new IndexController();
    	$index_controller->create_index_file();
    	return redirect()->back();
	});
});


Route::get('/{search_text}', 'SearchController@index');