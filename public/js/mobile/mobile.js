$(function(){
    $(".phone-mobile").keyup(function(event) {
        $(this).val($(this).val().replace(/^(\d{4})(\d{3})(\d{3})+$/, "$1.$2.$3"));
    });
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
$(function(){
    if ($('.wash').is(":checked")) {
        serviceId = $('.wash').val();
        $('.skinner').show();
        $.get('skinner/list/' + serviceId, function(data){
            $('.skinner').html(data);
        })
    }
    // var stickyHeaderTop = $('.top-header').offset().top;

    // $(window).scroll(function(){
    //     if( $(window).scrollTop() > stickyHeaderTop ) {
    //             $('.top-header').addClass('top-header-scroll');
    //     } else {
    //             $('.top-header').removeClass('top-header-scroll');
    //     }
    // });
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
