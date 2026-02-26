<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Expense Tracker - Take Control of Your Finances</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 min-h-screen flex flex-col pt-0 sm:pt-0">
        
        <!-- Premium Glass Header -->
        <header class="glass-header z-50">
            <div class="header-container flex justify-between items-center w-full max-w-7xl mx-auto">
                <a href="/" class="title-gradient" style="font-size: 1.5rem; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                    <x-application-logo style="height: 32px; width: auto;" />
                    Expense Tracker
                </a>
                
                <div class="flex items-center gap-2 sm:gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="nav-link font-semibold text-sm sm:text-base px-2 sm:px-4">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary text-xs sm:text-sm !px-3 !py-1.5 whitespace-nowrap">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary text-xs sm:text-sm !px-3 !py-1.5 whitespace-nowrap">Get Started</a>
                        @endif
                    @endauth
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="flex-grow flex items-center justify-center p-6 sm:p-12 relative overflow-hidden">
            
            <!-- Background Glow Splashes -->
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-sky-300/25 rounded-full blur-[100px] -z-10"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-teal-300/25 rounded-full blur-[100px] -z-10"></div>
            
            <div class="w-full max-w-4xl mx-auto text-center glass-card relative z-10 p-8 sm:p-16 border border-slate-200 shadow-xl">
                
                <div class="mb-8 flex justify-center inline-block">
                    <span class="px-4 py-1.5 rounded-full text-sm font-semibold tracking-wider uppercase bg-slate-100 border border-slate-200 text-teal-700">
                        Smart Financial Management
                    </span>
                </div>
                
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight mb-6">
                    Track Every Penny,<br/>
                    <span class="title-gradient mt-2 inline-block">Keep Your Wealth.</span>
                </h1>
                
                <p class="text-lg sm:text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                    A beautifully-crafted, modern personal expense tracking tool. Monitor your spending, organize categories, and achieve your financial goals with absolute clarity.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary text-lg" style="padding: 1rem 2rem;">
                            Go to Dashboard
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary text-lg" style="padding: 1rem 2rem;">
                                Start Tracking Free
                            </a>
                        @endif
                        <a href="{{ route('login') }}" class="btn-secondary text-lg" style="padding: 1rem 2rem;">
                            Sign In
                        </a>
                    @endauth
                </div>
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
