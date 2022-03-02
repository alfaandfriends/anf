<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'ALFA and Friends') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        
        <!-- All components in one -->
        <script src="https://cdn.jsdelivr.net/npm/kutty@latest/dist/kutty.min.js"></script>
        <!-- Single component -->
        <!-- Include AlpineJS first -->
        <script src="https://cdn.jsdelivr.net/npm/kutty@latest/dist/alpinejs.min.js"></script>
        <!-- And then the single component -->
        <script src="https://cdn.jsdelivr.net/npm/kutty@latest/dist/dropdown.min.js"></script>

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        @inertia

        @env ('local')
            <!-- <script src="http://localhost:8080/js/bundle.js"></script> -->
        @endenv
    </body>
</html>
