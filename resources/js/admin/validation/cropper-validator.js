import { setValidationClass } from "./validation";

// Функция для проверки поля cropper
export default function validateCropper(input) {
    const cropperParent = input.closest('.cropper-parent'); // Находим родительский элемент поля cropper
    const cropperContainer = cropperParent.querySelector('.cropper-actions'); // Находим элемент контейнера поля cropper
    const img = cropperParent.querySelector('img'); // Находим элемент изображения
    const imgSrc = img.getAttribute('src'); // Получаем значение атрибута src элемента изображения

    // Проверка, является ли src пустым или равным '#'
    if (imgSrc === '' || imgSrc === '#') {
        // Если src пустой или равен '#', удаляем класс 'border-dashed' у элемента cropperContainer
        cropperContainer.classList.remove('border-dashed');
        // Вызываем функцию setValidationClass с аргументами cropperContainer и false
        setValidationClass(cropperContainer, false);
    } else {
        // Если src не пустой и не равен '#', удаляем класс 'border-dashed' у элемента cropperContainer
        cropperContainer.classList.remove('border-dashed');
        // Вызываем функцию setValidationClass с аргументами cropperContainer и true
        setValidationClass(cropperContainer, true);
    }

    // Создаем объект MutationObserver для отслеживания изменений атрибута src элемента изображения
    const observer = new MutationObserver((mutationsList) => {
        for (const mutation of mutationsList) {
            // Проверяем, является ли мутация изменением атрибута src
            if (mutation.type === 'attributes' && mutation.attributeName === 'src') {
                const imgSrc = img.getAttribute('src'); // Получаем новое значение атрибута src
                // Проверка, является ли новое значение пустым или равным '#'
                if (imgSrc === '' || imgSrc === '#') {
                    // Если новое значение пустое или равно '#', вызываем функцию setValidationClass с аргументом false
                    setValidationClass(cropperContainer, false);
                } else {
                    // Если новое значение не пустое и не равно '#', вызываем функцию setValidationClass с аргументом true
                    setValidationClass(cropperContainer, true);
                }
            }
        }
    });

    // Запускаем наблюдение за изменениями атрибута src элемента изображения
    observer.observe(img, { attributes: true });
}
