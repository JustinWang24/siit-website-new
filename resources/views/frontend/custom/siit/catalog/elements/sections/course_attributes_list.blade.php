<div class="content product-additional-wrap pt-40">
    @if(count($product_attributes)>0)
    <h1>{{ app()->getLocale()=='cn' ? $product->name_cn : $product->name }}&nbsp;</h1>
    <hr>
    <ul class="course-special-attributes">
        @foreach($product_attributes as $key=>$product_attribute)
            @if($product_attribute->location == \App\Models\Utils\OptionTool::$LOCATION_ADDITIONAL)
                <li>
                    <h2>
                        <span class="attr-name">{{ trans('general.'.$product_attribute->name) }}:</span>
                        <?php
                        $productAttributeValue = $product_attribute->valuesOf($product);
                        ?>
                        @if(count($productAttributeValue)>0)
                            @if(strlen($productAttributeValue[0]->value) > 20)
                                <br>
                                <div class="attr-value mt-10">
                                    {!! $productAttributeValue[0]->value !!}
                                </div>
                            @else
                                <span class="attr-name">
                                    {!! $productAttributeValue[0]->value !!}
                                </span>
                            @endif
                        @endif
                    </h2>
                </li>
            @endif
        @endforeach
    </ul>
    <hr><br>
    @endif
</div>