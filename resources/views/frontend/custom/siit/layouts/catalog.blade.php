<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" ⚡>
@include('layouts.frontend.head')
<body style="{{ \Illuminate\Support\Facades\URL::current() == url('/') ? null : 'background-color: #f9f8f8;' }}">
@if($agentObject->isPhone())
    @include(_get_frontend_layout_path('frontend.header.general'))
    @include( _get_frontend_layout_path('frontend.session_flash_msg_box'))
    @yield('content')
    @include( _get_frontend_layout_path('frontend.footer') )
    @include( _get_frontend_layout_path('frontend.floating_box'))
@else
    @include(_get_frontend_layout_path('frontend.header.general'))
    @include( _get_frontend_layout_path('frontend.session_flash_msg_box'))
    @yield('content')
    @include( _get_frontend_layout_path('frontend.footer') )
    @include( _get_frontend_layout_path('frontend.floating_box'))
@endif

@include( _get_frontend_layout_path('frontend.js') )
</body>
</html>