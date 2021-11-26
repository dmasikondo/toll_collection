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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/vehicles', 'VehicleController@index');
Route::get('vehicles/registration', 'VehicleController@registration');
Route::get('/vehicles/create', 'VehicleController@create');
Route::get('/vehicles/encrypt', 'VehicleController@myEncryption');
Route::get('/vehicles/decrypt', 'VehicleController@decrypt');
Route::get('/vehicles/{vehicle:slug}', 'VehicleController@show');
Route::post('/vehicles/', 'VehicleController@store');
Route::get('/owners/{owner:slug}', 'OwnerController@show');
Route::get('/owners', function(){
		return App\Owner::all();
});


Route::get('/contacts','ContactController@show');
Route::post('/contacts','ContactController@store');
Route::get('/uid-tags','UidTagsController@index');

