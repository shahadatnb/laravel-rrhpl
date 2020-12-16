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

/*Route::get('/', function () {
    return view('welcome');
});*/

// Authentication Routes...
Route::get('login', ['as' => 'login','uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => '','uses' => 'Auth\LoginController@login']);
Route::post('logout', ['as' => 'logout','uses' => 'Auth\LoginController@logout']);
Route::get('ac_config', function()
    {
        //$exitCode = Artisan::call('command:name', ['--option' => 'foo']);
        $exitCode = Artisan::call('config:cache');
        return 'ok';
    });

// Password Reset Routes...
Route::post('password/email', ['as' => 'password.email','uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset', ['as' => 'password.request','uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/reset', ['as' => '','uses' => 'Auth\ResetPasswordController@reset']);
Route::get('password/reset/{token}', ['as' => 'password.reset','uses' => 'Auth\ResetPasswordController@showResetForm']);


Route::group(['middleware'=>'auth'], function(){
	Route::get('/', 'HomeController@index')->name('home');
	Route::get('/profile', 'ProfileController@index')->name('profile');
	Route::post('/changePassSave', 'ProfileController@changePassSave')->name('changePassSave');
});

Route::group(['middleware'=>['auth','roles'],'roles'=>['admin']],function(){
	Route::get('admin',['uses' => 'RoleController@getAdminPage','as'=>'admin']);
	Route::post('admin-assign',['uses' => 'RoleController@postAssignRole', 'as' => 'admin-assign']);

	Route::get('leaveCancel/{id}','hrLeaveController@leaveCancel')->name('leave.cancel');

	// Registration Routes...
	Route::get('register', ['as' => 'register','uses' => 'Auth\RegisterController@showRegistrationForm']);
	Route::post('register', ['as' => '','uses' => 'Auth\RegisterController@register']);
});

// ############## Store Management
Route::group(['prefix'=>'store','middleware'=>['auth','roles'],'roles'=>['store']],function(){
	Route::get('/report', ['uses' => 'StoreReportController@index', 'as' => 'store.report']);
	Route::get('/report/{slug}', ['uses' => 'StoreReportController@view', 'as' => 'store.report.view']);
	Route::post('/report', ['uses' => 'StoreReportController@setDate', 'as' => 'store.report']);
	Route::get('/update_stock', ['uses' => 'StoreReportController@stockUpdate', 'as' => 'store.updatestock']);

	Route::get('/item', ['uses' => 'StoreItemController@index', 'as' => 'store.item']);
	Route::get('/store-iten-export', ['uses' => 'StoreItemController@export', 'as' => 'store-iten-export']);
	Route::get('/itemdestroy/{id}', ['uses' => 'StoreItemController@destroy', 'as' => 'store.item.destroy']);
	Route::post('/store', ['uses' => 'StoreItemController@store', 'as' => 'store.item.store']);
	Route::get('/item/{task_id?}', 'StoreItemController@edit');
	Route::post('/item/edit/{task_id?}', 'StoreItemController@update');

	Route::get('/supplier', ['uses' => 'StoreItemController@Supplier', 'as' => 'store.supplier']);
	Route::post('/add_supplier', ['uses' => 'StoreItemController@storeSupplier', 'as' => 'store.supplier.store']);
	Route::get('/rm_supplier/{id}', ['uses' => 'StoreItemController@supplierRemove', 'as' => 'store.supplier.rm']);

	Route::get('/recipient', ['uses' => 'StoreItemController@Recipients', 'as' => 'store.recipient']);
	Route::post('/add_recipient', ['uses' => 'StoreItemController@StoreRecipient', 'as' => 'store.recipient.store']);
	Route::get('/rm_recipient/{id}', ['uses' => 'StoreItemController@recipientRemove', 'as' => 'store.recipient.rm']);

	Route::get('/category', ['uses' => 'StoreItemController@Category', 'as' => 'store.category']);
	Route::post('/add_category', ['uses' => 'StoreItemController@StoreCategory', 'as' => 'store.category.store']);
	Route::get('/rm_category/{id}', ['uses' => 'StoreItemController@categoryRemove', 'as' => 'store.category.rm']);


	Route::get('/mrr', ['uses' => 'MrrController@index', 'as' => 'store.mrr']);
	Route::get('/mrr/create', ['uses' => 'MrrController@create', 'as' => 'store.mrr.create']);
	Route::get('/mrr/remove/{id}', ['uses' => 'MrrController@remove', 'as' => 'store.mrr.remove']);
	Route::post('/mrr/find', ['uses' => 'MrrController@find', 'as' => 'store.mrr.find']);
	Route::get('/mrr/id/{id}', ['uses' => 'MrrController@edit', 'as' => 'store.mrr.edit']);
	Route::post('/mrr/store', ['uses' => 'MrrController@store', 'as' => 'store.mrr.store']);
	Route::post('/mrr/billPost', ['uses' => 'MrrController@billPost', 'as' => 'store.mrr.billPost']);

	Route::get('/srr', ['uses' => 'SrrController@index', 'as' => 'store.srr']);
	Route::get('/srr/create', ['uses' => 'SrrController@create', 'as' => 'store.srr.create']);
	Route::get('/srr/remove/{id}', ['uses' => 'SrrController@remove', 'as' => 'store.srr.remove']);
	Route::post('/srr/find', ['uses' => 'SrrController@find', 'as' => 'store.srr.find']);
	Route::get('/srr/id/{id}', ['uses' => 'SrrController@edit', 'as' => 'store.srr.edit']);
	Route::post('/srr/store', ['uses' => 'SrrController@store', 'as' => 'store.srr.store']);
	Route::post('/srr/billPost', ['uses' => 'SrrController@billPost', 'as' => 'store.srr.billPost']);
});

// ############## Store Management
Route::group(['prefix'=>'lab','middleware'=>['auth','roles'],'roles'=>['lab']],function(){
	Route::get('/index','HomeController@lab')->name('lab.lab');
	Route::get('/index/{id}','HomeController@exp')->name('lab.exp');

	Route::get('/item', ['uses' => 'LabItemController@index', 'as' => 'lab.item']);
	Route::get('/itemdestroy/{id}', ['uses' => 'LabItemController@destroy', 'as' => 'lab.item.destroy']);
	Route::post('/store', ['uses' => 'LabItemController@store', 'as' => 'lab.item.store']);
	Route::get('/item/{task_id?}', 'LabItemController@edit');
	Route::post('/item/edit/{task_id?}', 'LabItemController@update');

	Route::get('/mrr', ['uses' => 'LabMrrController@index', 'as' => 'lab.mrr']);
	Route::get('/mrr/create', ['uses' => 'LabMrrController@create', 'as' => 'lab.mrr.create']);
	Route::get('/mrr/remove/{id}', ['uses' => 'LabMrrController@remove', 'as' => 'lab.mrr.remove']);
	Route::post('/mrr/find', ['uses' => 'LabMrrController@find', 'as' => 'lab.mrr.find']);
	Route::get('/mrr/id/{id}', ['uses' => 'LabMrrController@edit', 'as' => 'lab.mrr.edit']);
	Route::post('/mrr/store', ['uses' => 'LabMrrController@store', 'as' => 'lab.mrr.store']);
	Route::post('/mrr/billPost', ['uses' => 'LabMrrController@billPost', 'as' => 'lab.mrr.billPost']);

	Route::get('/srr', ['uses' => 'LabSrrController@index', 'as' => 'lab.srr']);
	Route::get('/srr/create', ['uses' => 'LabSrrController@create', 'as' => 'lab.srr.create']);
	Route::get('/srr/remove/{id}', ['uses' => 'LabSrrController@remove', 'as' => 'lab.srr.remove']);
	Route::post('/srr/find', ['uses' => 'LabSrrController@find', 'as' => 'lab.srr.find']);
	Route::get('/srr/id/{id}', ['uses' => 'LabSrrController@edit', 'as' => 'lab.srr.edit']);
	Route::post('/srr/store', ['uses' => 'LabSrrController@store', 'as' => 'lab.srr.store']);
	Route::post('/srr/billPost', ['uses' => 'LabSrrController@billPost', 'as' => 'lab.srr.billPost']);

});

Route::group(['prefix'=>'hrd','middleware'=>['auth','roles'],'roles'=>['hr']],function(){
	Route::resource('employee','HrEmployeeController',['except' => ['destroy']]);
	
	Route::get('employeeList','HrEmployeeController@list')->name('employeeList');
	
	Route::get('leave/{id}','hrLeaveController@leave')->name('leave.index');
	Route::put('leave/{id}','hrLeaveController@leaveReg')->name('leave.reg');
});

//Route::get('/home', 'HomeController@index')->name('home');
