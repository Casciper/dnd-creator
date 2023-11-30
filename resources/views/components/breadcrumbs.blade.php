@if(Breadcrumbs::has())
    <div class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
        @foreach (Breadcrumbs::current() as $crumbs)
            @if ($crumbs->url() && !$loop->last)
                <a itemprop="itemListElement" itemscope
                   itemtype="https://schema.org/ListItem"
                   class="link" href="{{ $crumbs->url() }}">
                    <span itemprop="item">{{ $crumbs->title() }}</span>
                </a>
                <span class="divider">/</span>
            @else
                <span class="active">{{ $crumbs->title() }}</span>
            @endif
            <meta itemprop="position" content="{{ $loop->iteration }}" />
        @endforeach
    </div>
@endif
