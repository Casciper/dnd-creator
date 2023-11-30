@php
    $isLoginPage = request()->getRequestUri() === '/admin/login';
        $logo = $isLoginPage ? '/assets/img/admin/logo-black.svg' : '/assets/img/admin/logo-white.svg';
        $additionalClass = $isLoginPage ? ' mb-4 row justify-content-center' : '';
        $width = $isLoginPage ? 125 : 250;
        $height = $isLoginPage ? 90 : 125;
@endphp
<a href="/admin/home" class="logo-admin-container{{ $additionalClass }}"
   style="display:block;@if($isLoginPage)max-width: 300px;margin: 0 auto;@endif">
    <img class="admin-logo" src="{{ $logo }}" style="max-width: 100%">

    <p class="h2 n-m font-thin v-center">
    <span class="m-l d-none d-sm-block">
    </span>
    </p>
</a>
