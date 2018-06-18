<div class="column is-one-quarter" style="margin-top: 1px;">
    <h2 class="parent-item">
        {{ ucwords(str_replace('_',' ',$menuName)) }}
    </h2>
    <hr>
    <div class="content-title-line">
        <h3 class="is-size-5 pl-10">
            @if($menuName=='my_profile')
            <i class="far fa-check-square"></i>&nbsp;My Profile
            @else
            <a href="{{ url('frontend/my_profile/'.session('user_data.uuid')) }}">
                My Profile
            </a>
            @endif
        </h3>
    </div>
    <div class="content-title-line">
        <h3 class="is-size-5 pl-10">
            @if($menuName=='orders_history')
                <i class="far fa-check-square"></i>&nbsp;Orders History
            @else
                <a href="{{ url('frontend/my_orders/'.session('user_data.uuid')) }}">
                    Orders History
                </a>
            @endif
        </h3>
    </div>
    <div class="content-title-line">
        <h3 class="is-size-5 pl-10">
            @if($menuName=='my_courses')
                <i class="far fa-check-square"></i>&nbsp;My Courses
            @else
                <a href="{{ url('frontend/my_courses') }}">
                    My Courses
                </a>
            @endif
        </h3>
    </div>
</div>