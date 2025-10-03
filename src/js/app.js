// import { maskInputs } from "./static/inputmask.js";
// import "./parts/menu.js";
// import "./parts/popup.js";
// import "./parts/sliders.js";
// import "./parts/catalog.js";
// import "./parts/show-more.js";
// import { accorden } from "./static/accordeon.js";
// import { runTicker } from "./static/ticker.js";
// import { Fancybox } from "@fancyapps/ui";
// // import { animateOrder } from "./parts/animations.js";
// import { stickyHeader } from "./parts/header.js";

// stickyHeader();
// // animateOrder();
// accorden();
// runTicker()

// maskInputs('+7 (999) 999-99-99', '._mask-phone')

// Fancybox.bind("[data-fancybox]", {
// });

document.addEventListener('click', function (e) {
    let targetEl = e.target;
    if (targetEl.classList.contains('pages-close')) {
        document.querySelector('.pages').classList.toggle('_hide');
    }
})