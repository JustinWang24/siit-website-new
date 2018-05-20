<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.frontend.head')
<body>
@if($agentObject->isPhone())
    <!-- Mobile Version -->
    @include('layouts.frontend.mobile.nav')
    <main id="panel">
        <header>
            @include('layouts.frontend.mobile.header_mobile')
        </header>
        <section id="main" class="section">
            <div class="container is-fluid">
                @include('layouts.frontend.session_flash_msg_box')
                <div id="panel">
                    @yield('content')
                </div>
                @include('layouts.frontend.footer')
            </div>
        </section>
    </main>
@else
    <!-- Header Start -->
    @if( \Illuminate\Support\Facades\URL::current() == url('/') )
        @include(_get_frontend_layout_path('frontend.header.home'))
    @else
        @include(_get_frontend_layout_path('frontend.header.general'))
    @endif
    <!-- Header End -->

    @include( _get_frontend_layout_path('frontend.session_flash_msg_box'))
    @yield('content')
    @include( _get_frontend_layout_path('frontend.footer') )
    @include( _get_frontend_layout_path('frontend.floating_box'))

@endif

@include( _get_frontend_layout_path('frontend.js') )
</body>
</html>