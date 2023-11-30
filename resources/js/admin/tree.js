initialization()
document.addEventListener('turbo:load', initialization);

// Метод для поиска родителей страницы
function showPageAndParents(page) {
    page.style.display = 'block';
    let parent = page.parentElement.closest('.list');
    if (parent) {
        let parentIndex = parent.parentElement.dataset.branch;
        let currentPageIndex = page.dataset.branch;

        // Отображаем родителя только если он соответствует части индекса текущей страницы
        if (currentPageIndex.startsWith(parentIndex)) {
            showPageAndParents(parent.parentElement);
        }
    }
}

// Метод для поиска детей страницы
function showPageAndChildren(page) {
    page.style.display = 'block';
    let children = page.querySelectorAll('.list > li');
    children.forEach(function (child) {
        let childIndex = child.dataset.branch;
        let currentPageIndex = page.dataset.branch;

        // Отображаем ребенка только если его индекс начинается с индекса текущей страницы
        if (childIndex.startsWith(currentPageIndex)) {
            showPageAndChildren(child);
        }
    });
}

// Метод для вывода дерева по искомому названию страницы
function searchTree(query) {
    let tree = document.querySelectorAll('.main-list li');

    // Скрываем все элементы списка перед выполнением поиска
    tree.forEach(function (page) {
        page.style.display = 'none';
    });

    // Проходим по каждому элементу списка
    tree.forEach(function (page) {
        let pageName = page.querySelector('.label .page-name').textContent;
        let isMatch = pageName.toLowerCase().includes(query.toLowerCase());

        // Если найдено совпадение, отображаем страницу и ее родителей
        if (isMatch) {
            showPageAndParents(page);
            showPageAndChildren(page);
            uncollapse()
        }
    });
}

// Скрипт аккордиона
function tree() {
    document.querySelectorAll('.closed-img').forEach(function (closedImg) {
        closedImg.addEventListener('click', function (event) {
            let label = this.parentNode;
            let parent = label.parentNode;
            let list = label.nextElementSibling;

            if (parent.classList.contains('is-open')) {
                list.style.display = 'none';
                parent.classList.remove('is-open');
                label.querySelector('.closed-img').classList.remove('open');
            } else {
                list.style.display = 'block';
                parent.classList.add('is-open');
                label.querySelector('.closed-img').classList.add('open');
            }
        });
    });
}

// Событие скрытия всех страниц в аккордеоне
function collapse() {
    document.querySelectorAll('.list').forEach(function (list) {
        let parent = list.parentNode;
        parent.classList.remove('is-open');
        list.style.display = 'none';
    });

    document.querySelectorAll('.has-children').forEach(function (parent) {
        parent.classList.remove('is-open');
    });

    document.querySelectorAll('.closed-img').forEach(function (closedImg) {
        closedImg.classList.remove('open');
    });
}

// Событие раскрытия всех страниц в аккордеоне
function uncollapse() {
    let parentList = document.querySelectorAll('.parent > .list');

    parentList.forEach(function (list) {
        list.style.display = 'block';
    });

    document.querySelectorAll('.has-children').forEach(function (parent) {
        parent.classList.add('is-open');
    });

    document.querySelectorAll('.closed-img').forEach(function (closedImg) {
        closedImg.classList.add('open');
    });
}

// Создаем функцию debounce
function debounce(func, delay) {
    let timeoutId;
    return function (...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(this, args), delay);
    };
}

// инициализация методов
function initialization() {
    setTimeout(() => {
        let input = document.getElementById('search-tree');
        if (input) {
            tree()
            document.querySelector('.uncollapse-all').addEventListener('click', uncollapse);
            document.querySelector('.collapse-all').addEventListener('click', collapse);

            input.addEventListener('input', debounce(function () {
                let query = input.value;
                searchTree(query);
            }, 200)); // Задержка в 200 миллисекунд
        }
    }, 300)
}


