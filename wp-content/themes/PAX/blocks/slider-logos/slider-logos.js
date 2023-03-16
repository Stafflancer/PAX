var swiper = new Swiper(".slider-logos-swiper", {
    slidesPerView: 6,
    slidesPerColumn: 1,
    spaceBetween: 24,
       autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    breakpoints: {
        320: {
            slidesPerView: 2,
            slidesPerColumn: 3,
            spaceBetween: 12,
              grid: {
                rows: 3,
            },
        },
        767: {
            slidesPerView: 2,
            slidesPerColumn: 3,
              grid: {
                rows: 3,
            },
        },
        991: {
            slidesPerView: 3,
            slidesPerColumn: 3,
              grid: {
                rows: 2,
              },
        },
        1200: {
            slidesPerView: 6,
            slidesPerColumn: 1,
        }
    }
});