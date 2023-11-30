import { setValidationClass } from "./validation";

// Функция для проверки input
export default function validateInput(input) {
    // Вызываем функцию setValidationClass и передаем в нее аргументы input и выражение input.value.trim() !== ''
    // Это выражение проверяет, является ли значение входного элемента непустым, удаляя пробелы по краям
    setValidationClass(input, input.value.trim() !== '');
}
