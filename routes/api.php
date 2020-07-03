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

Route::post('login','API\AuthController@login');
Route::post('register','API\AuthController@store');
Route::middleware('auth:api')->group(function(){
  Route::get('/user/list', 'API\AuthController@index');
  Route::post('/product/new', 'API\ProductController@store');
  Route::get('/product/list', 'API\ProductController@index');
  Route::post('/product/update/{id}', 'API\ProductController@update');
  Route::get('/product/remove/{id}', 'API\ProductController@destroy');
  Route::get('/category/list', 'API\CategoryController@index');
  Route::get('/subcategory/list', 'API\SubcategoryController@index');
});
