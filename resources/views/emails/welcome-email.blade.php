@component('mail::message')
# Welcome to {{ config('app.name') }}!

We are very happy to see you here!

@component('mail::button', ['url' => 'http://localhost:8000'])
Confirm
@endcomponent

Best regards,<br>
{{ config('app.name') }}
@endcomponent
