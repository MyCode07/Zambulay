import dhx from 'dhx-suite'

const formatter = new Intl.NumberFormat("ru");
const ranges = document.querySelectorAll('.input-range');

if (ranges.length) {
    ranges.forEach(range => {

        const slider = range.querySelector('input');
        const currentValue = range.querySelector('.current-value span');

        slider.addEventListener('input', function () {
            const value = this.value;
            currentValue.textContent = formatter.format(value)

            const valueColor = (this.value - this.min) / (this.max - this.min) * 100;

            this.style.background = `linear-gradient(to right, #ffffff 0%, #ffffff ${valueColor}%, rgba(255, 255, 255, 0.3) ${valueColor}%, rgba(255, 255, 255, 0.3) 100%)`;
        });


        range.dispatchEvent(new Event('input'));

        currentValue.textContent = formatter.format(slider.value);
    });
}
