@extends(_get_frontend_layout_path('frontend'))
@section('content')
    <div class="container mb-20 mt-20">
        <div class="content pt-20 mt-20" id="offer-letter-app">
            @include('frontend.custom.siit.enroll.offer_letter.page_1')
            <br>
            @include('frontend.custom.siit.enroll.offer_letter.page_2')
            <br>
            @include('frontend.custom.siit.enroll.offer_letter.page_3')
            <br>
            @include('frontend.custom.siit.enroll.offer_letter.page_4')
            <br>
            @include('frontend.custom.siit.enroll.offer_letter.page_5')
            <br>
            @include('frontend.custom.siit.enroll.offer_letter.page_6')
            <br>
            @include('frontend.custom.siit.enroll.offer_letter.page_7')
            <br>
            @include('frontend.custom.siit.enroll.offer_letter.page_8')
            <div class="page-pad pt-20">
                <h3 class="has-text-centered">Please sign here&nbsp;<i class="fas fa-arrow-circle-down"></i></h3>
                <vuejs-signature-pad v-on:sign-confirmed="onSignConfirmed" message-before-signing="{{ trans('general.message_before_sign') }}"></vuejs-signature-pad>
            </div>
        </div>
    </div>
@endsection