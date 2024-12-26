{{-- blade-formatter-disable --}}
@component('mail::message')

Dear {{ $user }},

{!! $message !!}

@component('mail::button', ['url' => $route, 'color' => 'primary'])
Visit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
