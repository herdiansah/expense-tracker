<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Privacy Policy - Expense Tracker</title>
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
                <h1 class="title-gradient page-title" style="margin-bottom: 0.35rem;">Privacy Policy</h1>
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Effective date: {{ now()->format('F d, Y') }}</p>

                <p style="color: var(--text-secondary); margin-bottom: 1.25rem;">
                    This Privacy Policy explains how Expense Tracker collects, uses, and protects your data when you use our service.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">1. Information We Collect</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    We collect account information (such as name and email) and the financial records you submit, including transactions, categories, notes, and reporting preferences.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">2. How We Use Information</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    We use your information to provide core features, personalize your dashboard experience, generate reports, maintain account security, and improve service reliability.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">3. Data Ownership and Control</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    Your data remains yours. You can update profile details, export report data, and request account deletion through your account settings.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">4. Data Sharing</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    We do not sell your personal financial data. We may share limited data with trusted service providers that support hosting, infrastructure, and security operations, subject to confidentiality safeguards.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">5. Data Security</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    We apply reasonable technical and organizational safeguards to protect your information. No system is completely risk free, so we also recommend strong passwords and good account hygiene.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">6. Data Retention</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    We retain your information while your account is active and as needed for legitimate operational and legal purposes. Deleted accounts are handled according to our data retention procedures.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">7. Policy Updates</h2>
                <p style="margin-bottom: 1rem; color: var(--text-secondary);">
                    We may update this Privacy Policy from time to time. Material changes will be reflected with an updated effective date on this page.
                </p>

                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">8. Contact</h2>
                <p style="margin-bottom: 0; color: var(--text-secondary);">
                    For privacy-related questions or requests, contact the Expense Tracker team through the support channels available in the application.
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
