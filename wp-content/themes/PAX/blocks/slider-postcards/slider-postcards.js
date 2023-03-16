var swiper = new Swiper(".cards-postcards-slider", {
    navigation: {
       nextEl: ".swiper-button-next",
       prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});

jQuery(document).ready(function($)
{
	$('.tab-menu li a').on('click', function(){
        var target = $(this).attr('data-rel');
        $('.tab-menu li a').removeClass('active');
        $(this).addClass('active');
       	var indexnumber = $("#"+target).attr('data-slick-index');
       	swiper.slideTo(target);

        return false;
    });

   	$('.swiper-button-prev').click(function() {
		$('.tab-wrap').removeClass('active');
		var currentid = $('.swiper-slide-active').attr('id');
		$('.'+currentid).addClass('active');
		return false;
	});
	
	$('.swiper-button-next').click(function() {
		$('.tab-wrap').removeClass('active');
		var currentid = $('.swiper-slide-active').attr('id');
		$('.'+currentid).addClass('active');
		return false;
	});
});