<div class="content-block content-half">
    <div class="content-title-line">
        <h3>{{ trans('general.Customer') }}</h3>
    </div>
    <div class="content-detail-wrap">
        <div class="content-line">
            <label>{{ trans('general.Name') }}: </label>
            <label class="value">{{ $order->customer->name }}</label>
        </div>
        <div class="content-line">
            <label>{{ trans('general.Email') }}: </label>
            <label class="value">{{ $order->customer->email }}</label>
        </div>
        <div class="content-line">
            <label>{{ trans('general.Phone') }}: </label>
            <label class="value">{{ $order->customer->studentProfile->phone_number }}</label>
        </div>
        <div class="content-line">
            <label>{{ trans('general.Address') }}: </label>
            <label class="value">{{ $order->customer->studentProfile->current_address }},{{ $order->customer->studentProfile->province_current }} {{ $order->customer->studentProfile->post_code_current }} {{ $order->customer->studentProfile->country_current }}</label>
        </div>
    </div>
</div>