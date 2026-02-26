# cPanel Quick Deployment Checklist

Use this as a fast runbook when deploying Expense Tracker on shared hosting with cPanel only.

## 1) Local Build
- [ ] Run `composer install --no-dev --optimize-autoloader`
- [ ] Run `npm ci`
- [ ] Run `npm run build`
- [ ] Prepare deployment zip including `vendor/` and `public/build/`

## 2) cPanel Database
- [ ] Create MySQL database
- [ ] Create MySQL user
- [ ] Assign user to database with ALL PRIVILEGES
- [ ] Record full prefixed DB name/user

## 3) Upload Project
- [ ] Upload zip to `/home/CPANEL_USER/expenses`
- [ ] Extract files
- [ ] Ensure `.env` exists in project root

## 4) Configure `.env`
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_URL=https://your-domain.com`
- [ ] `DB_CONNECTION=mysql`
- [ ] Set `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- [ ] Set valid `APP_KEY`

## 5) Web Root
- [ ] Preferred: set domain document root to `/home/CPANEL_USER/expenses/public`
- [ ] Fallback: copy `public/` contents to `public_html/` and fix `index.php` paths

## 6) Laravel Commands
If Terminal exists:
- [ ] `php artisan migrate --force`
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `php artisan view:cache`

If Terminal does not exist:
- [ ] Ask hosting support to run commands above once

## 7) Permissions
- [ ] `storage/` writable
- [ ] `bootstrap/cache/` writable

## 8) Verify App
- [ ] Home page loads
- [ ] Register/login works
- [ ] Dashboard loads with charts
- [ ] Create/edit/delete transaction works
- [ ] CSV export works
- [ ] `/terms`, `/privacy`, `/contact` are accessible

## 9) Optional
- [ ] Add cron: `* * * * * /usr/local/bin/php /home/CPANEL_USER/expenses/artisan schedule:run >> /dev/null 2>&1`

## Related Docs
- Full guide: `docs/DEPLOYMENT.md`
