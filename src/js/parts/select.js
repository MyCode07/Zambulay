const selects = document.querySelectorAll('select');
if (selects) {
    selects.forEach(item => {
        let isOpen = false;

        item.addEventListener('change', function () {
            if (this.value === "") {
                this.classList.remove('_active');
                item.closest('div').classList.remove('_open');

            } else {
                this.classList.add('_active');
                item.closest('div').classList.add('_open');
            }
        });


        item.addEventListener('click', function () {
            item.closest('div').classList.toggle('_open');
        });
    })
}
