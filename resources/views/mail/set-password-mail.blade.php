@component('mail::message')
# Your account has been verified by administration !

Hello {{$username}}!<br>
Please click the button below to set a password to your account.

@component('mail::button', ['url' => $url])
Set password
@endcomponent

If you did not create an account, no further action is required.<br>
<br>
Regards,<br>
NCSU, University of Peradeniya

<br>
If you're having trouble clicking the "Set password" button, copy and paste the URL below into your web browser: {{$url}}
@endcomponent
