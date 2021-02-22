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

Route::get('/', function () {
	return view('welcome');
});
	
	
	Route::post('ajax_login_with_cake/login_check', 'AjaxLoginWithCakeController@login_check');
	Route::get('ajax_login_with_cake/login_rap', 'AjaxLoginWithCakeController@login_rap');
	
	// Neko
	Route::get('neko', 'NekoController@index');
	Route::post('neko/ajax_reg', 'NekoController@ajax_reg');
	Route::post('neko/ajax_delete', 'NekoController@ajax_delete');
	Route::post('neko/auto_save', 'NekoController@auto_save');
	Route::post('neko/ajax_pwms', 'NekoController@ajax_pwms');
	Route::get('neko/csv_download', 'NekoController@csv_download');
	Route::post('neko/bulk_reg', 'NekoController@bulk_reg');
	
	// Neko
	Route::get('en_ctg', 'EnCtgController@index');
	Route::post('en_ctg/ajax_reg', 'EnCtgController@ajax_reg');
	Route::post('en_ctg/ajax_delete', 'EnCtgController@ajax_delete');
	Route::post('en_ctg/auto_save', 'EnCtgController@auto_save');
	Route::post('en_ctg/ajax_pwms', 'EnCtgController@ajax_pwms');
	Route::get('en_ctg/csv_download', 'EnCtgController@csv_download');
	Route::post('en_ctg/bulk_reg', 'EnCtgController@bulk_reg');
	
	// UserMng
	Route::get('user_mng', 'UserMngController@index');
	Route::post('user_mng/ajax_reg', 'UserMngController@ajax_reg');
	Route::post('user_mng/ajax_delete', 'UserMngController@ajax_delete');
	Route::post('user_mng/auto_save', 'UserMngController@auto_save');
	Route::post('user_mng/ajax_pwms', 'UserMngController@ajax_pwms');
	Route::get('user_mng/csv_download', 'UserMngController@csv_download');
	Route::post('user_mng/bulk_reg', 'UserMngController@bulk_reg');
	
	// Yagi
	Route::get('yagi', 'YagiController@index');
	Route::post('yagi/ajax_reg', 'YagiController@ajax_reg');
	Route::post('yagi/ajax_delete', 'YagiController@ajax_delete');
	Route::post('yagi/auto_save', 'YagiController@auto_save');
	Route::post('yagi/ajax_pwms', 'YagiController@ajax_pwms');
	Route::get('yagi/csv_download', 'YagiController@csv_download');
	Route::post('yagi/bulk_reg', 'YagiController@bulk_reg');
	
	Route::get('/home', 'HomeController@index')->name('welcome');
	//Route::get('/home', 'HomeController@neko')->name('neko');
	Auth::routes();