/**
 * Declaração dos swipers
 * Exemplo:
 * let swiper = new Swiper(".swiper-teste", {opcoes})
 */

new Swiper(".banner-swiper", {
    autoplay: {
        delay: 9000,
        disableOnInteraction: false,
    },
    rewind: true,
    navigation: {
        nextEl: ".banner-swiper .swiper-button-next",
        prevEl: ".banner-swiper .swiper-button-prev",
    },
    pagination: {
        el: ".banner-swiper .swiper-pagination",
        type: "bullets",
        clickable: true,
    },
});

new Swiper(".swiper-gallery", {
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    effect: "fade",
    rewind: true,
    slidesPerView: 1,
    spaceBetween: 1,
    navigation: {
        nextEl: ".swiper-gallery .swiper-button-next",
        prevEl: ".swiper-gallery .swiper-button-prev",
    },
    pagination: {
        el: ".swiper-gallery .swiper-pagination",
        type: "bullets",
        dynamicBullets: true,
        clickable: true,
    },
});

new Swiper(".solution-image-swiper", {
    autoplay: {
        delay: 9000,
        disableOnInteraction: false,
    },
    rewind: true,
    navigation: {
        nextEl: ".solution-image-swiper .swiper-button-next",
        prevEl: ".solution-image-swiper .swiper-button-prev",
    },
    pagination: {
        el: ".solution-image-swiper .swiper-pagination",
        type: "bullets",
        clickable: true,
    },
});

new Swiper(".swiper-projects", {
    initialSlide: 1,
    rewind: true,
    centeredSlides: true,
    slidesPerView: 1,
    spaceBetween: 20,
    navigation: {
        nextEl: ".swiper-projects .swiper-button-next",
        prevEl: ".swiper-projects .swiper-button-prev",
    },
    pagination: {
        el: ".swiper-projects .swiper-pagination",
        type: "bullets",
        dynamicBullets: true,
        clickable: true,
    },
    breakpoints: {
        992: {
            slidesPerView: 2,
        },
    },
});

new Swiper(".swiper-company", {
    initialSlide: 1,
    rewind: true,
    centeredSlides: true,
    slidesPerView: 1,
    spaceBetween: 20,
    navigation: {
        nextEl: ".swiper-company .swiper-button-next",
        prevEl: ".swiper-company .swiper-button-prev",
    },
    pagination: {
        el: ".swiper-company .swiper-pagination",
        type: "bullets",
        dynamicBullets: true,
        clickable: true,
    },
});

new Swiper(".parceiros-swiper", {
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    rewind: true,
    slidesPerView: 2,
    spaceBetween: 20,
    centerInsufficientSlides: true,
    navigation: {
        nextEl: ".parceiros-swiper .swiper-button-next",
        prevEl: ".parceiros-swiper .swiper-button-prev",
    },
    pagination: {
        el: ".parceiros-swiper .swiper-pagination",
        type: "bullets",
        dynamicBullets: true,
        clickable: true,
    },
    breakpoints: {
        767: {
            slidesPerView: 3,
        },
        992: {
            slidesPerView: 4,
            spaceBetween: 35,
        },
        1200: {
            slidesPerView: 5,
            spaceBetween: 35,
        },
    },
});
new Swiper(".parceiros-swiper", {
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    rewind: true,
    slidesPerView: 2,
    spaceBetween: 20,
    centerInsufficientSlides: true,
    navigation: {
        nextEl: ".parceiros-swiper .swiper-button-next",
        prevEl: ".parceiros-swiper .swiper-button-prev",
    },
    pagination: {
        el: ".parceiros-swiper .swiper-pagination",
        type: "bullets",
        dynamicBullets: true,
        clickable: true,
    },
    breakpoints: {
        767: {
            slidesPerView: 3,
        },
        992: {
            slidesPerView: 4,
            spaceBetween: 35,
        },
        1200: {
            slidesPerView: 5,
            spaceBetween: 35,
        },
    },
});
new Swiper(".brands-swiper", {
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    rewind: true,
    slidesPerView: 3,
    spaceBetween: 20,
    centerInsufficientSlides: true,
    navigation: {
        nextEl: ".brands-swiper .swiper-button-next",
        prevEl: ".brands-swiper .swiper-button-prev",
    },
    pagination: {
        el: ".brands-swiper .swiper-pagination",
        type: "bullets",
        dynamicBullets: true,
        clickable: true,
    },
    breakpoints: {
        767: {
            slidesPerView: 3,
        },
        992: {
            slidesPerView: 4,
            spaceBetween: 35,
        },
        1200: {
            slidesPerView: 5,
            spaceBetween: 35,
        },
    },
});

new Swiper(".products-swiper", {
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    rewind: true,
    slidesPerView: 1,
    spaceBetween: 20,
    centerInsufficientSlides: true,
    navigation: {
        nextEl: ".products-swiper .swiper-button-next",
        prevEl: ".products-swiper .swiper-button-prev",
    },
    pagination: {
        el: ".products-swiper .swiper-pagination",
        type: "bullets",
        dynamicBullets: true,
        clickable: true,
    },
    breakpoints: {
        767: {
            slidesPerView: 2,
        },
        992: {
            slidesPerView: 3,
            spaceBetween: 35,
        },
        1200: {
            slidesPerView: 4,
            spaceBetween: 35,
        },
    },
});

new Swiper(".swiper-brands", {
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    rewind: true,
    slidesPerView: 1,
    spaceBetween: 20,
    centerInsufficientSlides: true,
    navigation: {
        nextEl: ".swiper-brands .swiper-button-next",
        prevEl: ".swiper-brands .swiper-button-prev",
    },
    pagination: {
        el: ".swiper-brands .swiper-pagination",
        type: "bullets",
        dynamicBullets: true,
        clickable: true,
    },
    breakpoints: {
        767: {
            slidesPerView: 3,
        },
        992: {
            slidesPerView: 4,
            spaceBetween: 35,
            loop: false,
            rewind: true,
        },
        1200: {
            slidesPerView: 5,
            spaceBetween: 35,
        },
    },
});

// Conta quantos slides de depoimentos existem
const testimonialSlidesCount = document.querySelectorAll(".swiper-testimonials .swiper-slide").length;

const testimonialSwiper = new Swiper(".swiper-testimonials", {
    rewind: true,
    slidesPerView: 1,
    spaceBetween: 20,
    centeredSlides: testimonialSlidesCount >= 3, // Só centraliza se tiver 3 ou mais
    centerInsufficientSlides: true,
    initialSlide: 0, 
    navigation: {
        nextEl: ".swiper-testimonials .swiper-button-next",
        prevEl: ".swiper-testimonials .swiper-button-prev",
    },
    pagination: {
        el: ".swiper-testimonials .swiper-pagination",
        type: "bullets",
        dynamicBullets: true,
        clickable: true,
    },
    breakpoints: {
        992: {
            slidesPerView: testimonialSlidesCount >= 3 ? 3 : testimonialSlidesCount,
            spaceBetween: testimonialSlidesCount >= 3 ? 0 : 40,
            centeredSlides: testimonialSlidesCount >= 3,
            initialSlide: testimonialSlidesCount >= 3 ? 1 : 0, // Só começa no meio se tiver 3+
        },
        1200: {
            slidesPerView: testimonialSlidesCount >= 3 ? 3 : testimonialSlidesCount,
            spaceBetween: testimonialSlidesCount >= 3 ? 0 : 40,
            centeredSlides: testimonialSlidesCount >= 3,
            initialSlide: testimonialSlidesCount >= 3 ? 1 : 0, // Só começa no meio se tiver 3+
        },
    },
});

$(".swiper-testimonials .video").on("click", function () {
    testimonialSwiper.autoplay.stop();
});

new Swiper(".swiper-differentials", {
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    rewind: true,
    slidesPerView: 1,
    spaceBetween: 15,
    centerInsufficientSlides: true,
    navigation: {
        nextEl: ".swiper-differentials .swiper-button-next",
        prevEl: ".swiper-differentials .swiper-button-prev",
    },
    pagination: {
        el: ".swiper-differentials .swiper-pagination",
        type: "bullets",
        dynamicBullets: true,
        clickable: true,
    },
    breakpoints: {
        767: {
            slidesPerView: 2,
        },
        992: {
            slidesPerView: 3,
        },
        1200: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    },
});
