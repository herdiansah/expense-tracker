# FSD - Functional Specification Document

## Version v1.1

### 1) Product Scope
Expense Tracker is a personal finance web app where authenticated users can manage categories, record transactions, review dashboard insights, and export filtered reports.

### 2) Current Modules

#### 2.1 Public Pages
- Landing page (`/`)
- Terms & Conditions (`/terms`)
- Privacy Policy (`/privacy`)
- Contact (`/contact`)

#### 2.2 Authentication & Account
- Register, Login, Logout
- Email verification flow (verified users can access app modules)
- Forgot/reset password flow
- Profile update (name, email, preferred currency)
- Password update
- Account deletion

#### 2.3 Dashboard
- Monthly summary cards:
  - total income (current month)
  - total expense (current month)
  - total balance (all time net)
- Date-range analytics:
  - income vs expense trend chart (daily)
  - expense by category chart
  - range totals: income, expense, net
- Recent transactions list (latest 10)

#### 2.4 Transactions
- Create transaction
- Edit transaction
- Soft delete transaction
- List transactions with filters:
  - type
  - category
- Pagination

#### 2.5 Categories
- Create category
- Edit category
- Delete category
- Category type is limited to:
  - `income`
  - `expense`

#### 2.6 Reports
- Report filter form:
  - start date
  - end date
  - category
  - type
- Export filtered transactions to CSV

### 3) Roles & Access Rules
- Single role: authenticated user
- User can only access their own transactions and categories
- Dashboard, categories, transactions, and reports require:
  - authenticated session
  - verified email

### 4) Functional Requirements

#### 4.1 Auth & Profile
- FR-A1: User can register with name, email, password
- FR-A2: User can login/logout
- FR-A3: User can request password reset
- FR-A4: User verifies email before accessing core modules
- FR-A5: User can update profile data including currency
- FR-A6: User can update password
- FR-A7: User can permanently delete account

#### 4.2 Categories
- FR-C1: User can create category with unique `(name + type)` within their account
- FR-C2: User can edit category name/type
- FR-C3: User can delete category (subject to DB constraints)

#### 4.3 Transactions
- FR-T1: User can create transaction with type, amount, date, category, description, optional payment method and notes
- FR-T2: User can edit transaction fields
- FR-T3: User can soft delete transaction
- FR-T4: User can view paginated transaction list sorted by latest date
- FR-T5: User can filter transaction list by type and category

#### 4.4 Dashboard
- FR-D1: Show current month income and expense totals
- FR-D2: Show total balance across all transactions
- FR-D3: Show recent transactions (max 10)
- FR-D4: Support date-range charts with validation (`end_date >= start_date`)
- FR-D5: Show expense category breakdown for selected date range

#### 4.5 Reports
- FR-R1: User can filter report parameters (date range/category/type)
- FR-R2: User can export report as CSV with selected filters

#### 4.6 Legal & Contact
- FR-L1: Terms, Privacy, and Contact pages are publicly accessible
- FR-L2: Footer menus include links to all legal/contact pages

### 5) Validation Rules (Implemented)
- Transaction amount must be numeric and `>= 0.01`
- Transaction date is required and must be valid
- Transaction type must be `income` or `expense`
- Transaction category must exist and belong to current user
- Transaction description is required (max 255)
- Category name is required and unique by user+type
- Category type must be `income` or `expense`
- Dashboard date range validates `end_date` >= `start_date`

### 6) Non-Functional Expectations
- Responsive UI for desktop/tablet/mobile
- Consistent modern visual style across core pages
- CSRF protection on state-changing forms
- Authorization policy checks for category/transaction update-delete actions
- Export responses generated in acceptable time for normal personal usage scale
