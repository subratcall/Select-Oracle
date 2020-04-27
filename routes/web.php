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
    return view('index');
})->middleware('CheckLogin');

Route::get('/test', function () {
    return view('test');
});

Route::get('/testnewnav', function () {
    return view('welcome');
});

Route::get('/postgre','BACKOFFICE\PostgreController@index');

Route::get('/select-oracle/login','SelectOracleController@index');
Route::post('/select-oracle/login','SelectOracleController@login');
Route::get('/select-oracle/logout','SelectOracleController@logout');
Route::get('/select-oracle/index','SelectOracleController@index');
Route::post('/select-oracle/execute','SelectOracleController@execute');
Route::post('/select-oracle/getColumnList','SelectOracleController@getColumnList');
