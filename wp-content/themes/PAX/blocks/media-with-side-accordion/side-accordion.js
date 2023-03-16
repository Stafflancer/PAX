// jQuery(document).ready(function($){
// 	$(".accordion-contant").first().css('display', 'block');
// 	$(".accordion-title").click(function(){
// 		$(this).parent(".accordion-item").next(".accordion-contant").slideToggle();
// 		$(this).parent(".accordion-item").prevAll(".accordion-item").find(".accordion-contant").slideUp();
// 		$(this).parent(".accordion-item").nextAll(".accordion-item").find(".accordion-contant").slideUp();
// 	});
// });       

jQuery(document).ready(function($){
  $('.accordion .accordion-outer > .accordion-contant').hide();
    
  $('.accordion .accordion-outer').click(function() {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active").find(".accordion-contant").slideUp();
    } else {
      $(".accordion .accordion-outer.active .accordion-contant").slideUp();
      $(".accordion .accordion-outer.active").removeClass("active");
      $(this).addClass("active").find(".accordion-contant").slideDown();
    }
    return false;
  });
  
});