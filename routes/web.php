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
    'prefix' => 'dashboard', 'middleware' => 'auth.rscloud'
], function (){
    
    Route::get('/',['as'=>'dashboard.index', 'uses'=>'DashboardController@index']);
    
    Route::group ([
        'prefix' => 'user'], function () {
            Route::get('/',['as'=>'dashboard.user','uses'=>'UserController@index']);
            Route::post('/add',['as'=>'dashboard.user.add', 'uses'=>'UserController@create']);
            Route::post('/edit',['as'=>'dashboard.user.edit', 'uses'=>'UserController@update']);
            Route::get('/profile',['as'=>'dashboard.user.view', 'uses'=>'UserController@view']);
            Route::get('/{id}/delete',['as'=>'dashboard.user.delete', 'uses'=>'UserController@delete']);
        }
    ); 
       
});
