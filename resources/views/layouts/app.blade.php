<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset(mix('dist/app.css')) }}">
        <livewire:styles />

        <wireui:scripts />
        <script src="{{ asset(mix('dist/alpine.js')) }}" defer></script>
    </head>
    <body class="bg-primary-50 bg-opacity-80 antialiased font-sans">
        {{ $slot }}

        <livewire:scripts />
        <script src="{{ asset(mix('dist/app.js')) }}"></script>
    </body>
</html>
