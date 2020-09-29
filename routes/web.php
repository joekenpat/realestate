<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* Authentication Routes */


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::post('/subscribe', 'SubscriberController@store')->name('property_subscribe');
Route::get('/unsubscribe/{subscriber_id}', 'SubscriberController@store')->middleware('verify_unsubscribe_route')->name('property_unsubscribe');
Route::get('/pricing', 'HomeController@pricing')->name('ad_post_pricing');
Route::get('/property/view/{property_slug}', 'PropertyController@show')->name('view_property');
Route::get('/', ['uses' => 'HomeController@homepage'])->name('home');
Route::get('/property_list', 'PropertyController@index')->name('property_listing');
Route::get('/payment/callback', 'PropertyController@handleGatewayCallback')->name('payment_callback');

Route::group(['prefix' => 'user', 'middleware' => ['auth']], function () {
  Route::get('/property', 'PropertyController@user_index')->name('user_list_property');
  Route::get('/transaction/list', 'TransactionRecordController@user_index')->name('user_list_transaction');
  Route::get('/profile/edit', 'HomeController@edit')->name('edit_profile');
  Route::get('/property/favourite', 'PropertyController@user_favourite_property')->name('user_favourite_property');
  Route::get('/property/user_views', 'PropertyController@user_property_view')->name('user_property_view')->middleware('is_agent');
  Route::get('/property/create', 'PropertyController@create')->name('user_create_property');
  Route::get('/property/edit/{property_slug}', 'PropertyController@edit')->name('user_edit_property');
  Route::get('/property/report/{property_id}', 'PropertyController@report')->name('report_property');
  Route::post('/property/report/new/{property_id}', 'PropertyController@file_property_report')->name('file_property_report');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'is_admin']], function () {

  Route::get('/overview', 'AdminController@overview')->name('admin_overview');

  Route::group(['prefix' => 'property'], function () {
    Route::get('/all', 'AdminController@all_properties')->name('admin_all_properties');
    Route::get('/active', 'AdminController@active_properties')->name('admin_active_properties');
    Route::get('/pending', 'AdminController@pending_properties')->name('admin_pending_properties');
    Route::get('/expired', 'AdminController@expired_properties')->name('admin_expired_properties');
    Route::get('/reported', 'AdminController@reported_properties')->name('admin_reported_properties');
    Route::get('/declined', 'AdminController@declined_properties')->name('admin_declined_properties');
    Route::get('/closed', 'AdminController@closed_properties')->name('admin_closed_properties');
    Route::get('/disabbled', 'AdminController@disabled_properties')->name('admin_disabled_properties');
  });

  Route::group(['prefix' => 'users'], function () {
    Route::get('/all', 'AdminController@all_users')->name('admin_all_users');
    Route::get('/verified', 'AdminController@verified_users')->name('admin_verified_users');
    Route::get('/verify/{user_id}', 'AdminController@verify_user')->name('admin_verify_user');
    Route::get('/unverify/{user_id}', 'AdminController@unverify_user')->name('admin_unverify_user');
    Route::get('/unverified', 'AdminController@unverified_users')->name('admin_unverified_users');
    Route::get('/agent', 'AdminController@agent_users')->name('admin_agent_users');
    Route::get('/blocked', 'AdminController@blocked_users')->name('admin_blocked_users');
    Route::get('/block/{user_id}', 'AdminController@block_user')->name('admin_block_user');
    Route::get('/active', 'AdminController@active_users')->name('admin_active_users');
    Route::get('/unblock/{user_id}', 'AdminController@unblock_user')->name('admin_unblock_user');
    Route::get('/reported', 'AdminController@reported_users')->name('admin_reported_users');
  });

  Route::group(['prefix' => 'category'], function () {
    Route::get('/all', 'AdminController@all_categories')->name('admin_all_categories');
    Route::get('/new', 'AdminController@new_category')->name('admin_new_category');
    Route::post('/store', 'AdminController@store_category')->name('admin_store_category');
    Route::get('/edit/{category_id}', 'AdminController@edit_category')->name('admin_edit_category');
    Route::post('/update/{category_id}', 'AdminController@update_category')->name('admin_update_category');
    Route::get('/delete/{category_id}', 'AdminController@delete_category')->name('admin_delete_category');
  });

  Route::group(['prefix' => 'subcategory'], function () {
    Route::get('/all', 'AdminController@all_subcategories')->name('admin_all_subcategories');
    Route::get('/new', 'AdminController@new_subcategory')->name('admin_new_subcategory');
    Route::post('/store', 'AdminController@store_subcategory')->name('admin_store_subcategory');
    Route::get('/edit/{subcategory_id}', 'AdminController@edit_subcategory')->name('admin_edit_subcategory');
    Route::post('/update/{subcategory_id}', 'AdminController@update_subcategory')->name('admin_update_subcategory');
    Route::get('/delete/{subcategory_id}', 'AdminController@delete_subcategory')->name('admin_delete_subcategory');
  });

  Route::group(['prefix' => 'settings'], function () {
    Route::get('/media', 'AdminController@media_settings')->name('admin_media_settings');
    Route::post('/media/home_slider/add', 'AdminController@store_home_slider_image')->name('admin_store_home_slider_image');
    Route::get('/media/home_slider/delete/{image_name}', 'AdminController@delete_home_slider_image')->name('admin_delete_home_slider_image');
    Route::get('/payment', 'AdminController@payment_settings')->name('admin_payment_settings');
    Route::post('/payment/update', 'AdminController@update_payment_settings')->name('admin_update_payment_settings');
    Route::get('/property', 'AdminController@property_settings')->name('admin_property_settings');
    Route::post('/property/update', 'AdminController@update_property_settings')->name('admin_update_property_settings');
  });

  Route::group(['prefix' => 'reports'], function () {
    Route::get('/all', 'AdminController@all_reports')->name('admin_all_reports');
    Route::get('/pending', 'AdminController@pending_reports')->name('admin_pending_reports');
    Route::get('/resolved', 'AdminController@resolved_reports')->name('admin_resolved_reports');
  });
});
