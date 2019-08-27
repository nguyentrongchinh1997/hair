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

Route::get('/', 'client\ClientController@homeView')->name('client.home');
Route::get('nhan-vien/{type}', 'client\AjaxController@getEmployee');
Route::post('dat-lich', 'client\ClientController@order')->name('order');

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

    Route::group(['prefix' => 'dat-lich'], function(){
        Route::get('danh-sach', 'admin\AdminController@orderListView')->name('order.list');
        Route::post('danh-sach', 'admin\AdminController@postOrderListView')->name('order.post.list');
        Route::get('tim-kiem/{key}/{date}', 'admin\AjaxController@resultList');
        Route::get('chi-tiet/{orderId}', 'admin\AjaxController@orderDetail');
    });

    Route::group(['prefix' => 'khach-hang'], function(){
        Route::post('check/{orderId}', 'admin\AdminController@checkIn')->name('check-in');
        Route::get('cap-nhat/{id}/{ten}/{birthday}', 'admin\AjaxController@updateCustomer');
    });
    Route::get('test/{id}', function(){
        echo "hihi";
    });
    Route::group(['prefix' => 'hoa-don'], function(){
        Route::get('danh-sach', 'admin\AdminController@billList')->name('bill.list');
        Route::post('danh-sach', 'admin\AdminController@postBillList')->name('bill.post.list');
        Route::get('tim-kiem/{keySearch}/{date}', 'admin\AjaxController@search');
        Route::get('chi-tiet/{billId}', 'admin\AjaxController@billDetail');
        Route::get('tong/{billId}/{price_total}', 'admin\AjaxController@total');
        Route::get('them/{billId}/{employeeId}/{price_total}/{number}', 'admin\AjaxController@pay');
    });
});

Route::get('dang-nhap', 'admin\LoginController@loginView')->name('login');
Route::post('dang-nhap', 'admin\LoginController@login');
Route::get('logout', 'admin\LoginController@logout')->name('logout');
