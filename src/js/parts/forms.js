"use strict"

import { lockPadding } from "../utils/lockPadding.js";

const url = adminajaxurl.ajaxurl;
const sentPopup = document.querySelector('.popup#thanks');
const errorPopup = document.querySelector('.popup#error');

const allowedFileTypes = [
    'image/x-png',
    'image/png',
    'image/avif',
    'image/webp',
    'image/png',
    'image/jpg',
    'image/jpeg',
    'text/plain',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    '.csv',
    'text/csv',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/msword',
    'application/pdf',
    'application/vnd.ms-powerpoint',
];

document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form')

    if (forms.length) {
        forms.forEach(form => {
            if (form.closest('.basket')) {
                form.addEventListener('submit', async function (e) {
                    e.preventDefault();

                    let error = validateForm(form)

                    let formData = new FormData(form);

                    const formFile = form.querySelector('input[name="file[]"]');
                    if (formFile && formFile.files[0]) {
                        formData.append('file', formFile.files[0]);
                    }

                    formData.append('title', 'Заказ с сайта');

                    const productNames = document.querySelectorAll('.basket__product-name span');
                    const productLinks = document.querySelectorAll('.basket__product-name');
                    const productPrices = document.querySelectorAll('.basket__product-price span');
                    const productQtys = document.querySelectorAll('input[name="quantity"]');

                    formData.append('product_name', productDataToArray(productNames));
                    formData.append('product_link', productDataToArray(productLinks));
                    formData.append('product_price', productDataToArray(productPrices));
                    formData.append('quantity', productDataToArray(productQtys));
                    formData.append('currency', document.querySelector('.filter-currency ._active').textContent)

                    formData.append('page_url', window.location.href);
                    formData.append('action', 'ajax_forms');

                    if (error === 0) {
                        form.classList.add('_sending');

                        let response = await fetch(url, {
                            method: 'POST',
                            body: formData
                        });

                        let result = await response.json();

                        if (response.ok) {
                            form.reset();
                            resetForm(formFile);

                            form.classList.remove('_sending');

                            if (result.show_empty_cart) {
                                document.querySelector('.basket').remove();
                                document.querySelector('main').insertAdjacentHTML('beforeend', result.show_empty_cart);
                                document.querySelectorAll('.cart-count span').forEach(item => item.textContent = 0);
                                window.scrollTo(0, 0)
                            }
                        }
                        else {
                            resetForm(formFile);
                            form.classList.remove('_sending');
                        }
                    }
                    else {
                        fillAllFields(form)
                        resetForm(formFile);
                        form.classList.remove('_sending');
                    }
                })
            }
        })
    }
});

function productDataToArray(data) {
    if (!data) return;
    let arr = []
    data.forEach(item => {
        if (item.href) {
            arr.push(item.href)
        } else if (item.value) {
            arr.push(item.value)
        } else {
            if (item.closest('._product__price')) {
                let price = (item.textContent).replace(/[^0-9]/gi, '');
                arr.push(price)
            } else {
                arr.push(item.textContent)
            }
        }
    })
    return arr;
}

export function checkCheckBoxes(form) {
    const checkBoxContainers = form.querySelectorAll('[data-checkbox-container]')
    if (checkBoxContainers.length) {
        checkBoxContainers.forEach(container => {
            const cehckboxes = container.querySelectorAll('input[type="checkbox"]')

            if (cehckboxes.length) {
                cehckboxes.forEach(checkbox => {
                    checkbox.addEventListener('input', () => {
                        cehckboxes.forEach(item => {
                            if (item != checkbox) {
                                item.checked = false
                            }
                        })
                    })
                })
            }
        })
    }
}

export function validateForm(form) {
    let error = 0;
    const formReq = [...form.querySelectorAll('[data-required] input')].concat([...form.querySelectorAll('[data-required] textarea')])

    for (let i = 0; i < formReq.length; i++) {
        const input = formReq[i]

        formRemoveError(input);
        validateInput()

        input.addEventListener('input', function () {
            formRemoveError(input);
            validateInput()

            if (input.getAttribute('name') === 'summ') {
                input.value = input.value.replace(/[^0-9-\.\,]/g, '');
                input.value = input.value.replace(/[\,]/g, '.');

                if (input.value.indexOf('.') >= 0) {
                    input.value = input.value.replace('.', '');
                }

                if (input.value[0] == 0) {
                    input.value = 0
                }
            }
        })

        function validateInput() {
            if (input.getAttribute('type') === 'email') {
                if (emailTest(input)) {
                    formAddError(input);
                    error++;
                }
            }
            else {
                if (input.getAttribute('name') === 'phone') {
                    if (/[_]/.test(input.value) || input.value.length < 18) {
                        formAddError(input);
                        error++;
                    }
                }
                else if (input.getAttribute('name') === 'nomer') {
                    if (/[_]/.test(input.value) || input.value.length < 11) {
                        formAddError(input);
                        error++;
                    }
                }
                else if (input.getAttribute('name') === 'summ') {
                    if (+input.value <= 0) {
                        formAddError(input);
                        error++;
                    }
                }
                else {
                    if (input.value.length < 2) {
                        formAddError(input);
                        error++;
                    }
                }
            }
        }
    }

    return error;
}

export function formAddError(input) {
    input.closest('.form__item').classList.add('_error');
}

export function formRemoveError(input) {
    input.closest('.form__item').classList.remove('_error');
}

export function emailTest(input) {
    return !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
}

export function sentMessage(form) {
    const activePopup = document.querySelector('.popup._open');
    if (activePopup) {
        activePopup.classList.remove('_open')
    }

    sentPopup.classList.add('_open')
    lockPadding();
}

export function failMessage(form) {
    errorPopup.classList.add('_open')
    lockPadding();
}

export function fillAllFields(form) {
    console.log('Запольните все поля');
}

export function resetForm(formFile) {
    if (formFile) {
        const fileElem = formFile.closest('.file')
        const fileNameElem = fileElem.querySelector('.filename span');
        const deleteFileElem = fileElem.querySelector('._delete-file');

        fileNameElem.innerHTML = 'Прикрепить файл';
        formFile.value = '';

        deleteFileElem.style.display = 'none';
    }
}

export function checkFiles(form) {
    const formFile = form.querySelector('input[name="file[]"]');

    if (!formFile) return;


    const fileElem = formFile.closest('.file')
    const deleteFileElem = fileElem.querySelector('._delete-file');

    let uploadedFiels = fileElem.querySelectorAll('.file-upload')

    formFile.addEventListener('change', () => {
        uploadedFiels = fileElem.querySelectorAll('.file-upload')
        if (uploadedFiels.length) {
            uploadedFiels.forEach(f => f.remove())
        }

        uploadFile(formFile.files);
    });


    deleteFileElem.addEventListener('click', () => {
        formFile.value = '';
        deleteFileElem.style.display = 'none';

        uploadedFiels = fileElem.querySelectorAll('.file-upload')
        if (uploadedFiels.length) {
            uploadedFiels.forEach(f => f.remove())
        }
    })


    function uploadFile(files) {
        [...files].forEach((file, index) => {

            if (!allowedFileTypes.includes(file.type)) {
                alert('Разрешены только текстовые документы и изображения.');
                formFile.value = '';

                deleteFileElem.style.display = 'none';

                return;
            }
            if (file.size > 20 * 1024 * 1024) {
                alert('Файл должен быть менее 20 МБ.');

                deleteFileElem.style.display = 'none';
                return;
            }

            deleteFileElem.style.display = 'block';

            var reader = new FileReader();

            reader.onload = function (e) {
                const newfile = `<div class="file-upload" data-id="${index}">${file.name}</div>`;
                fileElem.insertAdjacentHTML('beforeend', newfile)
            };

            reader.onerror = function (e) {
                alert('Ошибка');
            };

            reader.readAsDataURL(file);
        });
    }
}