<x-mail::message>
# Account Created

Your account has been successfully created. Below are your credentials to log in:

<x-mail::panel>
**Email**: {{ $credentials['email'] }}<br>
**Username**: {{ $credentials['username'] }}<br>
**Password**: {{ $credentials['password'] }}
</x-mail::panel>

Please make sure to update your password after logging in for security reasons.<br>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
