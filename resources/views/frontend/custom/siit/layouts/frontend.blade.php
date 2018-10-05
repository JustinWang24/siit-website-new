<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.frontend.head')
<body class="has-navbar-fixed-top">
@if($agentObject->isPhone())
    <!-- Mobile Version -->
    @include('layouts.frontend.mobile.nav')
    <main id="panel">
        <header>
            @include('layouts.frontend.mobile.header_mobile')
        </header>
        <section id="main">
            @if( \Illuminate\Support\Facades\URL::current() == url('/') )
                <div>
                    <img src="{{ asset('/images/frontend/h1.png') }}" alt="a bridge across cultures">
                </div>
            @endif
            <div class="container is-fluid">
                @include('layouts.frontend.session_flash_msg_box')
                <div id="panel">
                    @yield('content')
                </div>
                @include( _get_frontend_layout_path('frontend.social_media_section') )
                @include('layouts.frontend.footer')
            </div>
        </section>
    </main>
@else
    @if( \Illuminate\Support\Facades\URL::current() == url('/') )
        @include(_get_frontend_layout_path('frontend.header.home'))
    @else
        @include(_get_frontend_layout_path('frontend.header.general'))
    @endif
    @include( _get_frontend_layout_path('frontend.session_flash_msg_box'))
    @yield('content')
    @include( _get_frontend_layout_path('frontend.social_media_section') )
    @include( _get_frontend_layout_path('frontend.footer') )
    @include( _get_frontend_layout_path('frontend.floating_box'))
@endif
@include( _get_frontend_layout_path('frontend.js') )
</body>
</html>