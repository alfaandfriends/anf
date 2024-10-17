<x-mail::message>
# Password Reset

Your account password has been successfully reset. Please find your new password below.

<x-mail::panel>
New Password: {{ $credentials['new_password'] }}
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
