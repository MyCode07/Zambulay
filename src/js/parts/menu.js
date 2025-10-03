import { lockPadding, unLockPadding } from '../utils/lockPadding.js';

const burger = document.querySelector('.header__burger');
const menu = document.querySelector('.menu');
const searchPopup = document.querySelector('.search');


document.addEventListener('click', function (e) {
    let targetEl = e.target;

    if (targetEl.classList.contains('header__burger')) {
        burger.classList.add('_active');
        menu.classList.add('_open');
        lockPadding();
    }

    if (targetEl.classList.contains('menu-close')) {
        burger.classList.remove('_active');
        menu.classList.remove('_open');
        unLockPadding();
    }

    if (targetEl.hasAttribute('data-open-search')) {
        searchPopup.classList.add('_open');
    }

    if (targetEl.hasAttribute('data-close-search')) {
        searchPopup.classList.remove('_open');
    }

    if (!targetEl.hasAttribute('data-open-search') && !targetEl.closest('.search') && searchPopup && searchPopup.classList.contains('_open')) {
        searchPopup.classList.remove('_open');
    }
})