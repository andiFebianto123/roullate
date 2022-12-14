<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'namespace' => 'App\Http\Controllers'
], function(){
    Route::get('/', 'RoulatteController@index');
    Route::get('/get_data', 'RoulatteController@getData')->name('showdata');
    Route::post('reduce-stock', 'RoulatteController@reduceStock');
});

