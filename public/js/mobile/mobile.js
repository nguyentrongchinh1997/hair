$(function(){
    $(".phone-mobile").keyup(function(event) {
        $(this).val($(this).val().replace(/^(\d{4})(\d{3})(\d{3})+$/, "$1.$2.$3"));
    });
    $('.menu-tab').click(function(){
        value = $(this).attr("value");
        $('.menu-tab').removeClass('active');
        $(this).addClass("active");
        $('.tab').hide();
        $('#' + value).show();
    })

    $('#seen').click(function(){
        date = $('.date-pick').val();

        if (date == '') {
            alert('Cần chọn ngày');
        } else {
            $.get('mobile/nhan-vien/thu-nhap/tim-kiem?date=' + date, function(data){
                $('#result').html(data);
            })
        }
        /*dateTo = $('#date-to').val();
        dateFrom = $('#date-from').val();
        if (dateFrom == '') {
            alert('Cần chọn ngày bắt đầu');
        } else if (dateTo == '') {
            alert('Cần chọn ngày kết thúc');
        } else {
            $.get('mobile/nhan-vien/thu-nhap/tim-kiem?from=' + dateFrom + '&to=' + dateTo, function(data){
                $('#result').html(data);
            })
        }*/
    })

    $('.history-employee .pick-date').change(function(){
        date = $('.history-employee .pick-date').val();
        $.get('mobile/nhan-vien/lich-su/' + date, function(data){
            $('.history-employee .history-list').html(data);
        })
    })

    $('.book-notification i').click(function(){
        $('.book-notification').hide();
    })
})
function pick(id)
{
	$('.expiry').removeClass('pick');
    $('#pick' + id).addClass('pick');
    $('#checked' + id).prop("checked", true);
}
function validatePhone()
{
	phone = $(".phone-mobile").val();
	phoneFromat = phone.replace(/[.]/g,'');
	if (isNaN(phoneFromat)) {
		alert('Số điện thoại không đúng định dạng');

		return false;
	} else if (phoneFromat.length != 10) {
		alert('Số điện thoại phải đủ 10 số');

		return false;
	} else {
		return true;
	}
	
	return false;
}
function resetPassword()
{
	alert('Bạn vui lòng liên hệ với Admin để reset lại mật khẩu!');
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
$(function(){
    if ($('.wash').is(":checked")) {
        serviceId = $('.wash').val();
        $('.skinner').show();
        $.get('skinner/list/' + serviceId, function(data){
            $('.skinner').html(data);
        })
    }
})
function pickHair(serviceId)
{
    if ($('.service' + serviceId).is(":checked")) {
        $('#check' + serviceId).show();
        $('.stylist').toggle('slide');
        $.get('stylist/list/' + serviceId, function(data){
            $('.stylist').html(data);
        })
    } else {
        $('#check' + serviceId).hide();
        $('.stylist').hide('slide');
    }
}
function pickSkinner(serviceId)
{
    if ($('.service-skinner' + serviceId).is(":checked")) {
        $('#icon-check-skinner').show();
        $('.skinner').toggle('slide');
        $.get('skinner/list/' + serviceId, function(data){
            $('.skinner').html(data);
        })
    } else {
        $('#icon-check-skinner').hide();
        $('.skinner').hide('slide');
    }
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
    $('.radio-stylist1').prop('checked', false);
    $('#stylist' + id).prop('checked', true);
}

/*Lightpick*/
$(function(){
    var picker = new Lightpick({
        field: document.getElementById('demo-2'),
        singleDate: false,
        onSelect: function(start, end){
            var str = '';
            str += start ? start.format('Do MMMM YYYY') + ' to ' : '';
            str += end ? end.format('Do MMMM YYYY') : '...';
            // document.getElementById('result-2').innerHTML = str;
        }
    }); 
})

/*end*/