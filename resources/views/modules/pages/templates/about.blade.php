@extends('layout')

@section('content')
    @include('components.breadcrumbs')
    @include('pages.components.sidebar')
    @if(!empty($page))
        {{ dd($page) }}
    @endif
@endsection
