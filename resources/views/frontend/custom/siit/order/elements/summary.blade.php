<div class="content-block content-half">
    <div class="content-title-line">
        <h3>{{ trans('general.Summary') }}</h3>
    </div>
    <div class="content-detail-wrap">
        <div class="content-line">
            <label>{{ trans('general.Date') }}: </label>
            <label class="value">{{ substr($order->created_at,0, 11) }}</label>
        </div>
        <div class="content-line">
            <label>{{ trans('general.Total') }}: </label>
            <label class="value">{{ config('system.CURRENCY') }} {{ number_format($order->total,2) }}</label>
        </div>
        <div class="content-line">
            <label>{{ trans('general.Place_Order_#') }}: </label>
            <label class="value"><b class="text-primary">{{ $order->place_order_number }}</b></label>
        </div>
    </div>
</div>