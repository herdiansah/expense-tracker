<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Terms & Conditions - Expense Tracker</title>
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
            <div class="glass-card mx-auto" style="max-width: 880px;">
                <h1 class="title-gradient page-title" style="margin-bottom: 0.35rem;">Terms &amp; Conditions</h1>
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Effective date: {{ now()->format('F d, Y') }}</p>

                <p style="color: var(--text-secondary); margin-bottom: 1.25rem;">
                    These Terms &amp; Conditions govern your use of Expense Tracker. By creating an account or using the service, you agree to these terms.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">1. Service Overview</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    Expense Tracker helps you record transactions, organize categories, review reports, and monitor your personal financial activity. The service is intended for informational and budgeting purposes only.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">2. Account Responsibilities</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    You are responsible for maintaining the confidentiality of your account credentials and for all activity under your account. You agree to provide accurate information and keep it up to date.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">3. Acceptable Use</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    You agree not to misuse the platform, interfere with normal operation, attempt unauthorized access, or use the service for unlawful activities.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">4. Data and Accuracy</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    You retain ownership of the data you enter. While we aim to provide reliable functionality, you are responsible for reviewing and validating your financial records and exports.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">5. Financial Disclaimer</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    Expense Tracker does not provide tax, investment, legal, or financial advice. Insights and summaries are general tools and should not be treated as professional advice.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">6. Availability and Updates</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    We may improve, modify, or discontinue features at any time. We may also update these Terms as the service evolves.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">7. Termination</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    You may stop using the service at any time and request account deletion from your profile settings. We reserve the right to suspend accounts for serious violations of these Terms.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">8. Contact</h2>
                <p style="margin-bottom: 0; color: var(--text-secondary);">
                    If you have questions about these Terms, contact the Expense Tracker team through the support channels provided in the application.
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
