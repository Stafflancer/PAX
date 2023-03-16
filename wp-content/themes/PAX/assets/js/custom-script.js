jQuery(window).scroll(function($) {
    if (jQuery(this).scrollTop() > 1){  
        jQuery('.header-top-main').addClass("sticky");
    }
    else{
        jQuery('.header-top-main').removeClass("sticky");
    }
});
jQuery(document).ready(function($)
{

  $(".header-cross-icon").click(function(){
    $.cookie("inforegister", 1, { expires : 6 });
    $(".header-top-content").slideToggle(500);
  });
  
  var cookievalue = $.cookie('inforegister');
  if(cookievalue == 1){
    $('.header-top-content').css('display', 'none');
  }
  else{
    $('.header-top-content').css('display', 'block');
  }
  
});

jQuery(".menu-bar-mobile").click(function($) {
  jQuery(this).toggleClass("open-menu");
  jQuery(".header-navigation-outer").slideToggle();
});
jQuery(".header-search-icon").click(function($) {
  jQuery(this).toggleClass("open-search-menu");
  jQuery(".search-form").slideToggle();
});
