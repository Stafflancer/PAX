var swiper = new Swiper(".cards-tooltip-slider", {
	slidesPerView: 3,
    spaceBetween: 24,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    autoplay: {
        delay: 5500
    },
    breakpoints: {
    // when window width is >= 320px
    320: {
      slidesPerView: 1,
    },
    // when window width is >= 480px
    767: {
      slidesPerView: 2,
    },
    // when window width is >= 480px
    991: {
      slidesPerView: 3,
    }
  }
});