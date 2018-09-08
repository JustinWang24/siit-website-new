<div class="column is-one-quarter" style="margin-top: 1px;">
    <h2 class="parent-item">
        {{ ucwords(str_replace('_',' ',$menuName)) }}
    </h2>
    <hr>
    <div class="content-title-line">
        <h3 class="is-size-5 pl-10">
            @if($menuName=='my_profile')
            <i class="far fa-check-square"></i>&nbsp;{{ trans('general.My_Profile') }}
            @else
            <a href="{{ url('frontend/my_profile/'.session('user_data.uuid')) }}">
                {{ trans('general.My_Profile') }}
            </a>
            @endif
        </h3>
    </div>
    <div class="content-title-line">
        <h3 class="is-size-5 pl-10">
            @if($menuName=='orders_history')
                <i class="far fa-check-square"></i>&nbsp;{{ trans('general.Orders_History') }}
            @else
                <a href="{{ url('frontend/my_orders/'.session('user_data.uuid')) }}">
                    {{ trans('general.Orders_History') }}
                </a>
            @endif
        </h3>
    </div>
    <div class="content-title-line">
        <h3 class="is-size-5 pl-10">
            @if($menuName=='my_courses')
                <i class="far fa-check-square"></i>&nbsp;{{ trans('general.My_Courses') }}
            @else
                <a href="{{ url('frontend/my_courses') }}">
                    {{ trans('general.My_Courses') }}
                </a>
            @endif
        </h3>
    </div>
</div>