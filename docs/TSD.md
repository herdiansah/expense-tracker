## TSD - Technical Specification Document

### Version v1.1

### 1) Technology Stack
- Framework: Laravel 12
- Language: PHP 8.2+
- Frontend: Blade templates + Alpine.js + Vite
- Styling: Custom CSS (`resources/css/premium.css`)
- Database: SQLite (default) or MySQL/MariaDB
- Auth scaffolding: Laravel Breeze

### 2) Architecture Overview
- Pattern: Laravel MVC + Service Layer
- Main flow:
  - Route -> Controller -> Service/Model -> Blade View
- Key service:
  - `App\Services\TransactionService` for summary/balance calculations
- Authorization:
  - Policies for `Transaction` and `Category`

### 3) Current Modules and Key Components

#### 3.1 Controllers
- `DashboardController`
  - monthly summary
  - date-range chart data (daily income/expense + category expense breakdown)
- `TransactionController`
  - CRUD (resource style, no show)
  - list filter by type/category
- `CategoryController`
  - CRUD (resource style, no show)
- `ReportController`
  - filter page + CSV export
- `ProfileController`
  - profile update, account deletion

#### 3.2 Requests
- `StoreTransactionRequest`
  - validates transaction payload
- `ProfileUpdateRequest`
  - validates profile update payload

#### 3.3 Models
- `User`
  - has many categories
  - has many transactions
  - includes preferred `currency`
- `Category`
  - belongs to user
  - has many transactions
- `Transaction`
  - belongs to user/category
  - uses soft deletes

### 4) Routing (Web)

#### 4.1 Public Routes
- `GET /` -> landing page
- `GET /terms` -> legal terms
- `GET /privacy` -> privacy policy
- `GET /contact` -> contact page

#### 4.2 Auth/Verification Routes
- Provided by `routes/auth.php` (Breeze)
- Includes register/login/logout, password reset, email verification

#### 4.3 Protected Routes (`auth` + `verified`)
- `GET /dashboard`
- `categories` resource (except show)
- `transactions` resource (except show)
- `GET /reports`
- `GET /reports/export`

#### 4.4 Profile Routes (`auth`)
- `GET /profile`
- `PATCH /profile`
- `DELETE /profile`

### 5) Data Model (Current)

#### 5.1 users
- id
- name
- email
- password
- currency (3 chars, default `USD`)
- email_verified_at
- timestamps

#### 5.2 categories
- id
- user_id (FK, cascade on delete)
- name
- type enum: `income|expense`
- timestamps
- unique constraint: `(user_id, name, type)`

#### 5.3 transactions
- id
- user_id (FK, cascade on delete)
- category_id (FK, restrict on delete)
- type enum: `income|expense`
- amount decimal(12,2)
- transaction_date (date)
- description (required)
- payment_method (nullable)
- notes (nullable)
- soft deletes (`deleted_at`)
- timestamps
- indexes:
  - `(user_id, transaction_date)`
  - `(user_id, category_id)`
  - `(user_id, type)`

### 6) Business Rules (Implemented)
- All category/transaction queries are user-scoped
- Category for transaction must belong to authenticated user
- Transaction amount minimum is `0.01`
- Category name uniqueness is enforced per user+type
- Dashboard date filter enforces `end_date >= start_date`

### 7) Security Design
- Password hashing via Laravel native `hashed` cast
- CSRF protection enabled for forms
- Auth middleware on protected modules
- Verified middleware on core finance modules
- Policy authorization for category and transaction edit/delete
- Server-side validation via Form Requests and inline controller validation

### 8) Reporting and Analytics Implementation

#### 8.1 Dashboard Analytics
- Monthly totals from `TransactionService`
- Date-range trend:
  - grouped per day using SQL aggregates
  - filled across full date period in PHP (`CarbonPeriod`)
- Expense breakdown:
  - grouped by category name
  - limited to top 8 categories

#### 8.2 Report Export
- CSV streamed response from `ReportController::export`
- Supports filters:
  - start_date
  - end_date
  - category_id
  - type

### 9) Frontend Structure
- Layouts:
  - `resources/views/layouts/app.blade.php`
  - `resources/views/layouts/guest.blade.php`
- Main pages:
  - dashboard, transactions, categories, reports, profile
- Legal pages:
  - `resources/views/legal/terms.blade.php`
  - `resources/views/legal/privacy.blade.php`
  - `resources/views/legal/contact.blade.php`
- Theme and responsive utility styles:
  - `resources/css/premium.css`

### 10) Deployment Notes
- Primary deployment runbook is documented in:
  - `docs/DEPLOYMENT.md`
- Required production steps include:
  - `composer install --no-dev --optimize-autoloader`
  - `npm run build`
  - `php artisan migrate --force`
  - cache optimization (`config:cache`, `route:cache`, `view:cache`)

### 11) Known Technical Considerations
- Chart.js is loaded via CDN in dashboard view
- Tests may fail in environments missing `pdo_sqlite` when using sqlite memory testing
- Category deletion may be blocked by FK restrictions if transactions reference it

### 12) Recommended Next Enhancements
- Add transaction date-range filter to list view (currently type/category only)
- Add policy tests and feature tests for dashboard analytics filters
- Move dashboard chart script into bundled JS module to avoid inline script growth
- Add API layer if mobile app integration is planned
