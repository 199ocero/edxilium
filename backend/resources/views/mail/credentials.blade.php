@component('mail::message')
# User Credentials

After you verified your email address, please use this credentials to login:

Email: {{$email}}
<br>
Password: {{$password}}
<br>
<br>
<strong>Note: </strong>It is advisable to change your password after login.
{{-- Please change the link when deployed to server --}}
@component('mail::button', ['url' => 'http://localhost:8080/login'])
Login
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
