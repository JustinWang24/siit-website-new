<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.backend.head')
<body>
@include('layouts.dealer.nav')
<main id="panel">
    <header>
        @include('layouts.dealer.header')
    </header>
    <section id="main" class="section is-paddingless">
        <div class="container">
            @include('layouts.backend.session_flash_msg_box')
            <div id="panel">
                @yield('content')
            </div>
        </div>
        @include('layouts.backend.footer')
    </section>
</main>
@include('layouts.backend.js')
</body>
</html>