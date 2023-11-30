@if(!empty($menu))
    <h1>Сайдбар</h1>
    <b>{{ $menuTitle }}</b><br>
    @forelse($menu as $children)
        <a class="@if($children->active_menu) active @endif" href="{{ $children->uri }}">{{ $children->name }}</a><br>
    @empty
    @endforelse
@endif
