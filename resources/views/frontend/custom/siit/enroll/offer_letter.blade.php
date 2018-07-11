@extends(_get_frontend_layout_path('frontend'))
@section('content')
    <div class="container mb-20 mt-20">
        <div class="content" id="offer-letter-app">
            <h1>Offer letter</h1>
            <hr>
            <vuejs-signature-pad v-on:sign-confirmed="onSignConfirmed"></vuejs-signature-pad>
        </div>
    </div>
@endsection