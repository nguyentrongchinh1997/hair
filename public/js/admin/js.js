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

  // $('.bill').click(function(){
  //   var billId = $(this).val();
  //   $.get('admin/hoa-don/chi-tiet/' + billId, function(data){
  //     $('.detail-bill').html(data);
  //   });
  // });

  $('.list-order').click(function() {
    $('.list-order').removeClass('active');
    $(this).addClass('active');
    var orderId = $(this).attr('value');
    if (orderId != '') {
        $.get('admin/dat-lich/chi-tiet/' + orderId, function(data){
          $('.right').html(data);
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



