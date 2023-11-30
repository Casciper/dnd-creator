{{--
    Блок для отображения SEO-текста внизу страницы.
    Подключается на каждой странице в layout.blade.php
--}}

@if(!empty($seo) && !empty($seo->text))
<div class="container">
    <div class="seo">
        @if(!empty($seo->seo_title))
            <h3 class="title">{{$seo->seo_title}}</h3>
        @endif
        <p class="text">{{$seo->text}}</p>
        @if(!empty($seo->image))
            <img src="{{$seo->image}}" alt="seo">
        @endif
    </div>
</div>
@endif
