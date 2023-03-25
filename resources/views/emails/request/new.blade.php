@component('mail::message')
New Request has ben made check it out



@component('mail::button', ['url' => route('home')])
Go to the App
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
