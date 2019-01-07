@extends(_get_frontend_layout_path('catalog'))
@section('content')
    <div class="container mt-20 mb-20 user-profile-manager-app" id="user-profile-manager-app">
        <div class="content">
            <div class="columns is-marginless">
                @include(_get_frontend_theme_path('customers.elements.dashboard.left_nav'))

                <div class="column is-three-quarter content-block content-two-third-right">
                    <div class="content-title-line">
                        <h3>My Courses</h3>
                    </div>
                    <div class="content-detail-wrap">
                        <ul>
                            @if($orders && count($orders)>0)
                                @foreach($orders as $order)
                                    @php
/** @var \App\Models\Order\Order $order */
                                    @endphp
                                <li style="margin-bottom: 30px;">
                                    @foreach($order->orderItems as $orderItem)
                                        @php
                                            /** @var \App\Models\Order\OrderItem $orderItem */
                                        @endphp
                                        <h6>{{ $orderItem->product->getProductName() }} ({{ $orderItem->product->getBrand()->name }})
                                            {{ $orderItem->intake_start_date? $orderItem->intake_start_date->format('d-M-Y'):null }}
                                            {{ $orderItem->finish_date? ' - '.$orderItem->finish_date->format('d-M-Y'):null }}
                                        </h6>
                                        {!! $orderItem->notes !!}
                                    @endforeach
                                </li>
                                @endforeach
                            @else
                            <li>You don't have any course yet!</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection