import './../../vendor/power-components/livewire-powergrid/dist/powergrid'
import flatpickr from "flatpickr";

import TomSelect from "tom-select";
window.TomSelect = TomSelect


import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';


const swiper = new Swiper('.swiper', {
    loop: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    slidesPerView: 1,
    spaceBetween: 20,
    breakpoints: {
        640: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
    },
});

