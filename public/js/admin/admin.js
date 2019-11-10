$(document).ready(function(){
    $('#formattedNumberField').on('input', function(e){        
      $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
    }).on('keypress',function(e){
      if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
    }).on('paste', function(e){    
      var cb = e.originalEvent.clipboardData || window.clipboardData;      
      if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
    });
    $('.formattedNumberField').on('input', function(e){        
      $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
    }).on('keypress',function(e){
      if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
    }).on('paste', function(e){    
      var cb = e.originalEvent.clipboardData || window.clipboardData;      
      if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
    });
    function formatCurrency(number){
      var n = number.split('').reverse().join("");
      var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");    
      return  n2.split('').reverse().join('');
    }
    $('.formattedNumberField').on('input', function(e){        
      $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
    }).on('keypress',function(e){
      if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
    }).on('paste', function(e){    
      var cb = e.originalEvent.clipboardData || window.clipboardData;      
      if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
    });

// search đơn đặt lịch
  $('#search-input').keyup(function(){
    var day = $('#day').val();
    var month = $('#month').val();
    var year = $('#year').val();
    if (day < 10) {
      day = 0 + $('#day').val();
    }
    if (month < 10) {
      month = 0 + $('#month').val();
    }
    var date = year + '-' + month + '-' + day;
    var keySearch = $('#search-input').val();
    $.get('admin/dat-lich/tim-kiem?keySearch=' + keySearch + '&date=' + date, function(data){
        $('.order-list').html(data);
    });
  })

    $('.tab').click(function(){
        value = $(this).attr('value');
        $('.tab').removeClass('expense-active');
        $(this).addClass('expense-active');
        $('.list-expense').hide();
        $('#' + value).show();
    })

// search hóa đơn
  $('#key-search').keyup(function(){
    var day = $('#day').val();
    var month = $('#month').val();
    var year = $('#year').val();
    if (day < 10) {
      day = 0 + $('#day').val();
    }
    if (month < 10) {
      month = 0 + $('#month').val();
    }
    var date = year + '-' + month + '-' + day;
    var keySearch = $('#key-search').val();
    $.get('admin/hoa-don/tim-kiem?keySearch=' + keySearch + '&date=' + date, function(data){
        $('.order-list').html(data);
    });
  })

// search khách hàng
  $('#search-customer').keyup(function(){
    var phone = $('#search-customer').val();
    if (phone != '') {
        $.get('admin/khach-hang/tim-kiem/' + phone, function(data){
          $('#list-customer').html(data);
          $('.pagination').hide();
        });
    }
  })

  $('.order').click(function(){
    var orderId = $(this).val();
    $.get('admin/dat-lich/chi-tiet/' + orderId, function(data){
      $('.detail-order').html(data);
    });
  })

  $('.list-order').click(function() {
    $('.list-order').removeClass('active');
    $(this).addClass('active');
    var orderId = $(this).attr('value');
    if (orderId != '') {
        $.get('admin/dat-lich/chi-tiet/' + orderId, function(data){
          $('#right').html(data);
      });
    }
  });

  $('.list-bill').click(function() {
    $('.list-bill').removeClass('active');
    $(this).addClass('active');
    var billId = $(this).attr('value');
    if (billId != '') {
        $.get('admin/hoa-don/chi-tiet/' + billId, function(data){
          $('.right').html(data);
      });
    }
  });
});
function validateBillAdd()
{
  employee_id = $('#employee_id').val();
  noRequest = $('.no-request:radio:checked').length;
  request = $('.request:radio:checked').length;
  phone = document.getElementById('phone').value;
    if (isNaN(phone)) {
      alert('Số điện thoại không đúng định dạng');

    return false;
    } else if (phone.length != 10) {
      alert('Số điện thoại phải đủ 10 số');

      return false;
    } else if (employee_id == 0) {
      alert('Chưa chọn thợ chính');

      return false;
    } else if (noRequest == 0 && request == 0) {
      alert('Cần tích yêu cầu hoặc không yêu cầu');
    } else {
        return true;
    }

    return false;
}
function validateBillAddHand()
{
  employee_id = $('#employee-id').val();
  assistant_id = $('#assistant_id_hand').val();
  percent_assistant = $('#percent-assistant').val();
  noRequest = $('.no-request:radio:checked').length;
  request = $('.request:radio:checked').length;
  phone = document.getElementById('phone-hand').value;
    if (isNaN(phone)) {
      alert('Số điện thoại không đúng định dạng');

    return false;
    } else if (phone.length != 10) {
      alert('Số điện thoại phải đủ 10 số');

      return false;
    } else if (employee_id == 0) {
      alert('Chưa chọn thợ chính');

      return false;
    } else if (noRequest == 0 && request == 0) {
      alert('Cần tích yêu cầu hoặc không yêu cầu');

      return false;
    } else if (assistant_id != 0 && percent_assistant == '') {
        alert('Cần điền chiết khấu % cho thợ phụ');

        return false;
    } else if (percent_assistant > 0 && assistant_id == 0) {
        alert('Cần chọn thợ phụ');

        return false;
    } else {
        return true;
    }

    return false;
}

function editService(id)
{
    $.get('admin/dich-vu/sua/' + id, function(data){
    $('.edit-service').html(data);
  })
}
function editEmployee(id)
{
    $.get('admin/nhan-vien/sua/' + id, function(data){
    $('.edit-employee').html(data);
  })
}
function validateAddOrder()
{
    phone = document.getElementById('phone').value;
    // stylist = $('#cut-stylist').val();
    // skinner = $('#cut-skinner').val();
    washLength = $('#wash:checkbox:checked').length;
    cutLength = $('#cut:checkbox:checked').length;
    otherService = $('#other-service:checkbox:checked').length;
    timeId = $('#time-id').val();
    date = $('#date').val();
    if (isNaN(phone)) {
        alert('Số điện thoại không đúng định dạng');

        return false;
    } else if (phone.length != 10) {
        alert('Số điện thoại phải đủ 10 số');

        return false;
    } else if (washLength == 0 && cutLength == 0 && otherService == 0) {
        alert('Chưa chọn dịch vụ');

        return false;
    // } else if (washLength > 0 && skinner == 0) {
    //     alert('Chưa chọn thợ gội');

    //     return false;
    // } else if (cutLength > 0 && stylist == 0) {
    //     alert('Chưa chọn thợ cắt');

    //   return false;
    // } else if (cutLength == 0 && stylist != 0) {
    //     alert('Chư chọn dịch vụ cắt');

    //     return false;
    // } else if (washLength == 0 && skinner != 0) {
    //     alert('Chưa chọn dịch vụ gội');

    //     return false;
    } else if (date == '') {
        alert('Cần chọn ngày lập hóa đơn');

        return false;
    } else if (timeId == 0) {
        alert('Chưa chọn thời gian phục vụ');

        return false;
    } else {
        return true;
    }
  return false;
}

function customerDetail(id)
{
    $('.list-customer').removeClass('active');
    $('#customer' + id).addClass('active');
    $.get('admin/khach-hang/chi-tiet/' + id, function(data){
        $('.detail-customer').html(data);
    })
}

function validateCard()
{
    customerId = document.getElementById('customer-id').value;
    cardName = document.getElementById('card-name').value;
    money = document.getElementById('formattedNumberField').value;
    service = document.getElementsByClassName("service");
    len = service.length;
    serviceChecked = false;
    for (var i = 0; i < len; i++) {
        if (service[i].checked){
            serviceChecked = true;
            break;
        }
    }

    if (customerId == 0) {
      alert('Chưa chọn khách hàng');

        return false;
    } else if (cardName == '') {
        alert('Cần điền tên card');

    return false;
    } else if (money == '') {
        alert('Cần điền số tiền');

        return false;
    } else if (!serviceChecked) {
        alert('Cần chọn dịch vụ');

        return false;
    } else {
        return true;
    }
    return false;
}

function cardService(id)
{
    service = $('#card-service' + id);
    var len = service.length;
    serviceChecked = false;
    for (var i = 0; i < len; i++) {
        if (service[i].checked){
            serviceChecked = true;
            break;
        }
    }

    if (serviceChecked) {
        $('#card-service-percent' + id).prop('disabled', false);
        $('#card-service-percent' + id).attr('required', 'required');
    } else {
        $('#card-service-percent' + id).prop('disabled', true);
    }
}

function extension(id)
{
    $.get('admin/hoi-vien/gia-han/' + id, function(data){
        $('.extension').html(data);
    })
}

function employeeDetail(id)
{
    $('.employee').removeClass('active');
    $('#employee' + id).addClass('active');
    type = $('#type').val();
    dateSearch = $('#date-search').val();
    $.get('admin/nhan-vien/chi-tiet?id=' + id + '&type=' + type + '&date=' + dateSearch, function(data){
        $('.employee-detail').html(data);
    });
}

function validateEmployeeAdd()
{
    employeeName = $('#employee-name').val();
    employeePhone = $('#employee-phone').val();
    employeeAddress = $('#employee-address').val();
    employeeSalary = $('#formattedNumberField').val();
    employeePassword = $('#employee-password').val();
    if (employeeName == '') {
        alert('Cần nhập tên nhân viên');

        return false;
    } else if (isNaN(employeePhone)) {
        alert('Số điện thoại không đúng định dạng');

        return false;
    } else if (employeePhone.length !=10 ) {
        alert('Số điện thoại phải đủ 10 số');

        return false;
    } else if (employeeAddress == '') {
        alert('Cần nhập địa chỉ nhân viên');

        return false;
    } else if (employeeSalary == '') {
        alert('Cần nhập lương cứng nhân viên');

        return false;
    } else if (employeePassword == '') {
        alert('Cần nhập mật khẩu chi nhân viên');

        return false;
    } else {
        return true;
    }
    return false;
}
function validateEmployeeEdit()
{
    employeeName = $('#edit-employee-name').val();
    employeePhone = $('#edit-employee-phone').val();
    employeeAddress = $('#edit-employee-address').val();
    employeeSalary = $('#format-number').val();
    if (employeeName == '') {
        alert('Cần nhập tên nhân viên');

        return false;
    } else if (isNaN(employeePhone)) {
        alert('Số điện thoại không đúng định dạng');

        return false;
    } else if (employeePhone.length !=10 ) {
        alert('Số điện thoại phải đủ 10 số');

        return false;
    } else if (employeeAddress == '') {
        alert('Cần nhập địa chỉ nhân viên');

        return false;
    } else if (employeeSalary == '') {
        alert('Cần nhập lương cứng nhân viên');

        return false;
    } else {
        return true;
    }
    return false;
}
$('#name-employee').keyup(function(){
    type = $('#type').val();
    date = $('#date-search').val();
    today = $('#today').val();
    numberDays = $('#number-day').val();
    employeeName = $('#name-employee').val();

    if (employeeName != '') {
        $.get('admin/nhan-vien/tim-kiem?name=' + employeeName + '&type=' + type + '&date=' + date + '&number=' + numberDays + '&today=' + today, function(data){
            $('#result-search').html(data);
        })  
    } else {
        $.get('admin/nhan-vien/tim-kiem?name=null' + '&type=' + type + '&date=' + date + '&number=' + numberDays + '&today=' + today, function(data){
            $('#result-search').html(data);
        })
    }

})

$('#member-search').keyup(function(){
    key = $('#member-search').val();
    $.get('admin/hoi-vien/tim-kiem?key=' + key, function(data){
        $('#member-result').html(data);
    })
})

function validateFormMembership()
{
    customerId = $('#customer_id').val();
    cardId = $('#card_id').val();
    endTime = $('#end_time').val();
    
    if (customerId == 0) {
        alert('Chưa chọn khách hàng');

        return false;
    } else if (cardId == 0) {
        alert('Chưa chọn thẻ hội viên');

        return false;
    } else if (endTime == '') {
        alert('Chưa chọn ngày hết hạn');

        return false;
    } else {
        return true;
    }

    return false;
}

function check1()
{
    if ($('#cut').is(":checked")) {
        $('.cut').prop('disabled', false);
    } else {
        $('.cut').prop('disabled', true);
    }
}
function check2()
{
    if ($('#wash').is(":checked")) {
        $('.wash').prop('disabled', false);
    } else {
        $('.wash').prop('disabled', true);
    }
}
function check3()
{
    if ($('#other-service').is(":checked")) {
        $('.other-service').prop('disabled', false);
    } else {
        $('.other-service').prop('disabled', true);
    }
}
$(function(){
    $('.tong').html($('#tong').html());
    $('.revenue').html($('#revenue').html());
    $('.cam-ve').html($('#cam-ve').html());
    $('.salary').html($('#salary').html());
    $('.profit').html($('#profit').html());
    $('.transfer').html($('#transfer').html());
    $('.tong-chi').html($('#tong-chi').html());
    $('.tong-thu').html($('#tong-thu').html());
})
function deleteExpense()
{
    if (confirm('Bạn có chắc chắn muốn xóa mục này?')) {
        return true;
    } else {
        return false;
    }
}
function editExpese(id)
{
    $.get('admin/chi-tieu/sua/' + id, function(data){
        $('#expense-edit .modal-body').html(data);
    });
}
function deleteService()
{
    if (confirm('Bạn có chắc chắn muốn xóa dịch vụ này?')) {
        return true;
    } else {
        return false;
    }
}
function deleteCard()
{
    if (confirm('Bạn có chắc chắn muốn xóa thẻ này?')) {
        return true;
    } else {
        return false;
    }
}
function deleteMembership()
{
    if (confirm('Bạn có chắc chắn muốn xóa hội viên này?')) {
        return true;
    } else {
        return false;
    }
}
$(function(){
    $('.card-type').click(function(){
        $('.card-type').removeClass('card-active');
        $(this).addClass('card-active');
        data = $(this).attr('data');
        $('.form-card').hide();
        $('#' + data).show();
    })

    $('#phone').keyup(function(){
        phone = $('#phone').val();
        $.get('admin/dat-lich/tim-kiem/khach-hang?phone=' + phone, function(data){
            $('#name-customer').val(data);
        })
    })
    $('#phone-hand').keyup(function(){
        phone = $('#phone-hand').val();
        $.get('admin/dat-lich/tim-kiem/khach-hang?phone=' + phone, function(data){
            $('#name-customer-hand').val(data);
        })
    })

    $('#name-service').keyup(function(){
        nameService = $('#name-service').val();
        $.get('admin/dich-vu/tim-kiem?name=' + nameService, function(data){
            $('#search-service').html(data);
        });
    })
})
function customerAdd()
{
    phone = $('#employee-phone').val();

    if (isNaN(phone)) {
        alert('Số điện thoại sai định dạng');

        return false;
    } else if (phone.length != 10) {
        alert('Số điện thoại phải đủ 10 số');

        return false;
    } else {
        return true;
    }
}
function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
$(function(){
    $('#percent-employee, .service-price-hand, #percent-assistant').keyup(function(){
        price = $('.service-price-hand').val();
        priceFormat = price.replace(/[,]/g,'');
        percent = $('#percent-employee').val();
        percentAssistant = $('#percent-assistant').val();
        moneyEmployee = parseFloat(percent/100 * priceFormat);
        moneyAssistant = parseFloat(percentAssistant/100 * priceFormat);
        if (price != '') {
            $('#money-hand').val(addCommas(parseFloat(moneyEmployee).toFixed(0)));
            $('#money-assistant-hand').val(addCommas(parseFloat(moneyAssistant).toFixed(0)));
        } else {
            $('#money-hand').val('');
            $('#money-assistant-hand').val('');
        }
        
    })
    $('#money-assistant-hand, #money-hand').keyup(function(){
        price = $('.service-price-hand').val();
        priceFormat = price.replace(/[,]/g,'');
        moneyAssistant = $('#money-assistant-hand').val();
        moneyAssistantFormat = moneyAssistant.replace(/[,]/g,'');
        moneyEmployee = $('#money-hand').val();
        moneyEmployeeFormat = moneyEmployee.replace(/[,]/g,'');
        percentAssistant = parseFloat(moneyAssistantFormat/priceFormat * 100);
        percentEmployee = parseFloat(moneyEmployeeFormat/priceFormat * 100);
        $('#percent-assistant').val(addCommas(parseFloat(percentAssistant).toFixed(1)));
        $('#percent-employee').val(addCommas(parseFloat(percentEmployee).toFixed(1)));
    })
})
