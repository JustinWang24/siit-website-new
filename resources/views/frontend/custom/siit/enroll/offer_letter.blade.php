@extends(_get_frontend_layout_path('frontend'))
@section('content')
    <div class="container mb-20 mt-20">
        <div class="content pt-20 mt-20" id="offer-letter-app">
            @for($i=1;$i<=16;$i++)
                @include('frontend.custom.siit.enroll.offer_letter.page_'.$i)
                <br>
            @endfor
            <div class="page-pad pt-20">
                <h3 class="has-text-centered">Please sign here&nbsp;<i class="fas fa-arrow-circle-down"></i></h3>
                <vuejs-signature-pad v-on:sign-confirmed="onSignConfirmed" message-before-signing="{{ trans('general.message_before_sign') }}"></vuejs-signature-pad>
            </div>
        </div>
    </div>
@endsection