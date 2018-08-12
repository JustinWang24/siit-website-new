@extends(_get_frontend_layout_path('catalog'))
@section('content')
<div class="container mt-20 mb-20 user-profile-manager-app" id="place-order-checkout-app">
    <div class="content pt-20 mt-20">
        <div class="columns is-marginless is-paddingless">
            <div class="column is-7 ">
                <div class="box" style="width: 90%;margin: 0 auto;">
                    <div class="card-body">
                        <h4 class="is-size-4 has-text-link">{{ trans('general.Order_Summary') }}:</h4>
                        <hr class="is-marginless">
                        <p class="columns is-marginless">
                            <span class="column">{{ trans('general.Order_No') }}:</span>
                            <span class="column"><b>{{ $order->serial_number }}</b></span>
                        </p>
                        <p class="columns is-marginless">
                            <span class="column">{{ trans('general.Student_Name') }}:</span>
                            <span class="column"><b>{{ session('user_data.name') }}</b></span>
                        </p>
                        <p class="columns is-marginless">
                            <span class="column">{{ trans('general.Subtotal') }}:</span>
                            <span class="column"><b>{{ config('system.CURRENCY').' '.(number_format($order->total,2)) }}</b></span>
                        </p>
                        <p class="columns is-marginless">
                            <span class="column">{{ trans('general.Total') }}:</span>
                            <span class="column"><b>{{ config('system.CURRENCY').' '.(number_format($order->total,2)) }}</b></span>
                        </p>
                        <div class="is-clearfix"></div>
                    </div>
                </div>
                <div class="box mt-20 mb-20" style="width: 90%;margin: 0 auto;">
                    <?php
                        $orderItemObject = null;
                    /**
                     * @var \App\Models\Catalog\Product $course
                     */
                        $course = null;
                    ?>

                    <div class="card-body">
                        <h4 class="is-size-4 has-text-link">{{ trans('general.Course_Summary') }}:</h4>
                        <hr class="is-marginless">
                        <p class="columns is-marginless">
                            <span class="column">{{ trans('general.Course_Name') }}:</span>
                            <span class="column">
                                <b>
                                    @foreach($order->orderItems as $orderItem)
                                        <?php
                                            $orderItemObject = $orderItem;
                                            $course = $orderItemObject->product;
                                        ?>
                                        {{ $course->getName() }}
                                    @endforeach
                                </b>
                            </span>
                        </p>
                        @if($course->type === \App\Models\Utils\ProductType::$GENERAL_ITEM)
                        <p class="columns is-marginless">
                            <span class="column">{{ trans('general.Campus') }}:</span>
                            <span class="column"><b>{{ $orderItemObject->operator_name }}</b></span>
                        </p>
                        <p class="columns is-marginless">
                            <span class="column">{{ trans('general.Intake') }}:</span>
                            <span class="column"><b>{{ $orderItemObject->intake_start_date ? $orderItemObject->intake_start_date->format('d/M/Y') : 'Anytime' }}</b></span>
                        </p>
                        @else
                            <p class="columns is-marginless">
                                <span class="column">{{ trans('general.Notes') }}:</span>
                                <span class="column"><b>{!! str_replace(PHP_EOL,'<br>',$order->notes) !!}</b></span>
                            </p>
                        @endif
                        <div class="is-clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="column border-box is-marginless pr-20">
                <form method="post" action="{{ url('/frontend/place_order_checkout') }}" id="payment-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="payment_method" value="pm-place-order" id="payment-method-input">
                    <input type="hidden" name="order" value="{{ $order->uuid }}">
                    @include(_get_frontend_theme_path('checkout.elements.payments'))
                    <input type="hidden" name="customerUuid" v-model="customer">
                    <div class="order-notes-wrap">
                        <div class="field">
                            <label class="label">My Notes</label>
                            <textarea class="textarea" name="notes" placeholder="Please leave your notes here ..." rows="3"></textarea>
                        </div>
                    </div>

                    <div class="field mt-10">
                        <label class="label">
                            <input required type="checkbox" name="agree" class="checkbox" checked>
                            I agree to
                            <a target="_blank" class="hyperlink" href="{{ url('/frontend/content/view/terms') }}">Terms and Conditions</a> and <a target="_blank" class="hyperlink" href="{{ url('/frontend/content/view/privacy-policy') }}">Privacy Policy</a>
                        </label>
                    </div>

                    <el-button type="primary" native-type="submit"
                        :disabled="customer.length==0"
                    >Submit Order Now</el-button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection