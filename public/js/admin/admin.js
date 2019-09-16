$(document).ready(function(){
    $('#formattedNumberField').on('input', function(e){        
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
    var keySerach = $('#search-input').val();
    if (keySerach != '') {
      $.get('admin/dat-lich/tim-kiem/' + keySerach + '/' + date, function(data){
        $('.order-list').html(data);
      });
    }
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
    var keySerach = $('#key-search').val();
    if (keySerach != '') {
      $.get('admin/hoa-don/tim-kiem/' + keySerach + '/' + date, function(data){
        $('.order-list').html(data);
      });
    } 
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
    var phone = document.getElementById('phone').value;
    var stylist = $('#cut-stylist').val();
    var skinner = $('#cut-skinner').val();
    var washLength = $('#wash:checkbox:checked').length;
    var cutLength = $('#cut:checkbox:checked').length;
    var timeId = $('#time-id').val();
    if (isNaN(phone)) {
        alert('Số điện thoại không đúng định dạng');

        return false;
    } else if (phone.length != 10) {
        alert('Số điện thoại phải đủ 10 số');

        return false;
    } else if (washLength == 0 && cutLength == 0) {
        alert('Chưa chọn dịch vụ');

        return false;
    } else if (washLength > 0 && skinner == 0) {
        alert('Chưa chọn thợ gội');

        return false;
    } else if (cutLength > 0 && stylist == 0) {
        alert('Chưa chọn thợ cắt');

      return false;
    } else if (cutLength == 0 && stylist != 0) {
        alert('Chư chọn dịch vụ cắt');

        return false;
    } else if (washLength == 0 && skinner != 0) {
        alert('Chưa chọn dịch vụ gội');

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
    startTime = document.getElementById('start-time').value;
    endTime = document.getElementById('end-time').value;
    service = document.getElementsByClassName("service");
    var len = service.length;
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
    } else if (startTime == '') {
        alert('Cần điền thời gian bắt đầu');

        return false;
    } else if (endTime == '') {
        alert('Cần điền thời gian két thúc');

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
    $.get('admin/the/gia-han/' + id, function(data){
        $('.extension').html(data);
    })
}

function employeeDetail(id)
{
    $('.employee').removeClass('active');
    $('#employee' + id).addClass('active');
    date = $('#date').val();
    $.get('admin/nhan-vien/chi-tiet?id=' + id + '&date=' + date, function(data){
        $('.employee-detail').html(data);
    });
}