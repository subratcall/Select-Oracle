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

Route::middleware(['CheckLogin'])->group(function () {
    Route::get('/select-oracle/logout', 'SelectOracleController@logout');
    Route::get('/select-oracle/index', 'SelectOracleController@index');
    Route::post('/select-oracle/execute', 'SelectOracleController@execute');
    Route::post('/select-oracle/getColumnList', 'SelectOracleController@getColumnList');
});

Route::get('/password-generator/login', function(){
    return view('PasswordGeneratorLogin');
});
Route::post('/password-generator/login','PasswordGeneratorController@login');
Route::get('/password-generator/logout','PasswordGeneratorController@logout');

Route::get('/password-generator/index', 'PasswordGeneratorController@index');
Route::post('/password-generator/generate', 'PasswordGeneratorController@generate');
Route::get('/password-generator/report',function(){
    session_start();
    return view('PasswordGeneratorReport');
});
Route::get('/password-generator/show-report','PasswordGeneratorController@report');
