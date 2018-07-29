<div class="short-desc">
    @if(count($productShortDescriptionTop) > 0)
        @foreach($productShortDescriptionTop as $b)
        <div class="content">{!! $b->content !!}</div>
        @endforeach
    @endif
    {!! app()->getLocale()==='cn' ? $product->short_description_cn : $product->short_description !!}
    @if(count($productShortDescriptionBottom) > 0)
        @foreach($productShortDescriptionBottom as $b)
            <div class="content">{!! $b->content !!}</div>
        @endforeach
    @endif
</div>