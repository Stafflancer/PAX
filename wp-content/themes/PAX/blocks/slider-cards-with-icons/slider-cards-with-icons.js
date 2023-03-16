var swiper = new Swiper(".cards-slider", {
	slidesPerView: 3,
    spaceBetween: 0,
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
        768: {
            slidesPerView: 2, 
            
        },
        991: {
            slidesPerView: 3,
        }
    },
});