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

Route::get('/', function () {
	// $tables = DB::select('SHOW TABLES');
	// dd($tables);
	// $response =  SoccerAPI::countries()->all();
	// $response = collect($response);
	// dd($response);
	// return YandexTranslate::translate('Hello world', 'en', 'ar');
	// return date('Y-m-d');	
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('countries', 	'StoreDataController@store_countries');
Route::get('leagues', 		'StoreDataController@store_leagues');
Route::get('seasons', 		'StoreDataController@store_seasons');
Route::get('fixtures', 		'StoreDataController@store_fixtures');

