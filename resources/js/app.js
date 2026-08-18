import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import { Fancybox } from '@fancyapps/ui';

window.Alpine = Alpine;
window.Fancybox = Fancybox;

document.addEventListener('alpine:init', () => {
    // Custom Alpine components can go here
});

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    // Initialize Swiper instances
    const swiperElements = document.querySelectorAll('.swiper-container');
    
    swiperElements.forEach((el) => {
        let config = {
            modules: [Navigation, Pagination, Autoplay],
            slidesPerView: 1,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            }
        };

        // Custom config based on data attributes
        if (el.dataset.slidesDesktop) {
            config.breakpoints = {
                640: { slidesPerView: parseInt(el.dataset.slidesTablet) || 2 },
                1024: { slidesPerView: parseInt(el.dataset.slidesDesktop) || 3 }
            };
        }

        new Swiper(el, config);
    });

    // Initialize Fancybox
    Fancybox.bind("[data-fancybox]", {
        Thumbs: {
            minCount: 2,
        },
        Toolbar: {
            display: {
                left: ["counter"],
                right: ["toggleFull", "autoplay", "fullscreen", "thumbs", "close"],
            },
        },
        on: {
            "Carousel.settle": (fancybox) => {
                try {
                    const carousel = fancybox.getCarousel();
                    const pageIndex = carousel ? carousel.getPageIndex() : 0;
                    window.dispatchEvent(new CustomEvent('fancybox:settle', { detail: { index: pageIndex } }));
                } catch (err) {}
            }
        }
    });
});

