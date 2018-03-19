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

Route::get('/',['as' => 'auth.index', 'uses' => 'AuthController@index']);
Route::post('/', ['as' => 'auth.action', 'uses' => 'AuthController@auth']);
Route::get('/logout',['as'=>'auth.logout', 'uses'=>'AuthController@logout']);

Route::group ([
    'prefix' => 'dashboard',
], function (){
    
    Route::get('/',['as'=>'dashboard.index', 'uses'=>'DashboardController@index']);

    
});
