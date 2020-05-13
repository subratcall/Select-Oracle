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


Route::get('/select-oracle/login', function(){
    return view('SelectOracleLogin');
});
Route::post('/select-oracle/login', 'SelectOracleController@login');

Route::get('/select-oracle/generate', 'PasswordGeneratorController@index')->middleware('CheckLogin');
Route::post('/select-oracle/generate', 'PasswordGeneratorController@generate')->middleware('CheckLogin');

Route::middleware(['CheckLogin'])->group(function () {
    Route::get('/select-oracle/logout', 'SelectOracleController@logout');
    Route::get('/select-oracle/index', 'SelectOracleController@index');
    Route::post('/select-oracle/execute', 'SelectOracleController@execute');
    Route::post('/select-oracle/getColumnList', 'SelectOracleController@getColumnList');
});
