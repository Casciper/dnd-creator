<ul class="list">
    @if($children->isNotEmpty())
        @foreach($children as $key => $child)
            <li class="parent @if($child->children->isNotEmpty()) has-children @endif" data-branch="{{$parentKey.'-'.$key}}">
                <div class="label" @if($child->children->isEmpty()) style="padding-left: 18px" @endif>
                    @if($child->children->isNotEmpty())
                        <span class="closed-img"></span>
                    @endif
                    <img class="type-img" src="/assets/img/admin/tree/{{$child->getPageType()}}.svg" alt="">
                    <a href="{{ route('platform.pages.edit', [$child->id]) }}"
                       class="page-name @if($child->is_active) active @endif">{{$child->name}}</a>
                    <span class="uri">{{$child->uri}}</span>
                </div>
                @if($child->children->isNotEmpty())
                    @include('admin.page-tree.list',['children' => $child->children, 'parentKey' => $parentKey.'-'.$key])
                @endif
            </li>
        @endforeach
    @endif
</ul>
