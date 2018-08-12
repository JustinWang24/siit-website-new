<?php
/**
 * 当产品的option是下拉列表时
 */
if($product_option->items){
$uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
?>
<div class="product-option-input-wrap mb-10">
    <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label has-text-left" style="font-size: 18px;">

                @if('Language' == $product_option->name)
                    {{ trans('general.Proposed_Language') }}
                @else
                    {{ trans('general.'.$product_option->name) }}
                @endif

            </label>
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <div class="select full-width">
                        <select class="select full-width" v-on:change="dropDownClickedHandler($event, {{ $product_option->id }})"
                                name="product_option_{{ $product_option->id }}"
                                id="product_option_{{ $uuid }}"
                                data-type="product_option"
                                data-value="{{ $product_option->id }}">
                            @foreach($product_option->items as $key=>$item)
                                <option value="{{ $item->id }}" data-value="{{ $item->extra_value }}">
                                    {{ trans('general.'.$item->label) }}
                                    {{ $item->extra_value > 0 ? '+'.config('system.CURRENCY').number_format($item->extra_value,2) : null }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="invalid-feedback-product_option_{{ $uuid }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>