<div class="content-block">
    <div class="content-title-line">
        <h3>{{ trans('general.Order_Items') }}</h3>
    </div>
    <div class="content-detail-wrap content">
        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ trans('general.Product') }}</th>
                <th scope="col">{{ trans('general.Price') }}</th>
                <th scope="col">{{ trans('general.QTY') }}</th>
                <th scope="col">{{ trans('general.Subtotal') }}</th>
                <th scope="col">{{ trans('general.GST') }}</th>
                <th scope="col">{{ trans('general.Total') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->orderItems as $key=>$value)
                <tr>
                    <?php
                    /**
                     * @var \App\Models\Order\OrderItem $value
                     */
                    $specialPrice = $value->product->getSpecialPriceGST();
                    $defaultPrice = $value->product->getDefaultPriceGST();
                    $product = $value->product;
                    ?>
                    <td>{{ $key+1 }}</td>
                    <td>
                        {{ $product->name }}
                        @foreach($value->orderItems as $orderItem)
                            @php
                                /**
                                * @var \App\Models\Order\OrderItem $orderItem
                                */
                            @endphp
                            <p>{{ app()->getLocale()=='cn' ? $orderItem->product->name_cn : $orderItem->product->name }}</p>
                            <p>{{ trans('general.Intake') }}: {{ str_replace('00:00:00','',$orderItem->intake_start_date) }}</p>
                        @endforeach
                        <div class="option-notes">
                            {!! $value->notes !!}
                        </div>
                    </td>
                    <td>
                        @if($specialPrice)
                            <span>{{ config('system.CURRENCY') }} {{ $specialPrice }}</span>
                            <span class="origin-price-txt text-danger">{{ config('system.CURRENCY') }} {{ $defaultPrice }}</span>
                        @else
                            <span>{{ config('system.CURRENCY') }} {{ $defaultPrice }}</span>
                        @endif
                    </td>
                    <td>
                        {{ $value->quantity }}
                    </td>
                    <td>
                        {{ config('system.CURRENCY'). ' '.number_format($value->subtotal/1.1,2) }}
                    </td>
                    <td>
                        {{ config('system.CURRENCY'). ' '.number_format($value->subtotal-$value->subtotal/1.1,2) }}
                    </td>
                    <td>
                        {{ config('system.CURRENCY'). ' '.number_format($value->subtotal,2) }}
                    </td>
                </tr>
            @endforeach
            <tr class="em">
                <?php
                    $total_final = $order->getTotalFinal();
                ?>
                <td></td>
                <td></td>
                <td>

                </td>
                <td>
                    {{ trans('general.Total') }}
                </td>
                <td>
                    {{ config('system.CURRENCY'). ' '.number_format($total_final/1.1,2) }}
                </td>
                <td>
                    {{ config('system.CURRENCY'). ' '.number_format($total_final-$total_final/1.1,2) }}
                </td>
                <td>
                    {{ config('system.CURRENCY'). ' '.number_format($total_final,2) }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>