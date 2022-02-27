@component('mail::message')
# Nachricht von {{ $attributes['name'] }}

E-Mail: {{ $attributes['mail'] }}

{!! $attributes['message'] !!}

{{ config('app.name') }}
@endcomponent