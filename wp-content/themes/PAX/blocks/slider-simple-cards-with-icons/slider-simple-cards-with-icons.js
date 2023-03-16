var swiper = new Swiper(".slider-simple-card-slider", {
	slidesPerView: 4,
    spaceBetween: 23,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    autoplay: {
        delay: 5500
    },
    breakpoints: {
        1: {
            slidesPerView: 1,
        },
        575: {
            slidesPerView: 2, 
            
        },
        991: {
            slidesPerView: 3,
        },
        1200: {
            slidesPerView: 4,
        }
    },
});