import { setValidationClass } from "./validation";

// Функция для проверки select
export default function validateSelect(select) {
    const tomSelect = select.tomselect; // Получаем объект Tom Select из свойства "tomselect" элемента "select"

    // Вызываем функцию setValidationClass и передаем в нее аргументы select.nextElementSibling и выражение tomSelect.isValid === true
    // Это выражение проверяет, является ли выбранный элемент действительным в объекте Tom Select
    setValidationClass(select.nextElementSibling, tomSelect.isValid === true);

    // Назначаем обработчик события "change" на объекте Tom Select
    tomSelect.on('change', function () {
        // При изменении значения выбранного элемента, вызываем функцию setValidationClass с аргументами select.nextElementSibling и выражение tomSelect.isValid === true
        // Это обновляет класс валидации для следующего элемента после "select" в зависимости от его действительности в объекте Tom Select
        setValidationClass(select.nextElementSibling, tomSelect.isValid === true);
    });
}
