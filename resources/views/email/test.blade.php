@component('mail::message')
{{-- # {{ $type }} --}}# test email

{{-- {{ $content }} --}}    Testing purpose.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
