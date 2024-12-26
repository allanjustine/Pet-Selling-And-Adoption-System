{{-- blade-formatter-disable --}}
@component('mail::message')
# Account Activation

Dear {{ $user->full_name }},

Thank you for registering to <span class='text-primary font-weight-bold'>{{ config('app.name') }}!</span>

Please click the button below to complete your registration.
This link will expired after 12 hours.

Thank you very much.

@component('mail::button', ['url' => $url, 'color' => 'success'])
Activate your account
@endcomponent

<strong>Having trouble?</strong>
if the above button does not work try copying and pasting this link into your browser:
{{ $url }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
