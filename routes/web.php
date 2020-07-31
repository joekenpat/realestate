<?php

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

Route::get('/property/view/{property_id}', 'PropertyController@show')->name('view_property');
Route::get('/', ['uses' => 'HomeController@homepage'])->name('home');
Route::get('/property_list', 'PropertyController@index')->name('property_listing');
Route::get('/payment/callback', 'PropertyController@handleGatewayCallback')->name('payment_callback');

Route::group(['prefix' => 'user', 'middleware' => ['auth']], function () {
  Route::get('/property', 'PropertyController@user_index')->name('user_list_property');
  Route::get('/profile/edit', 'HomeController@edit')->name('edit_profile');
  Route::get('/property/create', 'PropertyController@create')->name('user_create_property');
  Route::get('/property/edit/{property_id}', 'PropertyController@edit')->name('user_edit_property');
  Route::get('/property/report/{property_id}', 'PropertyController@report')->name('report_property');
  Route::post('/property/report/new/{property_id}', 'PropertyController@file_property_report')->name('file_property_report');
});



Route::get('/admin/overview', 'AdminController@overview')->name('admin_overview');
Route::get('/admin/property/all', 'AdminController@all_properties')->name('admin_all_properties');
Route::get('/admin/property/active', 'AdminController@active_properties')->name('admin_active_properties');
Route::get('/admin/property/pending', 'AdminController@pending_properties')->name('admin_pending_properties');
Route::get('/admin/property/expired', 'AdminController@expired_properties')->name('admin_expired_properties');
Route::get('/admin/property/reported', 'AdminController@reported_properties')->name('admin_reported_properties');
Route::get('/admin/property/declined', 'AdminController@declined_properties')->name('admin_declined_properties');
Route::get('/admin/property/closed', 'AdminController@closed_properties')->name('admin_closed_properties');


Route::get('/admin/users/all', 'AdminController@all_users')->name('admin_all_users');
Route::get('/admin/users/verified', 'AdminController@verified_users')->name('admin_verified_users');
Route::get('/admin/users/verify/{user_id}', 'AdminController@verify_user')->name('admin_verify_user');
Route::get('/admin/users/unverify/{user_id}', 'AdminController@unverify_user')->name('admin_unverify_user');
Route::get('/admin/users/unverified', 'AdminController@unverified_users')->name('admin_unverified_users');
Route::get('/admin/users/agent', 'AdminController@agent_users')->name('admin_agent_users');
Route::get('/admin/users/blocked', 'AdminController@blocked_users')->name('admin_blocked_users');
Route::get('/admin/users/block/{user_id}', 'AdminController@block_user')->name('admin_block_user');
Route::get('/admin/users/active', 'AdminController@active_users')->name('admin_active_users');
Route::get('/admin/users/unblock/{user_id}', 'AdminController@unblock_user')->name('admin_unblock_user');
Route::get('/admin/users/reported', 'AdminController@reported_users')->name('admin_reported_users');


Route::get('/admin/category/all', 'AdminController@all_categories')->name('admin_all_categories');
Route::get('/admin/category/new', 'AdminController@new_category')->name('admin_new_category');
Route::post('/admin/category/store', 'AdminController@store_category')->name('admin_store_category');
Route::get('/admin/category/edit/{category_id}', 'AdminController@edit_category')->name('admin_edit_category');
Route::post('/admin/category/update/{category_id}', 'AdminController@update_category')->name('admin_update_category');
Route::get('/admin/category/delete/{category_id}', 'AdminController@delete_category')->name('admin_delete_category');

Route::get('/admin/subcategory/all', 'AdminController@all_subcategories')->name('admin_all_subcategories');
Route::get('/admin/subcategory/new', 'AdminController@new_subcategory')->name('admin_new_subcategory');
Route::post('/admin/subcategory/store', 'AdminController@store_subcategory')->name('admin_store_subcategory');
Route::get('/admin/subcategory/edit/{subcategory_id}', 'AdminController@edit_subcategory')->name('admin_edit_subcategory');
Route::post('/admin/subcategory/update/{subcategory_id}', 'AdminController@update_subcategory')->name('admin_update_subcategory');
Route::get('/admin/subcategory/delete/{subcategory_id}', 'AdminController@delete_subcategory')->name('admin_delete_subcategory');


Route::get('/admin/settings/media', 'AdminController@media_settings')->name('admin_media_settings');
Route::post('/admin/settings/media/home_slider/add', 'AdminController@store_home_slider_image')->name('admin_store_home_slider_image');
Route::get('/admin/settings/media/home_slider/delete/{image_name}', 'AdminController@delete_home_slider_image')->name('admin_delete_home_slider_image');
Route::get('/admin/settings/payment', 'AdminController@payment_settings')->name('admin_payment_settings');
Route::post('/admin/settings/payment/update', 'AdminController@update_payment_settings')->name('admin_update_payment_settings');
Route::get('/admin/settings/property', 'AdminController@property_settings')->name('admin_property_settings');
Route::post('/admin/settings/property/update', 'AdminController@update_property_settings')->name('admin_update_property_settings');

Route::get('/admin/reports/all', 'AdminController@all_reports')->name('admin_all_reports');
Route::get('/admin/reports/pending', 'AdminController@pending_reports')->name('admin_pending_reports');
Route::get('/admin/reports/resolved', 'AdminController@resolved_reports')->name('admin_resolved_reports');
