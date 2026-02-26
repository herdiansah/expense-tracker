<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contact - Expense Tracker</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 min-h-screen flex flex-col">
        <header class="glass-header z-50">
            <div class="header-container flex justify-between items-center w-full max-w-7xl mx-auto">
                <a href="{{ url('/') }}" class="title-gradient" style="font-size: 1.35rem; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                    <x-application-logo style="height: 28px; width: auto;" />
                    Expense Tracker
                </a>
                <a href="{{ route('login') }}" class="btn-secondary" style="padding: 0.55rem 1rem;">Log in</a>
            </div>
        </header>

        <main class="premium-container flex-grow">
            <div class="glass-card mx-auto" style="max-width: 820px;">
                <h1 class="title-gradient page-title" style="margin-bottom: 0.35rem;">Contact</h1>
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Need help, partnership details, or product support? Reach us through the channels below.</p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Built by</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    This application is designed and developed by <strong style="color: var(--text-primary);">FlashID</strong>.
                </p>
                <p style="margin-bottom: 1.25rem; color: var(--text-secondary);">
                    Website: <a href="https://flashidinteractive.com/" target="_blank" rel="noopener noreferrer" class="nav-link" style="padding: 0;">flashidinteractive.com</a>
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">General Contact</h2>
                <p style="margin-bottom: 0; color: var(--text-secondary);">
                    Email: <a href="mailto:contact@flashidinteractive.com" class="nav-link" style="padding: 0;">contact@flashidinteractive.com</a>
                </p>
            </div>
        </main>

        <footer class="text-center py-8 text-slate-500 text-sm">
            <div class="flex items-center justify-center gap-4 mb-2">
                <a href="{{ route('legal.terms') }}" class="nav-link" style="padding: 0.25rem 0.5rem;">Terms &amp; Conditions</a>
                <a href="{{ route('legal.privacy') }}" class="nav-link" style="padding: 0.25rem 0.5rem;">Privacy Policy</a>
                <a href="{{ route('legal.contact') }}" class="nav-link" style="padding: 0.25rem 0.5rem;">Contact</a>
            </div>
            <p>&copy; {{ date('Y') }} Expense Tracker. Built by <a href="https://flashidinteractive.com/" target="_blank" rel="noopener noreferrer" class="nav-link" style="padding: 0;">FlashID</a>. All rights reserved.</p>
        </footer>
    </body>
</html>
