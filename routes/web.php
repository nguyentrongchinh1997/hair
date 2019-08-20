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
});

Route::group(['prefix' => 'admin', 'middleware' => 'adminMiddleware'], function(){
    Route::get('trang-chu', 'admin\AdminController@homeView')->name('admin.home');
    Route::group(['prefix' => 'nhan-vien'], function(){
        // Route::get('them', 'admin\AdminController@employeeAddView')->name('employee.add');
        Route::post('them', 'admin\AdminController@employeeAdd')->name('employee.add');
        Route::get('danh-sach', 'admin\AdminController@employeeListView')->name('employee.list');
        Route::get('sua/{id}', 'admin\AdminController@employeeEditView')->name('employee.edit');
        Route::post('sua/{id}', 'admin\AdminController@employeeEdit');
    });

    Route::group(['prefix' => 'dich-vu'], function(){
        // Route::get('them', 'admin\AdminController@serviceAddView')->name('service.add');
        Route::post('them', 'admin\AdminController@serviceAdd')->name('service.add');
        Route::get('danh-sach', 'admin\AdminController@serviceListView')->name('service.list');
        Route::get('sua/{id}', 'admin\AdminController@serviceEditView')->name('service.edit');
        Route::post('sua/{id}', 'admin\AdminController@serviceEdit')->name('service.edit');
    });
});

Route::get('dang-nhap', 'admin\LoginController@loginView')->name('login');
Route::post('dang-nhap', 'admin\LoginController@login');
Route::get('logout', 'admin\LoginController@logout')->name('logout');
