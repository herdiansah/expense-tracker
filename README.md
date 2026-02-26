# Expense Tracker

A modern personal finance web app built with Laravel. Track income and expenses, manage categories, review reports, and monitor cashflow with a clean responsive UI.

## Features
- Authentication (login/register/profile)
- Transaction management (create, edit, delete)
- Category management (income/expense)
- Dashboard with date-range charts
- Reports with filters and CSV export
- Legal pages: Terms, Privacy, Contact

## Tech Stack
- Laravel 12
- PHP 8.4+
- Blade + Vite
- SQLite (default) or MySQL
- Alpine.js
- [Maileroo](https://maileroo.com/) (email gateway)

## Quick Start (Local)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

Open: `http://127.0.0.1:8000`

## Email Configuration (Maileroo)

This app uses [Maileroo](https://maileroo.com/) as the email gateway for transactional emails (verification, password reset, etc.) via a custom Laravel mail transport.

Add these to your `.env`:

```env
MAIL_MAILER=maileroo
MAILROO_API_KEY=your-api-key
MAILROO_BASE_URL=https://smtp.maileroo.com
MAILROO_FROM_EMAIL=noreply@yourdomain.com
MAILROO_FROM_NAME="Your App Name"
```

> **Note:** The sender domain must be verified in your [Maileroo dashboard](https://app.maileroo.com/) before emails will be delivered.

## Laragon (Windows)
If you use Laragon and keep this app in `C:\laragon\www\expenses`, open:

- `http://expenses.test`

Make sure Auto Virtual Hosts is enabled and services are running.

## Deployment
Full deployment instructions are documented in:

- `docs/DEPLOYMENT.md`

It includes:
- production server requirements
- environment configuration
- Nginx/Apache examples
- migration/cache commands
- update and rollback workflow
- Laragon-specific deployment notes

## Useful Commands

```bash
# Dev mode (Laravel + Vite)
composer run dev

# Build frontend assets
npm run build

# Run tests
php artisan test

# Clear and rebuild Laravel caches
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Legal & Contact
- Terms: `/terms`
- Privacy: `/privacy`
- Contact: `/contact`


## Deploy Helper (`deploy.php`)

The `deploy.php` file is a web-based deployment helper designed for shared hosting environments (like Hostinger, cPanel, etc.) where SSH/terminal access is unavailable or limited. It allows you to run essential Laravel Artisan commands directly from your web browser.

## ⚠️ Security Warning

**This file provides direct access to execute server commands.**
- It is protected by a secret token.
- **NEVER** leave this file on your production server with the default token.
- It is highly recommended to **delete this file** immediately after you finish your deployment tasks.

---

## 1. Setup & Configuration

Before uploading the application to your production server, you MUST change the secret token in the file:

1. Open `public/deploy.php` in your local code editor.
2. Locate line 22:
   ```php
   $DEPLOY_TOKEN = 'xK9mPq2vR7wL4nB8'; // Change this!
   ```
3. Change the string to a long, secure, and random passphrase (e.g., `MySuperSecureToken99!`).
4. Save the file and upload your application (including `public/deploy.php`) to the server.

---

## 2. Using the Helper

Once the file is uploaded (and usually sitting in your server's `public_html/` folder), you can execute Artisan commands by visiting specific URLs in your browser.

Replace `your-domain.com` with your actual domain name and `YOUR_TOKEN` with the secure token you set in step 1.

### **Run Database Migrations**
Whenever you upload new database table structures, run this URL to automatically migrate your production database safely:
```text
https://your-domain.com/deploy.php?token=YOUR_TOKEN&action=migrate
```

### **Rebuild Caches**
Run this after uploading new `.env` changes, new routes, or new Blade templates to ensure Laravel uses the latest versions:
```text
https://your-domain.com/deploy.php?token=YOUR_TOKEN&action=cache
```
*(This runs `config:cache`, `route:cache`, and `view:cache`)*

### **Clear All Caches**
If your application is acting stuck or using old configurations:
```text
https://your-domain.com/deploy.php?token=YOUR_TOKEN&action=clear
```

### **Create Storage Symlink**
If uploaded images or files are returning 404 errors, you need to link the storage folder to the public directory:
```text
https://your-domain.com/deploy.php?token=YOUR_TOKEN&action=link
```

### **Check Application Status**
Displays your current environment variables (App URL, DB connection, PHP version) and the status of all your database migrations:
```text
https://your-domain.com/deploy.php?token=YOUR_TOKEN&action=status
```

---

## 3. Best Practices

1. **Upload, Run, Delete:** The safest workflow is to upload `deploy.php` along with your update, hit the URLs you need (like `action=migrate` and `action=cache`), and then immediately delete `deploy.php` from the server.
2. If an action fails with an error (`❌ Error:`), the helper will print the PHP stack trace to help you diagnose the issue (e.g., incorrect database credentials in your `.env`).

Built by [FlashID](https://flashidinteractive.com/).
