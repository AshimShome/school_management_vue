@component('mail::message')
# Hello, {{ $user->name }}

## Please use the following credentials to login the application.

@component('mail::panel', [''])
 | Email | {{ $user->email }} |
 | --- | --- |
 | Password | {{ $password }} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

