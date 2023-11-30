{{--
    Блок для мета-информации.
    Например: подключение фавиконов, счетчиков (Яндекс.Метрика, Google Analytics) и т.д.
--}}

{{-- START: Генерация title и description для страницы --}}
@php
    use Illuminate\Support\Facades\View;
    /** @var  $seo \App\Models\Seo */

         $commonTitle = 'template';
         $commonDescription = 'descr';

             if (!empty($seo) && !empty($seo->getTitle())) {
                  $commonTitle = $seo->getTitle();
              } elseif (View::hasSection('title')) {
                  $commonTitle = trim(View::yieldContent('title')) . " | WANNGO - интернет-магазин обуви оптом";
              }
              if (!empty($titlePage) && $titlePage !== 1) {
                  $commonTitle .= ' | Страница ' . $titlePage;
              }

              if(!empty($seo) && !empty($seo->getDescription())) {
                  $commonDescription = $seo->getDescription();
              } elseif (View::hasSection('description')) {
                  $commonDescription = trim(View::yieldContent('description'));
              }

@endphp
<title>{{strip_tags($commonTitle)}}</title>
<meta name="description" content="{{strip_tags($commonDescription)}}}">
{{-- END: Генерация title и description для страницы --}}
