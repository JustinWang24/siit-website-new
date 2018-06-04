<div class="content product-additional-wrap pt-40">
    @if(count($product_attributes)>0)
    <h1>{{ $product->name }}&nbsp;</h1>
    <hr>
    <ul class="course-special-attributes">
        @foreach($product_attributes as $key=>$product_attribute)
            @if($product_attribute->location == \App\Models\Utils\OptionTool::$LOCATION_ADDITIONAL)
                <li>
                    <h2>
                        <span class="attr-name">{{ $product_attribute->name }}:</span>
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

    <h1>Courses</h1>
    @foreach($categoryProducts as $categoryProduct)
        <h2>
            <a href="{{ $categoryProduct->product->getProductUrl() }}">{{ $categoryProduct->product->name }}</a>
        </h2>
    @endforeach
</div>