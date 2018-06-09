@component('mail::message')
# Hi {{ $studentName }}

Your verification code is: {{ $vCode }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
