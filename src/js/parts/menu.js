import { lockPadding, unLockPadding } from '../utils/lockPadding.js';

const burger = document.querySelector('.header__burger');
const menu = document.querySelector('.menu');


document.addEventListener('click', function (e) {
    let targetEl = e.target;

    if (targetEl.classList.contains('header__burger')) {
        burger.classList.toggle('_active');
        menu.classList.toggle('_open');

        if (menu.classList.contains('_open')) {
            lockPadding();

        } else {
            unLockPadding();
        }
    }

    if (targetEl.classList.contains('menu-close')) {
        burger.classList.remove('_active');
        menu.classList.remove('_open');
        unLockPadding();
    }

    if (targetEl.tagName == 'A' && targetEl.closest('.menu') && document.querySelector('.menu._open')) {
        burger.classList.remove('_active');
        menu.classList.remove('_open');
        unLockPadding();
    }

    if (targetEl.classList.contains('flip-lang') || targetEl.classList.contains('current-lang')) {
        targetEl.closest('.lang').classList.toggle('_open');
    }
})