<!-- 产品详情及其他 -->
<div class="content product-additional-wrap pt-40" id="switchable-tabs-app">
    <div class="tabs">
        <ul style="padding-left: 0;">
            @if(!empty($product->description))
            <li class="tab-trigger-btn is-marginless is-active">
                <a href="#product-description-tab-content">{{ trans('general.Description') }}</a>
            </li>
            @endif
        </ul>
    </div>
    <div class="is-clearfix"></div>
    <div id="tab-contents" class="content" style="padding-left: 40px;padding-right: 40px;">
        @if(app()->getLocale() == 'cn')
            @if(!empty($product->description_cn))
                <div class="tab-pane" id="product-description-tab-content">
                    @if(count($productDescriptionTop) > 0)
                        @foreach($productDescriptionTop as $b)
                            <div class="content">{!! $b->content !!}</div>
                        @endforeach
                        <hr>
                        <div class="is-clearfix"></div>
                    @endif
                    {!! $product->description_cn !!}
                    @if(count($productDescriptionBottom) > 0)
                        <div class="is-clearfix"></div>
                        <hr>
                        @foreach($productDescriptionBottom as $b)
                            <div class="content">{!! $b->content !!}</div>
                        @endforeach
                    @endif
                </div>
            @endif
        @else
            @if(!empty($product->description))
                <div class="tab-pane" id="product-description-tab-content">
                    @if(count($productDescriptionTop) > 0)
                        @foreach($productDescriptionTop as $b)
                            <div class="content">{!! $b->content !!}</div>
                        @endforeach
                        <hr>
                        <div class="is-clearfix"></div>
                    @endif
                    {!! $product->description !!}
                    @if(count($productDescriptionBottom) > 0)
                        <div class="is-clearfix"></div>
                        <hr>
                        @foreach($productDescriptionBottom as $b)
                            <div class="content">{!! $b->content !!}</div>
                        @endforeach
                    @endif
                </div>
            @endif
        @endif
    </div>
</div>