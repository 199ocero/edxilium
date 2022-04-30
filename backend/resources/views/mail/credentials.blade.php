@component('mail::message')
# User Credentials

After you verified your email address, please use this credentials to login:

Email: {{$email}}
<br>
Password: {{$password}}

{{-- Please change the link when deployed to server --}}
@component('mail::button', ['url' => 'http://localhost:8080/login'])
Login
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
