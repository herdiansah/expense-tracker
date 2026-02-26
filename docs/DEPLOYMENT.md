# Deployment Guide

## Project
- App: Expense Tracker (Laravel 12 + Vite)
- PHP: 8.2+
- Node.js: 18+
- Database: SQLite (default) or MySQL/MariaDB

## 1) Server Requirements
- Web server: Nginx or Apache
- PHP extensions: `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`
- Extra DB extension:
  - SQLite: `pdo_sqlite`
  - MySQL: `pdo_mysql`
- Composer 2.x

## 2) Deploy Source Code
```bash
git clone <repository-url> expenses
cd expenses
```

## 3) Install Dependencies
```bash
composer install --no-dev --prefer-dist --optimize-autoloader
npm ci
npm run build
```

## 4) Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` for production:
```env
APP_NAME="Expense Tracker"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_LEVEL=error
```

### Database Option A: SQLite (simple)
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

Create the file if missing:
```bash
touch database/database.sqlite
```

### Database Option B: MySQL/MariaDB
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expenses
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

## 5) Run Migrations
```bash
php artisan migrate --force
```

## 6) Optimize Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 7) File Permissions
Ensure web user can write to:
- `storage/`
- `bootstrap/cache/`

Linux example:
```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

## 8) Web Server Configuration

### Nginx
Point document root to `public/`:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/expenses/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }

    location ~ /\. {
        deny all;
    }
}
```

### Apache
- Enable `mod_rewrite`
- Set document root to `public/`

## 9) Background Workers (Recommended)
If you use queued jobs, run a worker process manager (Supervisor/systemd):
```bash
php artisan queue:work --sleep=3 --tries=3 --max-time=3600
```

## 10) Post-Deployment Checks
- App opens at `/`
- Auth pages work (`/login`, `/register`)
- Dashboard loads
- Create transaction and run reports
- Check logs: `storage/logs/laravel.log`

## 11) Update / Redeploy Procedure
```bash
git pull origin main
composer install --no-dev --prefer-dist --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 12) Rollback (Basic)
- Keep previous release directory for quick switch-back
- If schema changes are safe to revert:
```bash
php artisan migrate:rollback --step=1
```

## Notes
- This app currently includes legal pages and footer links (Terms, Privacy, Contact).
- Ensure production email, session, and cache drivers are set appropriately for your environment.

## 13) Laragon (Windows) Quick Deployment

Use this if you host the app in Laragon (like `C:\laragon\www\expenses`).

### 13.1 Prepare project
```powershell
cd C:\laragon\www\expenses
composer install
npm install
copy .env.example .env
php artisan key:generate
```

### 13.2 Database setup (SQLite recommended locally)
```powershell
if (!(Test-Path .\database\database.sqlite)) { New-Item .\database\database.sqlite -ItemType File }
php artisan migrate
```

Set in `.env`:
```env
APP_NAME="Expense Tracker"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://expenses.test

DB_CONNECTION=sqlite
DB_DATABASE=C:\laragon\www\expenses\database\database.sqlite
```

### 13.3 Build assets
```powershell
npm run build
```

### 13.4 Configure Laragon virtual host
- In Laragon, enable **Auto Virtual Hosts**.
- Keep project in `C:\laragon\www\expenses`.
- Restart Laragon (Apache/Nginx + MySQL if needed).
- Open: `http://expenses.test`

### 13.5 Optional local dev mode
Run Vite hot reload in a separate terminal:
```powershell
npm run dev
```

### 13.6 Common Laragon issues
- If `expenses.test` does not resolve: run Laragon as Administrator and restart so hosts file updates.
- If tests fail with `could not find driver`: enable SQLite extension in PHP (`pdo_sqlite`, `sqlite3`).
- If CSS/JS not updated: stop `npm run dev`, run `npm run build`, then hard refresh browser (`Ctrl+F5`).

## 14) cPanel-Only Hosting Deployment Guide (Shared Hosting)

Use this section when you only have cPanel access (no SSH root access).

### 14.1 Preconditions
- PHP version in cPanel: 8.2+
- MySQL database access in cPanel
- Ability to set document root (Addon Domain/Subdomain) OR edit `public_html`
- Composer availability in cPanel ("Setup PHP Composer") is helpful but optional

### 14.2 Build package locally first
On your local machine (project root):

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

Then create a deploy zip that includes:
- app source code
- `vendor/`
- built frontend assets in `public/build/`
- excludes `.env`

### 14.3 Create database in cPanel
In **MySQL Databases**:
1. Create a database
2. Create a database user
3. Assign user to database with ALL PRIVILEGES
4. Note full DB name/user format (often prefixed, e.g. `cpuser_expenses`)

### 14.4 Upload files in File Manager
1. Upload zip to your target folder (example: `/home/CPANEL_USER/expenses`)
2. Extract it
3. Ensure Laravel writable directories exist:
   - `storage/`
   - `bootstrap/cache/`

### 14.5 Configure environment
Create `.env` in project root using File Manager (copy from `.env.example`):

```env
APP_NAME="Expense Tracker"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=cpanel_db_name
DB_USERNAME=cpanel_db_user
DB_PASSWORD=cpanel_db_password
```

Generate and set a real app key locally if needed:

```bash
php artisan key:generate --show
```

Copy the value to `APP_KEY=` in production `.env`.

### 14.6 Point web root to Laravel `public`

Preferred option:
- In cPanel Domains, set document root to:
  - `/home/CPANEL_USER/expenses/public`

If you cannot change document root:
1. Move contents of `public/` into `public_html/`
2. Edit `public_html/index.php` paths:

```php
require __DIR__.'/../expenses/vendor/autoload.php';
$app = require_once __DIR__.'/../expenses/bootstrap/app.php';
```

Adjust `../expenses` to your real project location.

### 14.7 Run migrations and cache commands

If cPanel Terminal is available:

```bash
cd ~/expenses
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If Terminal is not available:
- Ask hosting support to run those commands once
- Or temporarily create a one-time route/script for migration (remove immediately after use)

### 14.8 Permissions
In File Manager, ensure writable permissions for:
- `storage`
- `bootstrap/cache`

Typical safe setup on shared hosting:
- directories: `755`
- files: `644`

### 14.9 Cron jobs (optional but recommended)
In **Cron Jobs** add Laravel scheduler:

```bash
* * * * * /usr/local/bin/php /home/CPANEL_USER/expenses/artisan schedule:run >> /dev/null 2>&1
```

### 14.10 Post-deploy checklist
- Homepage loads
- Login/register works
- Dashboard and charts render
- Can create/edit transaction
- Report CSV export downloads
- Legal pages (`/terms`, `/privacy`, `/contact`) open

### 14.11 Common cPanel issues
- **500 error right after deploy**: wrong `APP_KEY`, wrong `index.php` paths, or missing `vendor/`
- **CSS/JS missing**: `public/build/` not uploaded
- **DB connection error**: wrong prefixed DB/user names in `.env`
- **Blank page**: PHP version too old or fatal error in `storage/logs/laravel.log`
