<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\AuthController@login')->name('api_login');
Route::post('register', 'API\AuthController@store')->name('api_register');
Route::middleware('auth:api')->group(function () {
  Route::post('update', 'API\AuthController@update')->name('api_update');
  Route::get('/user/list', 'API\AuthController@index');

  Route::get('/category/list', 'API\CategoryController@index');
  Route::get('/subcategory/list', 'API\SubcategoryController@index');
});

Route::group(['prefix' => 'user', 'middleware' => ['auth:api']], function () {

  Route::group(['prefix' => 'product'], function () {
    Route::post('/save', 'API\ProductController@store')->name('api_save_new_product');
    Route::post('/list', 'API\ProductController@index')->name('api_list_product');
    Route::post('/update/{product_id}', 'API\ProductController@update')->name('api_update_product');
    Route::get('/delete/{product_id}', 'API\ProductController@destroy');
    Route::get('/like/{product_id}', 'API\ProductController@like');
    Route::get('/unlike/{product_id}', 'API\ProductController@unlike');
    Route::get('/find/{findable}', 'API\ProductController@find');
    Route::get('/report/{product_id}', 'API\ProductController@report');
    Route::get('/disable/{product_id}', 'API\ProductController@disable');
  });

  Route::group(['prefix' => 'category'], function () {
    Route::get('/list', 'API\CategoryController@index');
  });

  Route::group(['prefix' => 'subcategory'], function () {
    Route::get('/list', 'API\CategoryController@index');
  });

  Route::group(['prefix' => 'tags'], function () {
    Route::get('/list', 'API\TagController@index');
  });

  Route::group(['prefix' => 'amenity'], function () {
    Route::get('/list', 'API\AmenitiesController@index');
  });

  Route::group(['prefix' => 'specification'], function () {
    Route::get('/list', 'API\SpecificationController@index');
  });

  Route::group(['prefix' => 'state'], function () {
    Route::get('/find/{findable}', 'API\StateController@find_state')->name('api_find_state');
  });

  Route::group(['prefix' => 'city'], function () {
    Route::get('/list', 'API\CityController@index');
    Route::get('/list_for/{state_code}', 'API\CityController@list_city_for_state_code')->name('api_list_city_for_state_code');
    Route::get('/find/{findable}/in/{state_code}', 'API\CityController@find_city_in_state')->name('api_find_city_in_state');
  });
});
Route::post('/product/find/', 'API\ProductController@find');
Route::get('/state/list', 'API\StateController@index');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'is_admin']], function () {
  Route::group(['prefix' => 'user'], function () {
    Route::get('/user/list', 'API\AuthController@index');
  });

  Route::group(['prefix' => 'product'], function () {
    Route::post('/new', 'API\ProductController@store');
    Route::get('/list', 'API\ProductController@index');
    Route::post('/update/{product_id}', 'API\ProductController@update');
    Route::get('/delete/{product_id}', 'API\ProductController@destroy');
    Route::get('/find/{findable}', 'API\ProductController@find');
    Route::get('/report/{product_id}', 'API\ProductController@report');
    Route::get('/activate/{product_id}', 'API\ProductController@activate');
    Route::get('/disable/{product_id}', 'API\ProductController@disable');
  });

  Route::group(['prefix' => 'category'], function () {
    Route::post('/new', 'API\CategoryController@store');
    Route::get('/list', 'API\CategoryController@index');
    Route::post('/update/{category_id}', 'API\CategoryController@update');
    Route::get('/delete/{category_id}', 'API\CategoryController@destroy');
  });

  Route::group(['prefix' => 'subcategory'], function () {
    Route::post('/new', 'API\CategoryController@store');
    Route::get('/list', 'API\CategoryController@index');
    Route::post('/update/{subcategory_id}', 'API\CategoryController@update');
    Route::get('/delete/{subcategory_id}', 'API\CategoryController@destroy');
  });

  Route::group(['prefix' => 'tags'], function () {
    Route::get('/list', 'API\TagController@index');
    Route::post('/update/{tag_id}', 'API\TagController@update');
    Route::get('/delete/{tag_id}', 'API\TagController@destroy');
  });

  Route::group(['prefix' => 'amenity'], function () {
    Route::get('/list', 'API\AmenitiesController@index');
    Route::post('/update/{tag_id}', 'API\AmenitiesController@update');
    Route::get('/delete/{tag_id}', 'API\AmenitiesController@destroy');
  });

  Route::group(['prefix' => 'specification'], function () {
    Route::get('/list', 'API\SpecificationController@index');
    Route::post('/update/{tag_id}', 'API\SpecificationController@update');
    Route::get('/delete/{tag_id}', 'API\SpecificationController@destroy');
  });
});
