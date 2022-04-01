@component('mail::message')
# Get Started

Hello {{$name}}!<br>
Your account has been created on the {{env('APP_NAME')}} by the university administration.<br><br>

Below are your system generated credentials,<br>
Please change the password immediately after login.
<br>

Username<br>
{{$username}}<br>

Password<br>
{{$password}}

@component('mail::button', ['url' => route('login')])
LOGIN TO YOUR ACCOUNT
@endcomponent

Regards,<br>
NCSU, University of Peradeniya

<br>
We've sent this to you as part of our Welcome to {{env('APP_NAME')}} by the University Administration.
@endcomponent
