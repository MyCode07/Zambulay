const btnsMore = document.querySelectorAll('._more-text');

if (btnsMore.length) {
    btnsMore.forEach(btn => {
        const hidden = btn.previousElementSibling

        if (hidden) {
            btn.addEventListener('click', () => {
                btn.classList.toggle('_active')

                if (btn.classList.contains('_active')) {
                    btn.textContent = btn.dataset.textHide
                }
                else {
                    btn.textContent = btn.dataset.textShow
                }

                hidden.classList.toggle('_active')
            })
        }
    })
}