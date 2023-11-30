@extends('layout')
@section('content')
    @include('components.breadcrumbs')
    @include('pages.components.sidebar')
    <div class="container">
        @if(!empty($page))
            @if(!empty($page->children))
                <h1>Дети</h1>
                @foreach($page->children as $children)
                    <a href="{{ $children->uri }}">{{ $children->name }}</a><br>
                @endforeach
            @endif
            {{ dd($page) }}
        @endif
    </div>
@endsection
