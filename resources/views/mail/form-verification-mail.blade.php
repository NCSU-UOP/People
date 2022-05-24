@component('mail::message')
# You’re nearly there!

Hello {{$username}}!<br>
Please click the button below to verify your email address.

@component('mail::button', ['url' => $url])
Verify Email Address
@endcomponent

If you did not create an account, no further action is required.<br>
<br>
Regards,<br>
NCSU, University of Peradeniya

<br>
If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser: {{$url}}
@endcomponent
