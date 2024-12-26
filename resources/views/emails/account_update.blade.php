{{-- blade-formatter-disable --}}
@component('mail::message')

Dear {{ $user->full_name }}, <br> <br>

@if ($user->is_activated == true)
Thank you for waiting. Your account is now reactivated. You can now use your Furfect Account to access our application.
@endif

@if ($user->is_activated == false)
Unfortunatetly there are circumstances that you did not totally comply and the administrator chooses to deactivate
your Furfect Account. Any Questions? you can email us at app.furfect@gmail.com <br>
Remark: {{ $request['remark'] ?? "N/A" }}
@endif

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Redirect
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent















