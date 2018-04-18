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
    
    Route::get('/', ['as'=>'dashboard.index','uses'=>'CategoryController@index']);
    Route::post('/add',['as'=>'dashboard.add','uses'=>'CategoryController@create']);
    Route::post('/edit',['as'=>'dashboard.edit', 'uses'=>'CategoryController@update']);
    Route::get('/{id}/delete',['as'=>'dashboard.delete', 'uses'=>'CategoryController@delete']);
    
    Route::group([
        'prefix' => 'product'], function () {
    
            Route::get('/', function(){
                 return abort(404);
            });
        
            Route::get('{categoryProduct}/view',['as'=>'dashboard.product.view', 'uses'=>'ProductController@view']);
            Route::post('/add',['as'=>'dashboard.product.add', 'uses'=>'ProductController@create']);
            Route::post('/edit',['as'=>'dashboard.product.edit', 'uses'=>'ProductController@update']);
            Route::get('/{id}/delete',['as'=>'dashboard.product.delete', 'uses'=>'ProductController@delete']);
        
    });
    
    Route::group ([
        'prefix'=>'transaction'], function () {
        
        Route::get('/', ['as'=>'dashboard.transaction.index','uses'=>'TransactionController@index']);
        Route::post('/', ['as'=>'dashboard.transaction.add','uses'=>'TransactionController@create']);
        Route::get('/report', ['as'=>'dashboard.transaction.view','uses'=>'TransactionController@view']);
        Route::get('/download',['as'=>'dashboard.transaction.download','uses'=>'TransactionController@download']);
        Route::get('/{id}/printing',['as'=>'dashboard.transaction.print', 'uses'=>'TransactionController@printing']);

        
    }); 
    
    Route::group ([
        'prefix' => 'user'], function () {
        
            Route::get('/',['as'=>'dashboard.user','uses'=>'UserController@index']);
            Route::post('/add',['as'=>'dashboard.user.add', 'uses'=>'UserController@create']);
            Route::post('/edit',['as'=>'dashboard.user.edit', 'uses'=>'UserController@update']);
            Route::get('/profile',['as'=>'dashboard.user.view', 'uses'=>'UserController@view']);
            Route::get('/{id}/delete',['as'=>'dashboard.user.delete', 'uses'=>'UserController@delete']);
       
    }); 
       
});
