@component('mail::message')
# Entry Rejection Notifier

Hi {{$name}},

Your Data submission has been rejected due to following key error/errors.
Key Error:
@component('mail::panel')
{{$feedback['keyerror']}}
@endcomponent

Remark:
@component('mail::panel')
{{$feedback['remarks']}}
@endcomponent

Please correct them and resubmit your data using following link ASAP. 
@component('mail::button', ['url' => $url])
Resubmit
@endcomponent

Thanks,<br>
University of Peradeniya
@endcomponent
