@component('mail::message')
    # New Application
    @foreach($data as $key=>$value)
        {{ ucfirst($key) }}: {{ $value }}
    @endforeach
    Regards!
    SIIT
@endcomponent