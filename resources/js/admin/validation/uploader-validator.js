import { setValidationClass } from "./validation";

// Функция для проверки загрузчика файлов
export function validateUploader() {
    const dropzoneWrappers = document.querySelectorAll('.dropzone-wrapper[data-required="required"]'); // Находим все элементы с классом 'dropzone-wrapper' и атрибутом 'data-required="required"'
    dropzoneWrappers.forEach(function (dropzoneWrapper) {
        const dropzone = Dropzone.forElement(dropzoneWrapper); // Получаем объект Dropzone для каждого элемента
        if (dropzone) {
            const uploadField = dropzoneWrapper.querySelector('.uploader-field'); // Находим элемент с классом 'uploader-field' внутри элемента 'dropzoneWrapper'
            const uploaderDataInput = dropzoneWrapper.querySelector('.uploader-data'); // Находим элемент с классом 'uploader-data' внутри элемента 'dropzoneWrapper'
            setValidationClass(uploadField, dropzone.files.length !== 0, true); // Устанавливаем класс валидации для 'uploadField' в зависимости от количества файлов в 'dropzone'
            getValue(dropzone, uploaderDataInput); // Вызываем функцию getValue для установки значения 'uploaderDataInput'

            dropzone.on('addedfile', function () {
                setValidationClass(uploadField, dropzone.files.length !== 0, true); // При добавлении файла обновляем класс валидации для 'uploadField'
                getValue(dropzone, uploaderDataInput); // Вызываем функцию getValue для обновления значения 'uploaderDataInput'
            });

            dropzone.on('removedfile', function () {
                setValidationClass(uploadField, dropzone.files.length !== 0, true); // При удалении файла обновляем класс валидации для 'uploadField'
                getValue(dropzone, uploaderDataInput); // Вызываем функцию getValue для обновления значения 'uploaderDataInput'
            });
        }
    });
}

// Функция инициализации проверки Dropzone
export function dropZoneInitCheck() {
    const dropzoneWrappers = document.querySelectorAll('.dropzone-wrapper[data-required="required"]'); // Находим все элементы с классом 'dropzone-wrapper' и атрибутом 'data-required="required"'
    dropzoneWrappers.forEach(function (dropzoneWrapper) {
        const dropzone = Dropzone.forElement(dropzoneWrapper); // Получаем объект Dropzone для каждого элемента
        if (dropzone) {
            const uploaderDataInput = dropzoneWrapper.querySelector('.uploader-data'); // Находим элемент с классом 'uploader-data' внутри элемента 'dropzoneWrapper'
            getValue(dropzone, uploaderDataInput); // Вызываем функцию getValue для установки значения 'uploaderDataInput'

            dropzone.on('addedfile', function () {
                getValue(dropzone, uploaderDataInput); // При добавлении файла вызываем функцию getValue для обновления значения 'uploaderDataInput'
            });

            dropzone.on('removedfile', function () {
                getValue(dropzone, uploaderDataInput); // При удалении файла вызываем функцию getValue для обновления значения 'uploaderDataInput'
            });
        }
    });
}

// Вспомогательная функция для установки значения
function getValue(dropzone, input) {
    if (input) {
        input.value = dropzone.files.length === 0 ? '' : dropzone.files.length; // Устанавливаем значение 'input' в зависимости от количества файлов в 'dropzone'
    }
}
