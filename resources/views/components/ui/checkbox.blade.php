<div class="ui @if(!empty($class)){{$class}}@endif">
    <span class="span-1">
        <span class="span-2">
            <input type="checkbox" class="input" name="checkbox"/>
            <span class="tick">
                <span class="icon">
                    <svg width="14" height="10" viewBox="0 0 14 10">
                        <path d="M1.49 4.885l1.644-1.644 4.385 4.385L5.874 9.27 1.49 4.885zm4.384 1.096L11.356.5 13 2.144 7.519 7.626 5.874 5.98v.001z"></path>
                    </svg>
                </span>
            </span>
        </span>
        <label for="" class="label">{{$label}}</label>
    </span>
</div>
