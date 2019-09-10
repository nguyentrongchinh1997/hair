function validateForm()
{
    var phone = document.getElementById('phone').value;
    var checkbox = document.getElementsByClassName('service');
    var employee = document.getElementsByClassName('employee');
    var time = document.getElementsByClassName('time');
    var len1 = employee.length;
    var len2 = time.length;
    var len = checkbox.length;
    var anyChecked = false;
    var employeeChecked = false;
    var timeChecked = false;
    for (var i = 0; i < len; i++) {
    	if (checkbox[i].checked){
          anyChecked = true;
          break;
       	}
    }
    // for (var i = 0; i < len1; i++) {
    // 	if (employee[i].checked){
    //       employeeChecked = true;
    //       break;
    //    	}
    // }
    for (var i = 0; i < len2; i++) {
    	if (time[i].checked){
          timeChecked = true;
          break;
       	}
    }
    if (phone == '') {
    	alert('Cần điền số điện thoại');

    	return false;
    } else if (isNaN(phone)) {
    	alert('Số điện thoại không đúng định dạng');

		return false;
    } else if (phone.length != 10) {
    	alert('Số điện thoại phải đủ 10 số');

		return false;
    } else if (!anyChecked) {
	   	alert('Bạn chưa chọn dịch vụ');

	   	return false;
	  // } else if (!employeeChecked) {
   //  	alert('Bạn chưa chọn nhân viên phục vụ');

	  //  	return false;
    } else if (!timeChecked) {
    	alert('Bạn chưa chọn khung giờ');

    	return false;
    } else {
		return true;
	}

	return false
}

$(function(){
	$('.service').change(function(){
		var service = $('input[name="service"]:checked').val();
		$.get('nhan-vien/' + service, function(data){
			$('.stylist').html(data);
		});
	})
	
})

function pick(id)
{
    alert("sad");
}