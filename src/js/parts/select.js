const selects = document.querySelectorAll('select');
if (selects) {
    selects.forEach(item => {
        item.addEventListener('change', function () {
            if (this.value === "") {
                this.classList.remove('_active');
            } else {
                this.classList.add('_active');
            }
        });
    })
}
