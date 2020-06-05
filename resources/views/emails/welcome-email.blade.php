@component('mail::message')
# Welcome to 

The body of your message.

@component('mail::button', ['url' => '#'])
Confirm
@endcomponent

Best regards,<br>
{{ config('app.name') }}
@endcomponent
