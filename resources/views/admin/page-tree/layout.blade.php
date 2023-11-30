<div class="bg-white rounded shadow-sm mb-3 page-tree-container">
    @if($pages->isNotEmpty())
        <div class="command-bar">
            <div class="search-bar">
                <input autocomplete="off" aria-autocomplete="none" type="text" name="name" placeholder="Поиск"
                       id="search-tree">
            </div>
            <button type="button" class="uncollapse-all">Раскрыть всё</button>
            <button type="button" class="collapse-all">Скрыть всё</button>
        </div>

        <div class="list-container">
            @include('admin.page-tree.container')
        </div>
    @else
        <div class="d-md-flex align-items-center px-md-0 px-2 w-100 text-md-start text-center">
            <div>
                <h3 class="fw-light">В настоящее время нет отображаемых объектов</h3>
                Импортируйте или создайте объекты, или проверьте обновления позже
            </div>
        </div>
    @endif
</div>

