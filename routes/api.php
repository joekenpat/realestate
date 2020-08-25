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
  Route::get('/report/list', 'API\ReportController@index');
});

Route::group(['prefix' => 'user', 'middleware' => ['auth:api']], function () {
  Route::post('/transaction/list', 'API\PropertyController@user_transaction');
  Route::group(['prefix' => 'property'], function () {
    Route::post('/list', 'API\PropertyController@user_index')->name('api_user_list_property');
    Route::post('/save', 'API\PropertyController@store')->name('api_save_new_property');
    Route::post('/update/{property_id}', 'API\PropertyController@update')->name('api_update_property');
    Route::get('/delete/{property_slug}', 'API\PropertyController@destroy');
    Route::get('/{property_slug}/delete/image/{image_name}', 'API\PropertyController@delete_property_image');
    Route::post('/upgrade', 'API\PropertyController@upgrade_property');
    Route::get('/like/{property_id}', 'API\PropertyController@like');
    Route::get('/unlike/{property_id}', 'API\PropertyController@unlike');
    Route::get('/close/{property_slug}', 'API\PropertyController@userCloseProperty');
    Route::get('/user_view', 'API\PropertyController@user_property_view');
    Route::get('/favourite', 'API\PropertyController@user_favourite_property');
    Route::get('/favourite/add/{property_id}', 'API\PropertyController@add_favourite_property');
    Route::get('/favourite/remove/{property_id}', 'API\PropertyController@remove_favourite_property');
  });
});

Route::group(['prefix' => 'category'], function () {
  Route::get('/list', 'API\CategoryController@index');
});

Route::group(['prefix' => 'subcategory'], function () {
  Route::get('/list', 'API\CategoryController@index');
});

Route::group(['prefix' => 'state'], function () {
  Route::get('/find/{findable}', 'API\StateController@find_state')->name('api_find_state');
  Route::get('/list', 'API\StateController@index')->name('api_list_state');
});

Route::group(['prefix' => 'city'], function () {
  Route::get('/list', 'API\CityController@index');
  Route::get('/list_for/{state_code}', 'API\CityController@list_city_for_state_code')->name('api_list_city_for_state_code');
  Route::get('/find/{findable}/in/{state_code}', 'API\CityController@find_city_in_state')->name('api_find_city_in_state');
});
Route::post('/property/find/', 'API\PropertyController@find');
Route::get('/property/{product_id}/set_status/{status}', 'API\PropertyController@switchProductStatus');
Route::get('/property/list', 'API\PropertyController@index')->name('api_list_property');
Route::get('/state/list', 'API\StateController@index');
