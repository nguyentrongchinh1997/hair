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
/*========================Route cho Mobile khách hàng======================*/
Route::get('mobile/dang-nhap', 'mobile\LoginController@loginView')->name('mobile.login')->middleware('loginMobileMiddleware');
Route::post('mobile/login', 'mobile\LoginController@postLogin')->name('post.login');
Route::group(['prefix' => 'mobile', 'middleware' => 'mobileMiddleware'], function(){
    Route::get('trang-chu', 'mobile\CustomerController@viewHome')->name('mobile.home');

    Route::get('dang-xuat', 'mobile\CustomerController@logout')->name('mobile.logout');

    Route::get('lich-su', 'mobile\CustomerController@history')->name('mobile.history');

    Route::get('the', 'mobile\CustomerController@card')->name('mobile.card');

    Route::get('book', 'mobile\CustomerController@bookHistory')->name('mobile.book');
});
/*========================End======================*/

/*========================Route cho Mobile nhân viên======================*/
Route::get('mobile/nhan-vien/dang-nhap', 'mobile\LoginController@loginEmployeeView')->name('mobile.employee.login')->middleware('loginMobileEmployeeMiddleware');

Route::post('mobile/nhan-vien/dang-nhap', 'mobile\LoginController@postLoginEmployee')->name('mobile.employee.post.login');

Route::group(['prefix' => 'mobile/nhan-vien', 'middleware' => 'mobileEmployeeMiddleware'], function(){
    Route::get('trang-chu', 'mobile\EmployeeController@homeView')->name('mobile.employee.home');

    Route::get('dang-xuat', 'mobile\EmployeeController@logout')->name('mobile.employee.logout');

    Route::get('thu-nhap', 'mobile\EmployeeController@salary')->name('mobile.employee.salary');

    Route::get('thu-nhap/tim-kiem', 'mobile\EmployeeController@search');

    Route::get('lich-su', 'mobile\EmployeeController@history')->name('mobile.employee.history');

    Route::get('lich-su/{ngay}', 'mobile\EmployeeController@historySearch');

    Route::get('bang-luong', 'mobile\EmployeeController@salaryList')->name('mobile.employee.salary.list');
});
/*========================End======================*/

Route::get('logout', 'client\ClientController@logout');
Route::get('404', function(){
    return view('404');
});
Route::get('/', 'client\ClientController@homeView')->name('client.home');
Route::get('nhan-vien/{type}', 'client\AjaxController@getEmployee');

Route::get('dat-lich/{phone}', 'client\ClientController@orderView')->name('order.view')->middleware('checkPhoneMiddleware');
Route::post('dat-lich', 'client\ClientController@order')->name('order');

Route::post('phone', 'client\ClientController@postPhone')->name('post.phone');

Route::post('book', 'client\ClientController@book')->name('client.book');
Route::get('input', 'client\ClientController@input');

Route::get('rate', 'client\ClientController@rateView');

Route::get('stylist/list/{serviceId}', 'client\AjaxController@getService');

Route::get('skinner/list/{serviceId}', 'client\AjaxController@getSkinner');

/*================================== CHỨC NĂNG ĐÁNH GIÁ =====================================*/
Route::group(['prefix' => 'danh-gia'], function(){
    Route::get('ket-thuc', 'client\ClientController@viewFinish')->name('rate.end');

    Route::get('buoc', 'client\ClientController@rate')->name('client.rate');

    Route::post('xac-nhan', 'client\ClientController@finishRate')->name('rate.finish');

    Route::get('muc-do/{noiDung}/{billId}', 'client\ClientController@updateRate');

    Route::group(['prefix' => 'gop-y'], function(){

        Route::get('them/{billId}', 'client\AjaxController@updateComment'); // thêm góp ý
 
        Route::get('xoa/{billId}', 'client\AjaxController@deleteComment'); // xóa góp ý

        Route::get('xac-nhan/hoa-don', 'client\ClientController@billAccept'); // view xác nhận hóa đơn
    });
    
});
/*===================================== end ====================================================*/

Route::group(['prefix' => 'admin', 'middleware' => 'adminMiddleware'], function(){
    Route::get('trang-chu', 'admin\AdminController@homeView')->name('admin.home');
    Route::group(['prefix' => 'nhan-vien', 'middleware' => 'accessMiddleware'], function(){
        Route::post('them', 'admin\EmployeeController@employeeAdd')->name('employee.add');

        Route::get('danh-sach', 'admin\EmployeeController@employeeListView')->name('employee.list');
        Route::post('danh-sach', 'admin\EmployeeController@commisionTime')->name('commision.time');

        Route::get('sua/{id}', 'admin\EmployeeController@employeeEditView')->name('employee.edit');

        Route::post('sua/{id}', 'admin\EmployeeController@employeeEdit');

        Route::get('bang-luong/{employeeId}', 'admin\EmployeeController@salary')->name('salary.list');

        Route::post('bang-luong/{employeeId}', 'admin\EmployeeController@postSalary')->name('salary.list.post');

        Route::get('chi-tiet', 'admin\EmployeeController@detail');

        Route::get('tim-kiem', 'admin\EmployeeController@resultSearch');

    });

    Route::group(['prefix' => 'dich-vu', 'middleware' => 'accessMiddleware'], function(){
        Route::post('them', 'admin\ServiceController@serviceAdd')->name('service.add');

        Route::get('danh-sach', 'admin\ServiceController@serviceListView')->name('service.list');

        Route::get('sua/{id}', 'admin\ServiceController@serviceEditView')->name('service.edit');

        Route::post('sua/{id}', 'admin\ServiceController@serviceEdit')->name('service.edit');

        Route::get('xoa/{id}', 'admin\ServiceController@serviceDelete')->name('service.delete');

        Route::get('tim-kiem', 'admin\ServiceController@serviceSearch');
    });

    Route::group(['prefix' => 'dat-lich'], function(){
        Route::get('convert', 'admin\OrderController@convert');

        Route::post('check/{orderId}', 'admin\OrderController@checkIn')->name('check-in');
        
        Route::get('danh-sach', 'admin\OrderController@orderListView')->name('order.list');
        
        Route::post('danh-sach', 'admin\OrderController@postOrderListView')->name('order.post.list');
        
        Route::get('tim-kiem', 'admin\OrderController@resultList');

        Route::get('tim-kiem/khach-hang', 'admin\OrderController@customerName');
        
        Route::get('chi-tiet/{orderId}', 'admin\OrderController@orderDetail');
        
        Route::get('xoa/{orderDetailId}/{orderId}', 'admin\OrderController@deleteOrder');
        
        Route::get('dich-vu/sua/{serviceId}/{id}', 'admin\OrderController@editService');
        
        Route::get('nhan-vien/sua/{employeeId}/{id}', 'admin\OrderController@editEmployee');
        
        Route::post('them', 'admin\OrderController@addOrder')->name('order.add');
        
        Route::get('nhan-vien/cap-nhat/{assistantId}/{id}', 'admin\OrderController@updateAssistant');
        
        Route::get('huy/{id}', 'admin\OrderController@orderCancel')->name('order.cancel')->middleware('checkOrderMiddleware');

        Route::get('dich-vu/them', 'admin\OrderController@serviceAdd');
        
    });

    Route::group(['prefix' => 'khach-hang'], function(){
        Route::get('cap-nhat/{id}/{ten}/{birthday}', 'admin\CustomerController@updateCustomer');

        Route::get('danh-sach', 'admin\CustomerController@customerListview')->name('customer.list')->middleware('accessMiddleware');

        Route::post('danh-sach', 'admin\CustomerController@postDeposit')->name('recharge');

        Route::get('chi-tiet/{id}', 'admin\CustomerController@viewDetailCustomer');

        Route::get('tim-kiem/{phone}', 'admin\CustomerController@customerSerachResult');

        Route::post('them', 'admin\CustomerController@customerAdd')->name('customer.add');
    });

    Route::group(['prefix' => 'hoa-don'], function(){

        Route::post('ket-thuc/{billId}', 'admin\BillController@finish')->name('finish');

        Route::get('danh-sach', 'admin\BillController@billList')->name('bill.list');

        Route::post('danh-sach', 'admin\BillController@postBillList')->name('bill.post.list');

        Route::get('tim-kiem', 'admin\BillController@search');

        Route::get('chi-tiet/{billId}', 'admin\BillController@billDetail');

        Route::get('dich-vu/them', 'admin\BillController@serviceAdd');

        Route::get('xoa/dich-vu/{billDetailId}', 'admin\BillController@serviceDelete')->middleware('checkDeleteBillDetail');

        Route::get('dich-vu-khac/them', 'admin\BillController@serviceOtherAdd');

        Route::get('thanh-toan/{billID}', 'admin\BillController@payView');

        Route::get('cap-nhat/thu-ngan/{billId}','admin\BillController@updateCashier');

        Route::post('them', 'admin\BillController@addBill')->name('bill.add');

        Route::post('them-tay', 'admin\BillController@addBillHand')->name('bill.add.hand');

        Route::get('danh-gia/{billId}', 'admin\BillController@rateUpdate');

        Route::get('in/{id}', 'admin\BillController@printBill')->name('bill.print');

        Route::get('kiem-tra-the/{idBillDetail}/{cardId}', 'admin\BillController@cardCheck');

        Route::get('khoi-phuc/{idBillDetail}', 'admin\BillController@priceRestore');

        Route::get('tho-chinh/phan-tram', 'admin\BillController@percentStylist');

        Route::get('tho-phu/phan-tram', 'admin\BillController@percentStylist');
    });

    Route::group(['prefix' => 'danh-gia', 'middleware' => 'accessMiddleware'], function(){
        Route::get('danh-sach', 'admin\RateController@getRateList')->name('rate.list');
        Route::post('danh-sach/{rateId}', 'admin\RateController@postRate')->name('rate.post');
    });

    Route::group(['prefix' => 'the', 'middleware' => 'accessMiddleware'], function(){
        Route::get('danh-sach', 'admin\CardController@getCardList')->name('card.list');

        Route::post('them', 'admin\CardController@postCard')->name('card.add');

        Route::post('them/khac', 'admin\CardController@postOtherCard')->name('other.card.add');

        Route::get('xoa/{id}', 'admin\CardController@cardDelete')->name('card.delete');
        
    });

    Route::group(['prefix' => 'chi-tieu', 'middleware' => 'accessMiddleware'], function(){
        Route::get('danh-sach', 'admin\ExpenseController@getViewExpense')->name('expense.list');

        Route::post('them', 'admin\ExpenseController@expenseAdd')->name('expense.add');

        Route::post('them-thu-nhap', 'admin\ExpenseController@revenueAdd')->name('income.add');

        Route::post('danh-sach', 'admin\ExpenseController@expenseMonth')->name('expense.month');

        Route::get('xoa/{id}', 'admin\ExpenseController@deleteExpense')->name('expense.delete');

        Route::get('sua/{id}', 'admin\ExpenseController@editExpense')->name('edit.delete');

        Route::post('sua/{id}', 'admin\ExpenseController@editPostExpense')->name('edit.post.delete');

    });

    Route::group(['prefix' => 'hoi-vien', 'middleware' => 'accessMiddleware'], function(){
        Route::get('danh-sach', 'admin\MembershipController@viewListMemberShip')->name('membership.list');

        Route::post('them-thanh-vien', 'admin\MembershipController@membershipAdd')->name('membership.add')->middleware('checkMembershipMiddleware');

        Route::post('them', 'admin\MembershipController@membershipAddOther')->name('membership.add.other')->middleware('checkMembershipMiddleware');

        Route::get('xoa/{id}', 'admin\MembershipController@membershipDelete')->name('membership.delete')->middleware('checkExpiryMembership');

        Route::post('danh-sach', 'admin\MembershipController@membershipTimeList')->name('membership.post.list');

        // Route::get('gia-han/{id}', 'admin\MembershipController@getExtensionView');

        // Route::post('gia-han/{id}', 'admin\MembershipController@postExtension')->name('extension');

        Route::get('tim-kiem', 'admin\MembershipController@search');
    });
    Route::get('logout', 'admin\LoginController@logout')->name('logout');
});

Route::get('dang-nhap', 'admin\LoginController@loginView')->name('login');
Route::post('dang-nhap', 'admin\LoginController@login');

