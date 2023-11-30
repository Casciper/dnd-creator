import modalFormSubmitValidation from "./validate-modal-form"; // Импорт функции для валидации модальной формы при отправке
import validateInput from "./input-validator"; // Импорт функции для валидации поля input
import validateSelect from "./select-validator"; // Импорт функции для валидации поля select
import validateCropper from "./cropper-validator"; // Импорт функции для валидации кроппера
import {validateUploader, dropZoneInitCheck} from "./uploader-validator"; // Импорт функций для валидации загрузчика
import {validateTinyMce, TinyMCEKeyUpEvent} from "./tinymce-validator"; // Импорт функций для валидации TinyMCE

initialization(); // Вызов функции инициализации
document.addEventListener('turbo:load', initialization); // Добавление слушателя события turbo:load для повторного вызова инициализации

function formSubmitValidation(elem, parent, event) {
    elem.addEventListener(event, () => {
        const requiredInputs = parent.querySelectorAll('input[required], textarea[required], select[required]'); // Получение всех обязательных полей внутри родительского элемента
        requiredInputs.forEach((element) => {
            validateElement(element); // Валидация каждого обязательного поля
        });
        validateUploader(); // Валидация загрузчика
    });
}

export function validateElement(element) {
    if (element.classList.contains('cropper-path')) { // Проверка, является ли элемент кроппером
        validateCropper(element); // Валидация кроппера
        element.addEventListener('change', () => validateCropper(element)); // Добавление слушателя события change для повторной валидации кроппера
    } else if (element.classList.contains('tinymce')) { // Проверка, является ли элемент TinyMCE
        validateTinyMce(element); // Валидация TinyMCE
    } else if (element.tagName.toLowerCase() === 'select') { // Проверка, является ли элемент выпадающим списком
        validateSelect(element); // Валидация выпадающего списка
        element.addEventListener('change', () => validateSelect(element)); // Добавление слушателя события change для повторной валидации выпадающего списка
    } else {
        validateInput(element); // Валидация полем ввода
        element.addEventListener('input', () => validateInput(element)); // Добавление слушателя события input для повторной валидации поля ввода
    }
}

export function setValidationClass(element, isValid) {
    const validationClassList = element.classList;
    const successClass = 'validation-success'; // Класс для успешной валидации
    const errorClass = 'validation-error'; // Класс для неуспешной валидации

    if (isValid) {
        validationClassList.remove(errorClass); // Удаление класса неуспешной валидации
        validationClassList.add(successClass); // Добавление класса успешной валидации
    } else {
        validationClassList.remove(successClass); // Удаление класса успешной валидации
        validationClassList.add(errorClass); // Добавление класса неуспешной валидации
    }
}

function initialization() {
    let form = document.getElementById('post-form'); // Получение формы с id "post-form"
    let modalForm = document.querySelectorAll('.modal-content'); // Получение всех элементов с классом "modal-content"

    TinyMCEKeyUpEvent(); // Вызов функции для обработки события keyup в TinyMCE редакторе

    formSubmitValidation(form, form, 'submit'); // Вызов функции валидации формы при отправке
    modalForm.forEach((form) => {
        let modalFormBtn = form.querySelector('button[type="submit"]'); // Получение кнопки отправки формы внутри модального окна
        if (modalFormBtn) {
            formSubmitValidation(modalFormBtn, form, 'click'); // Вызов фронтовой валидации формы при клике на кнопку отправки
            modalFormSubmitValidation(modalFormBtn, form); // Вызов функции валидации модальной формы при клике для показа ошибок с бэка
        }
    });
    setTimeout(() => {
        dropZoneInitCheck(); // Вызов функции инициализации загрузчика через 300 мс
    }, 300);
}
