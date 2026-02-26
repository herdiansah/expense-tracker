<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Expense Tracker') }}</title>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header class="glass-header" x-data="{ mobileMenuOpen: false }">
            <div class="header-container flex justify-between items-center w-full md:grid md:grid-cols-[1fr_auto_1fr] md:gap-4">
                <a href="{{ route('dashboard') }}" class="title-gradient md:justify-self-start" style="font-size: 1.5rem; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                    <x-application-logo style="height: 32px; width: auto;" />
                    Expense Tracker
                </a>

                <nav class="hidden md:flex items-center justify-center gap-4 md:justify-self-center">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">Categories</a>
                    <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">Transactions</a>
                    <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">Reports</a>
                </nav>

                <div class="hidden md:flex items-center gap-4 md:justify-self-end">
                    <a href="{{ route('profile.edit') }}" class="nav-link whitespace-nowrap">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="nav-link whitespace-nowrap" style="border: 0; background: transparent; cursor: pointer; font: inherit;">Logout</button>
                    </form>
                </div>

                <button @click="mobileMenuOpen = ! mobileMenuOpen" class="mobile-menu-btn block md:hidden text-slate-600 hover:text-slate-900 focus:outline-none focus:text-slate-900">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenuOpen, 'inline-flex': ! mobileMenuOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div :class="{'block absolute top-[50px] left-0 w-full app-menu-panel p-4 z-[100]': mobileMenuOpen, 'hidden': !mobileMenuOpen}" class="nav-wrapper hidden md:hidden items-center w-full mt-4 gap-4">
                <nav class="flex flex-col items-end gap-2 w-full">
                    <a href="{{ route('dashboard') }}" class="nav-link w-full text-right md:w-auto {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('categories.index') }}" class="nav-link w-full text-right md:w-auto {{ request()->routeIs('categories.*') ? 'active' : '' }}">Categories</a>
                    <a href="{{ route('transactions.index') }}" class="nav-link w-full text-right md:w-auto {{ request()->routeIs('transactions.*') ? 'active' : '' }}">Transactions</a>
                    <a href="{{ route('reports.index') }}" class="nav-link w-full text-right md:w-auto {{ request()->routeIs('reports.*') ? 'active' : '' }}">Reports</a>
                    <a href="{{ route('profile.edit') }}" class="nav-link w-full text-right">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;" class="w-full text-right">
                        @csrf
                        <button type="submit" class="nav-link w-full text-right whitespace-nowrap" style="border: 0; background: transparent; cursor: pointer; font: inherit; color: var(--text-secondary);">Logout</button>
                    </form>
                </nav>
            </div>
        </header>

        <!-- Page Content -->
        <main class="premium-container">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="glass-card mb-4" style="border-left: 4px solid var(--success); padding: 1rem;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="glass-card mb-4" style="border-left: 4px solid var(--danger); padding: 1rem;">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </main>

        <footer class="text-center py-6 text-slate-500 text-sm">
            <div class="flex items-center justify-center gap-4 mb-2">
                <a href="{{ route('legal.terms') }}" class="nav-link" style="padding: 0.25rem 0.5rem;">Terms &amp; Conditions</a>
                <a href="{{ route('legal.privacy') }}" class="nav-link" style="padding: 0.25rem 0.5rem;">Privacy Policy</a>
                <a href="{{ route('legal.contact') }}" class="nav-link" style="padding: 0.25rem 0.5rem;">Contact</a>
            </div>
            <p>&copy; {{ date('Y') }} Expense Tracker. Built by <a href="https://flashidinteractive.com/" target="_blank" rel="noopener noreferrer" class="nav-link" style="padding: 0;">FlashID</a>. All rights reserved.</p>
        </footer>
    </body>
</html>
