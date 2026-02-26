# Product Requirements Document (PRD)

## Product Name
Expense Tracker

## Version v1.1

## 1. Product Overview

### 1.1 Purpose
Expense Tracker helps individuals record income/expenses, organize categories, monitor cashflow, and export financial records.

### 1.2 Product Goals
- Help users capture daily financial activity quickly
- Provide clear monthly and date-range visibility
- Enable simple, reliable exports for offline analysis
- Maintain privacy through account-level data isolation

### 1.3 Non-Goals (Current Stage)
- Bank account/API integrations
- Investment portfolio tracking
- Team/shared household accounts
- Native mobile app
- AI forecasting and recommendations

## 2. Target Users
- Individuals managing personal finances
- Freelancers tracking variable income and expenses
- Students and young professionals monitoring monthly spending

## 3. Current Scope (Implemented)

### 3.1 Public Experience
- Landing page with product value proposition
- Legal pages:
  - Terms & Conditions
  - Privacy Policy
  - Contact

### 3.2 Authentication & Account
- Register
- Login / Logout
- Email verification
- Forgot/reset password
- Profile management
  - name, email
  - preferred currency
- Password change
- Account deletion

### 3.3 Dashboard
- Current month totals:
  - income
  - expense
- Total balance (all-time net)
- Recent transactions (latest 10)
- Date range filter for charts
- Analytics charts:
  - income vs expense trend (daily)
  - expense by category
- Range totals (income, expense, net)

### 3.4 Transaction Management
- Create transaction
- Edit transaction
- Soft delete transaction
- List with filters:
  - type
  - category
- Pagination

### 3.5 Category Management
- Create category
- Edit category
- Delete category
- Type: `income` or `expense`
- Unique category name by user + type

### 3.6 Reporting
- Filter report by:
  - start date
  - end date
  - category
  - type
- Export filtered data as CSV

## 4. Functional Requirements

| ID | Requirement | Priority | Status |
| --- | --- | --- | --- |
| FR-01 | User can register/login/logout | High | Implemented |
| FR-02 | User can verify email and access protected modules | High | Implemented |
| FR-03 | User can create/edit/delete transactions | High | Implemented |
| FR-04 | Transaction list supports filtering and pagination | High | Implemented |
| FR-05 | User can create/edit/delete categories | High | Implemented |
| FR-06 | Dashboard shows monthly summary and recent transactions | High | Implemented |
| FR-07 | Dashboard supports date-range charts | Medium | Implemented |
| FR-08 | User can export report CSV with filters | Medium | Implemented |
| FR-09 | User can manage profile, currency, and password | Medium | Implemented |
| FR-10 | Public legal/contact pages available from footer | Medium | Implemented |

## 5. Non-Functional Requirements

### 5.1 Security
- Password hashing via Laravel auth
- CSRF protection on state-changing forms
- Auth middleware for protected routes
- Verified middleware for finance modules
- Policy-based authorization on category/transaction changes
- User-scoped data access

### 5.2 Performance
- Dashboard and listing pages should be responsive for normal personal usage volume
- Query indexes on transaction filters (`user_id`, `transaction_date`, `category_id`, `type`)

### 5.3 Usability
- Mobile-first responsive behavior
- Compact, clean, modern UI
- Consistent navigation and footer links

### 5.4 Reliability
- Soft delete on transactions to reduce accidental data loss risk
- Validation rules applied server-side for key financial fields

## 6. Data Requirements (Current)

### 6.1 users
- name, email, password
- currency (default `USD`)
- email verification timestamp

### 6.2 categories
- user_id
- name
- type (`income|expense`)
- unique (`user_id`, `name`, `type`)

### 6.3 transactions
- user_id, category_id
- type (`income|expense`)
- amount (decimal)
- transaction_date
- description
- payment_method (optional)
- notes (optional)
- soft deletes

## 7. Core User Flows

### 7.1 New User
1. Register account
2. Verify email
3. Add category (optional if needed)
4. Add first transaction
5. Review dashboard insights

### 7.2 Returning User
1. Login
2. Add or edit transactions
3. Check dashboard trend by date range
4. Export report if needed

## 8. Pages (Current)
- `/` (landing)
- `/login`, `/register`, password reset routes
- `/dashboard`
- `/transactions`
- `/transactions/create`
- `/transactions/{id}/edit`
- `/categories`
- `/categories/create`
- `/categories/{id}/edit`
- `/reports`
- `/profile`
- `/terms`
- `/privacy`
- `/contact`

## 9. Success Metrics (Current Stage)
- User can add a transaction quickly with required fields validated
- Dashboard values and report exports reflect stored data accurately
- Users can complete main financial workflow (record -> review -> export)
- Legal/contact pages are reachable from all app footers

## 10. Next-Phase Opportunities
- Add transaction date-range filter on list page
- Add recurring transactions
- Add budget planning module
- Add richer report visualizations/download formats
- Add API layer for mobile/web clients
