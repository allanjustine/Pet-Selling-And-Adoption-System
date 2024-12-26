{{-- blade-formatter-disable --}}
@component('mail::message')

Dear {{ $adoption->user->full_name }},

@if($adoption->status == \App\Models\Adoption::APPROVED)
We're pleased to inform you that your pet, <span style="font-weight: bold; color: #C66930">{{ $adoption->pet_name }}</span> has been approved. You are now able to proceed with pet adoption service.
@endif

@if($adoption->status == \App\Models\Adoption::DECLINED)
Hello! Unfortunately, due to certain circumstances, your pet registration request has been rejected by Furfect as it does not meet the required criteria.  <br>
@endif
Any questions? You can visit our frequently asked question page or email us at app.furfect@gmail.com
@component('mail::button', ['url' => $url, 'color' => 'primary'])
Redirect
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent




















