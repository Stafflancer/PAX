 var swiper = new Swiper(".upcoming-events-slider", {
    cssMode: true,
    speed: 700,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    autoplay: {
        delay: 7500
    },
    mousewheel: true,
    keyboard: true,
});