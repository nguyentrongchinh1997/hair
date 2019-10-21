// function validateForm()
// {
//  var phone = document.getElementById('phone').value;
//     var checkbox = document.getElementsByClassName('service');
//     var employee = document.getElementsByClassName('employee');
//     var time = document.getElementsByClassName('time');
//     var len1 = employee.length;
//     var len2 = time.length;
//     var len = checkbox.length;
//     var anyChecked = false;
//     var employeeChecked = false;
//     var timeChecked = false;
//     for (var i = 0; i < len; i++) {
//      if (checkbox[i].checked){
//           anyChecked = true;
//           break;
//          }
//     }
//     // for (var i = 0; i < len1; i++) {
//     //   if (employee[i].checked){
//     //       employeeChecked = true;
//     //       break;
//     //       }
//     // }
//     for (var i = 0; i < len2; i++) {
//      if (time[i].checked){
//           timeChecked = true;
//           break;
//          }
//     }
//     if (phone == '') {
//      alert('Cần điền số điện thoại');

//      return false;
//     } else if (isNaN(phone)) {
//      alert('Số điện thoại không đúng định dạng');

//      return false;
//     } else if (phone.length != 10) {
//      alert('Số điện thoại phải đủ 10 số');

//      return false;
//     } else if (!anyChecked) {
//      alert('Bạn chưa chọn dịch vụ');

//      return false;
//    // } else if (!employeeChecked) {
//    //    alert('Bạn chưa chọn nhân viên phục vụ');

//    //    return false;
//     } else if (!timeChecked) {
//      alert('Bạn chưa chọn khung giờ');

//      return false;
//     } else {
//      return true;
//  }

//  return false
// }

$(function(){
    $('.nav-bar').click(function(){
        $('.list-menu-mobile').show('slide');
    })
    $('.exit').click(function(){
        $('.list-menu-mobile').hide();
    })
})
function validatePhone()
{
    phone = $('#phone').val();
    if (phone == '') {
        alert('Cần nhập số điện thoại');

        return false;
    } else if (isNaN(phone)) {
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
function validateForm()
{
    var checkbox = document.getElementsByClassName('service');
    var anyChecked = false;
    var timeChecked = false;
    var time = document.getElementsByClassName('time');
    var len2 = time.length;
    var len = checkbox.length;
    for (var i = 0; i < len; i++) {
        if (checkbox[i].checked){
            anyChecked = true;
            break;
        }
    }
    for (var i = 0; i < len2; i++) {
        if (time[i].checked){
            timeChecked = true;
            break;
        }
    }
    if (!anyChecked) {
        alert('Bạn chưa chọn dịch vụ');

        return false;
    } else if (!timeChecked) {
        alert('Bạn chưa chọn thời gian phục vụ');

        return false;
    } else {
        return true;
    }
    return false;
}



// $(function(){
//  $('.service').change(function(){
//      var service = $('input[name="service"]:checked').val();
//      $.get('nhan-vien/' + service, function(data){
//          $('.stylist').html(data);
//      });
//  })
    
// })

function pick(id)
{
    $('.expiry').removeClass('pick');
    $('#pick' + id).addClass('pick');
    $('#checked' + id).prop("checked", true);
}
function pickService(serviceId)
{
    if ($('.service' + serviceId).is(":checked")) {
        $('#check' + serviceId).show();
        $('.employee-list' + serviceId).show();
        $.get('nhan-vien/danh-sach/' + serviceId, function(data){
            $('.employee-list' + serviceId).html(data);
        })
    } else {
        $('.employee-list' + serviceId).hide();
        $('#check' + serviceId).hide();
    }
    // $('.check').hide();
    // $('#check' + id).show();
}
function pickHair(serviceId)
{
    if ($('.service' + serviceId).is(":checked")) {
        $('#check' + serviceId).show();
        $('.stylist').show();
        $.get('stylist/list/' + serviceId, function(data){
            $('.stylist').html(data);
        })
    } else {
        $('#check' + serviceId).hide();
        $('.stylist').hide();
        $('#stylist').hide();
    }
}
function pickSkinner(serviceId)
{
    if ($('.service-skinner' + serviceId).is(":checked")) {
        $('#icon-check-skinner').show();
        $('.skinner').show();
        $('#skinner').show();
        $.get('skinner/list/' + serviceId, function(data){
            $('.skinner').html(data);
        })
    } else {
        $('#icon-check-skinner').hide();
        $('.skinner').hide();
        $('#skinner').hide();
    }
}
function pickOther(serviceId)
{
    if ($('.service' + serviceId).is(":checked")) {
        $('#check0').show();
        $('.other').append('<input style="display: none;" checked class="other-serevice" type="checkbox" value="0" name="other">');
    } else {
        $('.other-serevice').remove();
        $('#check0').hide();
    }
}
$(function(){
    if ($('.wash').is(":checked")) {
        serviceId = $('.wash').val();
        $('.skinner').show();
        $.get('skinner/list/' + serviceId, function(data){
            $('.skinner').html(data);
        })
    }

})

function pickStylist(id)
{
    $('.avatar').removeClass('avatar-stylist');
    $('#row' + id + ' .avatar' + id).addClass('avatar-stylist');
    $('.radio-stylist').prop("checked", false);
    $('#row' + id + ' #stylist' + id).prop("checked", true);
}
function optionSkinner(id)
{
    $('.avatar-skinner').removeClass('avatar-stylist');
    $('.avatar-skinner' + id).addClass('avatar-stylist');
    $('.radio-skinner').prop('checked', false);
    $('#skinner' + id).prop('checked', true);
}
function optionStylist(id)
{
    $('.thumnail-stylist').removeClass('avatar-stylist');
    $('.avatar-stylist' + id).addClass('avatar-stylist');
    $('.radio-stylist').prop('checked', false);
    $('#stylist' + id).prop('checked', true);
}
$(function(){
    $('.notification-book i').click(function(){
        $('.notification-book').hide();
    })
})
