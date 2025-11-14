import "./parts/menu.js";
import "./parts/tabs.js";
// import "./parts/calc.js";
import "./parts/popup.js";
import "./parts/select.js";
import { stickyHeader } from "./parts/header.js";
import { toTop } from "./static/to-top.js";
import { accorden } from "./static/accordeon.js";

stickyHeader();
toTop();
accorden();

document.addEventListener('click', function (e) {
    let targetEl = e.target;
    if (targetEl.classList.contains('pages-close')) {
        document.querySelector('.pages').classList.toggle('_hide');
    }
})
