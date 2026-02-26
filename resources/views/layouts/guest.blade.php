<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
            <div>
                <a href="/" style="text-decoration: none;">
                    <div style="text-align: center;">
                        <x-application-logo style="height: 64px; width: auto; display: block; margin: 0 auto 0.5rem;" />
                        <h1 class="title-gradient" style="font-size: 2rem;">Expense Tracker</h1>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-[345px] mt-6 px-6 py-6 glass-card overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
