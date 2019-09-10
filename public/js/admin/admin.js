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
function validateForm()
{
  var phone = document.getElementById('phone').value;
  if (isNaN(phone)) {
      alert('Số điện thoại không đúng định dạng');

    return false;
  } else if (phone.length != 10) {
      alert('Số điện thoại phải đủ 10 số');

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
  } else if (timeId == 0) {
      alert('Chưa chọn thời gian phục vụ');

      return false;
  } else {
      return true;
  }
  return false;
}