
import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { EffectCards, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/effect-cards';
import 'swiper/css/pagination';

window.Alpine = Alpine;

Alpine.start();

document.querySelectorAll('[data-members-swiper]').forEach((element) => {
    new Swiper(element, {
        modules: [EffectCards, Pagination],
        effect: 'cards',
        grabCursor: true,
        slidesPerView: 1,
        centeredSlides: true,
        initialSlide: 0,
        threshold: 8,
        cardsEffect: {
            perSlideOffset: 10,
            perSlideRotate: 1,
            rotate: true,
            slideShadows: false,
        },
        pagination: {
            el: element.querySelector('.swiper-pagination'),
            clickable: true,
        },
        on: {
            slideChangeTransitionEnd(swiper) {
                if (swiper.swipeDirection !== 'prev') {
                    return;
                }

                const previousSlide = swiper.slides[swiper.previousIndex];
                const form = previousSlide?.querySelector('[data-swipe-form]');

                if (form instanceof HTMLFormElement) {
                    form.requestSubmit();
                }
            },
        },
    });
});
