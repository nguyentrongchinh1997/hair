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
        date_start = $('.date-start').val();
        date_end = $('.date-end').val();

        if (date_start == '') {
            alert('Cần chọn ngày bắt đầu');
        } else if (date_end == '') {
            alert('Cần chọn ngày kết thúc');
        } else {
            $.get('mobile/nhan-vien/thu-nhap/tim-kiem?dateStart=' + date_start + '&dateEnd=' + date_end, function(data){
                $('#result').html(data);
            })
        }
        
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
        // $.get('skinner/list/' + serviceId, function(data){
        //     $('.skinner').html(data);
        // })
    }
})
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
$(function(){
    var picker = new Lightpick({
        field: document.getElementById('demo-3_1'),
        secondField: document.getElementById('demo-3_2'),
        singleDate: false,
        onSelect: function(start, end){
            var str = '';
            str += start ? start.format('Do MMMM YYYY') + ' to ' : '';
            str += end ? end.format('Do MMMM YYYY') : '...';
            // document.getElementById('result-3').innerHTML = str;
        }
    });
})

/*end*/

$(function(){
    $('.tong').html($('#tong').html());
    $('.total-month').html($('#total-month').html());
    $('.total-last-month').html($('#total-last-month').html());
    $('.total-yesterday').html($('#total-yesterday').html());
})
