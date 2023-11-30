import {setValidationClass} from "./validation";

function sendModalForm(form) {
    let formBtn = form.querySelector('button[type="submit"]'); // Ищем кнопку отправки формы
    const formData = new FormData(form); // Создаем объект FormData из формы
    const xhr = new XMLHttpRequest(); // Создаем объект XMLHttpRequest
    setFormId(form, formData); // Вызываем функцию setFormId для установки идентификатора формы
    xhr.open('POST', '/ajax/send-modal'); // Устанавливаем метод и URL запроса
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) { // Проверяем состояние запроса
            if (xhr.status === 200) { // Проверяем статус ответа
                const response = JSON.parse(xhr.responseText); // Разбираем ответ в формате JSON

                if (response.success) { // Проверяем значение свойства 'success' в ответе
                    checkRequiredInput(form); // Вызываем функцию checkRequiredInput, если 'success' равно true
                } else {
                    const errors = response.errors; // Получаем массив ошибок из ответа
                    const errorBlock = document.createElement('div'); // Создаем элемент div для блока ошибок
                    const errorTitle = document.createElement('p'); // Создаем элемент p для заголовка ошибок
                    const errorList = document.createElement('ul'); // Создаем элемент ul для списка ошибок
                    createErrorBlock(errorBlock, errorTitle, errorList); // Вызываем функцию createErrorBlock для создания блока ошибок

                    Object.values(errors).forEach(function (error, index) { // Проходимся по массиву ошибок
                        createErrorList(errorList, error); // Вызываем функцию createErrorList для создания элементов списка ошибок
                        let errorInput = form.querySelector(`[name="item[${Object.keys(errors)[index]}]"]`)// Получаем инпут ошибки
                        setValidationClass(errorInput, false); // вызываем функцию setValidationClass с аргументами errorInput и false
                    });

                    const modalHeader = document.querySelector('.modal-header'); // Находим элемент с классом 'modal-header'
                    modalHeader.parentNode.insertBefore(errorBlock, modalHeader.nextSibling); // Вставляем блок ошибок после элемента 'modalHeader'

                    scrollToErrorInput(form, errors); // вызываем функцию скроллинга к первому элементу с ошибкой
                    toggleBtnState(formBtn,false);
                }
            } else {
                // Обработка ошибки
            }
        }
    };
    xhr.send(formData); // Отправляем запрос с данными формы
}

function createErrorBlock(errorBlock, errorTitle, errorList) {
    errorBlock.classList = 'error-block alert alert-danger rounded shadow-sm mb-3 p-4'; // Устанавливаем классы для блока ошибок
    errorTitle.insertAdjacentHTML('afterbegin', '<strong>О нет! </strong> Измените пару вещей и повторите попытку.'); // Вставляем HTML внутрь заголовка ошибок
    errorBlock.appendChild(errorTitle); // Добавляем заголовок ошибок в блок ошибок
    errorBlock.appendChild(errorList); // Добавляем список ошибок в блок ошибок
}

function createErrorList(errorList, error) {
    const errorElement = document.createElement('li'); // Создаем элемент li для ошибки
    errorElement.insertAdjacentHTML('afterbegin', error); // Вставляем текст ошибки внутрь элемента li
    errorList.appendChild(errorElement); // Добавляем элемент li в родительский список
}

function setFormId(form, formData) {
    const modalBody = form.querySelector('.modal-body'); // Находим элемент с классом 'modal-body' внутри формы
    const firstChild = modalBody.firstElementChild; // Находим первый дочерний элемент элемента 'modalBody'
    const id = firstChild.getAttribute('id'); // Получаем значение атрибута 'id' первого дочернего элемента
    formData.append('item[modal_id]', id); // Добавляем значение атрибута 'id' в объект FormData с ключом 'item[modal_id]'
}

function checkRequiredInput(form) {
    const requiredInputs = form.querySelectorAll('input[required], textarea[required], select[required]'); // Находим все обязательные поля внутри формы
    let hasEmptyField = false; // Инициализируем флаг hasEmptyField как false
    requiredInputs.forEach(input => { // Проходимся по всем обязательным полям
        if (input.value.trim() === '') { // Проверяем, является ли значение поля пустым
            hasEmptyField = true; // Если значение пустое, устанавливаем флаг hasEmptyField в true
        }
    });

    if (hasEmptyField) { // Если есть пустые поля
        requiredInputs[0].focus(); // Устанавливаем фокус на первое пустое поле
    } else { // Если нет пустых полей
        const errorBlock = form.querySelector('.error-block'); // Находим блок ошибок внутри формы
        if (errorBlock) { // Если блок ошибок существует
            errorBlock.remove(); // Удаляем блок ошибок
        }
        form.submit(); // Отправляем форму
    }
}

function scrollToErrorInput(form, errors){
    const errorKeys = Object.keys(errors); // Получаем массив ключей из объекта ошибок
    if (errorKeys.length > 0) { // Проверяем, есть ли ключи в массиве
        const firstErrorKey = errorKeys[0]; // Получаем первый ключ
        const inputWithError = form.querySelector(`[name="item[${firstErrorKey}]"]`); // Находим элемент с именем первого ключа
        const offsetTop = inputWithError.offsetTop - 100; // Получаем вертикальное смещение элемента
        const modal = form.closest('.modal'); // Находим ближайший родительский элемент с классом "modal"
        modal.scrollTo({ top: offsetTop, behavior: 'smooth' }); // Скроллим до позиции с учетом смещения

        modal.addEventListener('scroll', function handleScroll() {
            if (modal.scrollTop === offsetTop) {
                inputWithError.focus(); // Устанавливаем фокус на элемент после окончания прокрутки
                modal.removeEventListener('scroll', handleScroll); // Удаляем обработчик события scroll
            }
        });
    }
}

function setOpacityToChildren(parentElement, opacity) {
    const childElements = parentElement.querySelectorAll('*');

    childElements.forEach(function(element) {
        element.style.opacity = opacity;
    });
}

// Метод работает на все формы кроме confirm в скринах списка для подтверждения дейтсвий
function toggleBtnState(btn, isSend) {
    const circle = '<span class="spinner-loading position-absolute top-50 start-50 translate-middle"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></span>';
    if (isSend) {
        setOpacityToChildren(btn, '0');
        btn.classList = 'btn btn-default cursor-wait btn-loading';
        btn.disabled = true;
        btn.insertAdjacentHTML('beforeend', circle);
    } else {
        btn.querySelector('.spinner-loading').remove();
        btn.classList = 'btn btn-default';
        setOpacityToChildren(btn, '1');
        btn.disabled = false;
    }
}

export default function modalFormSubmitValidation(elem, form) {
    elem.addEventListener('click', (e) => {
        e.preventDefault(); // Отменяем действие по умолчанию
        const errorBlock = document.querySelector('.error-block'); // Находим блок ошибок на странице
        if (errorBlock) { // Если блок ошибок существует
            errorBlock.remove(); // Удаляем блок ошибок
        }
        toggleBtnState(elem, true);
        sendModalForm(form); // Вызываем функцию sendModalForm для отправки формы
    });
}
