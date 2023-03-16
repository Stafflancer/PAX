// var swiper = new Swiper(".testimonials-slider", {
//     pagination: {
//        el: ".swiper-pagination",
//     },
//     autoplay: {
//         delay: 5500,
//         disableOnInteraction: false,
//     },
// });

 var swiper = new Swiper('.testimonials-slider', {
    pagination: '.swiper-pagination',
    slidesPerView: 1,
    paginationClickable: true,
    mousewheelControl: true,
    parallax: true,
    speed: 200,
    pagination: {
        el: ".swiper-pagination",
        clickable: true
    },
    autoplay: {
        delay: 1500,
        disableOnInteraction: false,
    },

});