{{-- blade-formatter-disable --}}
@component('mail::message')

Dear {{ $seller->user->full_name }}, <br> <br>

@if ($seller->status == \App\Models\SellerAccount::APPROVED)
Congratulations! Your account seller account has been approved. You can now use your Furfect Seller Account to access our application.
@endif

@if ($seller->status == \App\Models\SellerAccount::DECLINED)
Unfortunatetly there are circumstances that you did not totally comply and the administrator chooses to decline
your seller account request. Any Questions? you can email us at app.furfect@gmail.com <br>
Remark: {{ $request['remark'] ?? "N/A" }}
@endif

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Redirect
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent















