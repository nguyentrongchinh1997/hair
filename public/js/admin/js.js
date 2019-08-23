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
    var keySerach = $('#search-input').val();
    if (keySerach != '') {
      $.get('admin/dat-lich/tim-kiem/' + keySerach, function(data){
        $('.order-list').html(data);
      });
    } 
  })

  $('#key-search').keyup(function(){
    var keySerach = $('#key-search').val();
    if (keySerach != '') {
      $.get('admin/hoa-don/tim-kiem/' + keySerach, function(data){
        $('.order-list').html(data);
      });
    } 
  })

  $('.order').click(function(){
    var orderId = $(this).val();
    $.get('admin/dat-lich/detail/' + orderId, function(data){
      $('.detail-order').html(data);
    });
  })
});



