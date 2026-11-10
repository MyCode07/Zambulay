const forms = document.querySelectorAll('.form form');

if (forms.length) {
    forms.forEach((form) => {
        const inputs = [...form.querySelectorAll('input')].filter(
            (input) => !['hidden', 'submit', 'button', 'reset'].includes(input.type)
        );

        const buttons = form.querySelectorAll(
            'button[type="submit"], button:not([type]), input[type="submit"]'
        );

        const touched = new Set();
        const errors = new Map();

        // Проверяем и отображаем ошибки самостоятельно.
        form.noValidate = true;

        function isValid(input) {
            if (input.disabled) return true;

            const value = input.value.trim();

            if (input.required && value.length < 2) return false;

            // Необязательный email проверяем, только если он заполнен.
            if (input.type === 'email' && value) {
                return !input.validity.typeMismatch;
            }

            return true;
        }

        function renderError(input) {
            const invalid = !isValid(input);
            let error = errors.get(input);

            input.setAttribute('aria-invalid', String(invalid));

            if (invalid && !error) {
                error = document.createElement('span');
                error.className = 'error';
                input.insertAdjacentElement('afterend', error);
                errors.set(input, error);
            } else if (!invalid && error) {
                error.remove();
                errors.delete(input);
            }

            if (invalid && error) {
                const invalidEmail = input.type === 'email' &&
                    input.value.trim() !== '' && input.validity.typeMismatch;

                error.textContent = (invalidEmail
                    ? input.dataset.invalidEmail
                    : input.dataset.errorText) || input.dataset.errorText || 'Проверьте правильность заполнения';
            }
        }

        function updateButtons() {
            const valid = inputs.every(isValid);

            buttons.forEach((button) => {
                button.disabled = !valid;
            });

            return valid;
        }

        inputs.forEach((input) => {
            input.addEventListener('blur', () => {
                touched.add(input);
                renderError(input);
                updateButtons();
            });

            input.addEventListener('input', () => {
                if (touched.has(input)) renderError(input);
                updateButtons();
            });

            input.addEventListener('change', () => {
                if (touched.has(input)) renderError(input);
                updateButtons();
            });
        });

        form.addEventListener('submit', (event) => {
            // Блокирует отправку невалидной формы, в том числе через Enter.
            if (!updateButtons()) {
                event.preventDefault();

                inputs.forEach((input) => {
                    touched.add(input);
                    renderError(input);
                });

                inputs.find((input) => !isValid(input))?.focus();
            }
        });

        form.addEventListener('reset', () => {
            // Значения полей сбрасываются после события reset.
            setTimeout(() => {
                touched.clear();

                inputs.forEach((input) => {
                    errors.get(input)?.remove();
                    input.removeAttribute('aria-invalid');
                });

                errors.clear();
                updateButtons();
            }, 0);
        });

        updateButtons();
    })
}
