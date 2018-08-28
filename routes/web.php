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
    return view('welcome');
})->name('index');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/logout', ['as' => 'logout', 'uses' => 'API\UsersController@logout']);

Route::group(['prefix' => '/api', 'as' => 'api.', 'middleware' => 'auth'], function() {

    Route::group(['prefix' => '/users', 'as' => 'users.'], function() {
        Route::get('/current', ['as' => 'current', 'uses' => 'API\UsersController@current']);
        Route::get('/', ['as' => 'index', 'uses' => 'API\UsersController@index']);
        Route::get('/{id}', ['uses' => 'API\UsersController@show']);
        Route::post('/update', ['as' => 'update', 'uses' => 'API\UsersController@update']);
        Route::post('/password', ['as' => 'password', 'uses' => 'API\UsersController@changePassword']);
        Route::get('/endereco/{cep}', ['as' => 'endereco', 'uses' => 'API\UsersController@endereco']);
         Route::post('/store', ['as' => 'store', 'uses' => 'API\UsersController@store']);
        Route::get('/{id}/deactivate', ['uses' => 'API\UsersController@deactivate']);
        Route::get('/{id}/reactivate', ['uses' => 'API\UsersController@reactivate']);
    });

    Route::group(['prefix' => '/suppliers', 'as' => 'suppliers.'], function() {
        Route::get('/', ['uses' => 'API\SuppliersController@index']);
        Route::get('/{id}', ['uses' => 'API\SuppliersController@show']);
        Route::post('/update', ['as' => 'update', 'uses' => 'API\SuppliersController@update']);
        Route::post('/store', ['as' => 'store', 'uses' => 'API\SuppliersController@store']);
        Route::get('/{id}/deactivate', ['uses' => 'API\SuppliersController@deactivate']);
        Route::get('/{id}/reactivate', ['uses' => 'API\SuppliersController@reactivate']);
    });

    Route::group(['prefix' => '/products', 'as' => 'products.'], function() {
        Route::get('/', ['uses' => 'API\ProductsController@index']);
        Route::get('/{id}', ['uses' => 'API\ProductsController@show']);
        Route::post('/update', ['as' => 'update', 'uses' => 'API\ProductsController@update']);
        Route::post('/store', ['as' => 'store', 'uses' => 'API\ProductsController@store']);
        Route::post('/checkout', ['as' => 'checkout', 'uses' => 'API\ProductsController@checkout']);
        Route::get('/{id}/deactivate', ['uses' => 'API\ProductsController@deactivate']);
        Route::get('/{id}/reactivate', ['uses' => 'API\ProductsController@reactivate']);
    });

    Route::group(['prefix' => '/customers', 'as' => 'customers.'], function(){
        Route::get('/', ['uses' => 'API\CustomersController@index']);
        Route::get('/{id}/deactivate', ['uses' => 'API\CustomersController@deactivate']);
        Route::get('/{id}/reactivate', ['uses' => 'API\CustomersController@reactivate']);
        Route::post('/store', ['as' => 'store', 'uses' => 'API\CustomersController@store']);
        Route::post('/update', ['as' => 'update', 'uses' => 'API\CustomersController@update']);
        Route::get('/month-birthdays', ['uses' => 'API\CustomersController@monthBirthdays']);
        Route::get('/{id}', ['uses' => 'API\CustomersController@show']);
    });

});

Route::get('/{any}', 'HomeController@index')->where('any', '.*');
