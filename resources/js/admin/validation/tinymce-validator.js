import { setValidationClass, validateElement } from "./validation";

// Функция для проверки TinyMCE
export function validateTinyMce(input) {
    const editor = tinymce.get(input.id); // Получаем объект TinyMCE редактора по его идентификатору
    const editorContainer = input.closest('[data-controller="tinymce"]'); // Находим ближайший родительский элемент редактора TinyMCE с атрибутом 'data-controller="tinymce"'
    const toxContainer = editorContainer.querySelector('.tox-tinymce'); // Находим элемент "tox-tinymce" внутри родительского элемента
    setValidationClass(toxContainer, editor.getContent({ format: 'text' }).trim() !== '', true);

    function validateTinyMCEAndSetInputValue() {
        input.value = editor.getContent(); // Устанавливаем значение входного элемента равным содержимому редактора TinyMCE
        setValidationClass(toxContainer, editor.getContent({ format: 'text' }).trim() !== '', true);
    }

    // Назначаем обработчики событий 'keyup' и 'change' на редакторе TinyMCE
    editor.on('keyup', validateTinyMCEAndSetInputValue);
    editor.on('change', validateTinyMCEAndSetInputValue);
}

// Функция для обработки события 'keyup' на элементах TinyMCE
export function TinyMCEKeyUpEvent() {
    const editors = document.querySelectorAll('.tinymce[required="required"]'); // Находим все элементы TinyMCE с атрибутом 'required="required"'
    editors.forEach((input) => validateElement(input)); // Вызываем функцию validateElement для каждого элемента
}
