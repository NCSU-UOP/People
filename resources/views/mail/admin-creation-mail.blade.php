@component('mail::message')
# You’re nearly there!

Hello {{$name}}!<br>
Please click the button below to login to the system.
<br><br>

Followings are your credentials<br>
Username = {{$username}}<br>
Password = {{$password}}<br>

@component('mail::button', ['url' => route('login')])
Login
@endcomponent

{{-- If you did not create an account, no further action is required.<br> --}}
<br>
Regards,<br>
NCSU, University of Peradeniya

{{-- <br> --}}
{{-- If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser: {{$url}} --}}
@endcomponent
