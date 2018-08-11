<div class="price-wrap hidden-first">
    <?php
    $specialPrice = $product->getSpecialPriceGST();
    $originPrice = $product->getDefaultPriceGST();
    ?>
    @if($specialPrice)
        <div>
        <span class="special-price-txt has-text-danger">
            {{ config('system.CURRENCY') }}
            @{{ formatPriceText(specialPriceDisplay) }}
            ({{ trans('general.GST_include') }})
        </span>
        <span class="origin-price-txt">
            {{ config('system.CURRENCY') }}
            @{{ formatPriceText(originPriceDisplay) }}
        </span>
        </div>
    @else
        <p class="price-default-txt has-text-danger">
            {{ config('system.CURRENCY') }}
            @{{ formatPriceText(originPriceDisplay) }} ({{ trans('general.GST_include') }})
        </p>
    @endif
</div>


