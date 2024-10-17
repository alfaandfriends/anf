<x-mail::message>
# Forgot Password

Click button below to reset your password. Please ignore if you didn't request for password reset.

<x-mail::button :url="url(route('password.reset', ['token' => $token, 'email' => $email]))">
Reset Password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
