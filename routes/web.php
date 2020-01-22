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

Route::middleware(['auth'])->group(function() {

	Route::get('/', 'HomeController@index')->name('index');
	
	//users routes
	Route::resource('users', 'UserController')->except(['show']);

	//categories routes
	Route::resource('categories', 'CategoryController')->except(['show']);

	//clients routes
	Route::resource('clients', 'ClientController')->except(['show']);

	//materials routes
	Route::resource('materials', 'MaterialController')->except(['show']);

	//workers routes
	Route::resource('workers', 'Worker\WorkerController')->except(['show']);

	//days_worker routes
	Route::resource('workers.days_worker', 'Worker\DaysWorkerController')->except(['show']);

	//days_car routes
	Route::resource('days_car', 'Car\DaysCarController')->except(['show']);

	//expenses routes
	Route::resource('expenses', 'ExpenseController')->except(['show']);

	//orders routes
	Route::resource('orders', 'Order\OrderController')->except(['show']);
	Route::post('update_status/{order}', 'Order\OrderController@update_status')->name('orders.update_status');

	//sub_orders routes
	Route::resource('orders.sub_orders', 'Order\SubOrderController')->except(['show']);

	//sales routes
	Route::resource('sales', 'SaleController')->except(['show']);

	//productions routes
	Route::resource('productions', 'ProductionController')->except(['show']);

});

Auth::routes(['register' => false]);

