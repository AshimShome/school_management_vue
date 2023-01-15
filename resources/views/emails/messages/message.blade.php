@component('mail::message')
# Hello {{ $user->name }}

{{ $message->message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
