import "./parts/menu.js";
import "./parts/tabs.js";
import "./parts/calc.js";
import "./parts/select.js";
import { stickyHeader } from "./parts/header.js";

stickyHeader();


document.addEventListener('click', function (e) {
    let targetEl = e.target;
    if (targetEl.classList.contains('pages-close')) {
        document.querySelector('.pages').classList.toggle('_hide');
    }
})
