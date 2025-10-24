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

    const rate = 0.0015
    let surcharge = 0
    let percents = 0

    const amountInputCredit = document.querySelector('input[name="credit-value"]')
    const periodCredit = document.querySelector('input[name="credit-period"]')
    const totalCredit = document.querySelector('.calc-item__credit .total-value')
    const percentCredit = document.querySelector('.calc-item__credit .total-percent')

    if (amountInputCredit && periodCredit) {
        calc(amountInputCredit, periodCredit, totalCredit, percentCredit)

        amountInputCredit.addEventListener('input', () => {
            calc(amountInputCredit, periodCredit, totalCredit, percentCredit)
        })
        periodCredit.addEventListener('input', () => {
            calc(amountInputCredit, periodCredit, totalCredit, percentCredit)
        })
    }

    const amountDeposit = document.querySelector('input[name="deposit-value"]')
    const periodDeposit = document.querySelectorAll('input[name="deposit-period"]')
    const totalDeposit = document.querySelector('.calc-item__deposit .total-value')
    const percentDeposit = document.querySelector('.calc-item__deposit .total-percent')

    if (amountDeposit && periodDeposit) {
        let periodEl = Array.from(periodDeposit).find(radio => radio.checked);

        calc(amountDeposit, periodEl, totalDeposit, percentDeposit)

        amountDeposit.addEventListener('input', () => {
            calc(amountDeposit, periodEl, totalDeposit, percentDeposit)
        })

        periodDeposit.forEach(item => {
            item.addEventListener('input', () => {
                periodEl = Array.from(periodDeposit).find(radio => radio.checked);
                calc(amountDeposit, periodEl, totalDeposit, percentDeposit)
            })
        })
    }

    function calc(amountEl, periodEl, totalEl, percentEl) {
        let amount = +amountEl.value.replace(/\D/gi, '');
        let time = +periodEl.value.replace(/\D/gi, '');

        surcharge = amount * time * rate

        let total = Math.floor(amount + surcharge);

        percents = (time * rate * 100).toFixed(1);
        if (percents.includes('.0')) {
            percents = percents.replace('.0', '')
        }

        if (periodEl.dataset.percent) {
            percents = (15 / 360) * time
            total = Math.floor(amount + (amount * percents) / 100);
        }

        totalEl.querySelector('label').textContent = formatter.format(total)
        totalEl.querySelector('input').value = formatter.format(total)

        percentEl.querySelector('label').textContent = percents
        percentEl.querySelector('input').value = percents
    }
}
