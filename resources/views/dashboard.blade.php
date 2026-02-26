<x-app-layout>
    <div class="page-header">
        <h2 class="title-gradient page-title">Dashboard Overview</h2>
        <a href="{{ route('transactions.create') }}" class="btn-primary">
            + New Transaction
        </a>
    </div>

    @php
        $symbol = \App\Http\Controllers\ReportController::currencySymbol(auth()->user()->currency);
    @endphp

    <div class="dashboard-grid">
        <div class="glass-card stat-card border-t-accent">
            <div class="stat-label">Total Balance</div>
            <div class="stat-value {{ $totalBalance >= 0 ? 'positive' : 'negative' }}">
                {{ $symbol }}{{ number_format($totalBalance, 2) }}
            </div>
        </div>
        <div class="glass-card stat-card">
            <div class="stat-label">This Month Income</div>
            <div class="stat-value positive">+{{ $symbol }}{{ number_format($summary['total_income'], 2) }}</div>
        </div>
        <div class="glass-card stat-card">
            <div class="stat-label">This Month Expenses</div>
            <div class="stat-value negative">-{{ $symbol }}{{ number_format($summary['total_expense'], 2) }}</div>
        </div>
    </div>

    <div class="glass-card mb-8">
        <div class="flex justify-between items-center mb-4" style="flex-wrap: wrap; gap: 1rem;">
            <h3 style="margin: 0; color: var(--text-primary);">Charts by Date Range</h3>
            <form method="GET" action="{{ route('dashboard') }}" class="flex gap-4 items-end" style="flex-wrap: wrap;">
                <div class="form-group" style="margin-bottom: 0; min-width: 170px;">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input id="start_date" name="start_date" type="date" class="form-control" value="{{ $startDate->toDateString() }}">
                </div>
                <div class="form-group" style="margin-bottom: 0; min-width: 170px;">
                    <label for="end_date" class="form-label">End Date</label>
                    <input id="end_date" name="end_date" type="date" class="form-control" value="{{ $endDate->toDateString() }}">
                </div>
                <button type="submit" class="btn-primary">Apply</button>
                <a href="{{ route('dashboard') }}" class="btn-secondary">Reset</a>
            </form>
        </div>

        @if($errors->has('start_date') || $errors->has('end_date'))
            <p style="margin: 0 0 1rem; color: var(--danger);">Please use a valid date range (end date must be the same or after start date).</p>
        @endif

        <p style="margin: 0 0 1rem; color: var(--text-secondary);">
            Showing {{ $startDate->format('M d, Y') }} to {{ $endDate->format('M d, Y') }}
        </p>

        <div class="dashboard-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); margin-bottom: 1rem;">
            <div class="glass-card" style="padding: 1rem;">
                <div class="stat-label">Range Income</div>
                <div class="stat-value positive" style="font-size: 1.6rem;">{{ $symbol }}{{ number_format($rangeIncome, 2) }}</div>
            </div>
            <div class="glass-card" style="padding: 1rem;">
                <div class="stat-label">Range Expenses</div>
                <div class="stat-value negative" style="font-size: 1.6rem;">{{ $symbol }}{{ number_format($rangeExpense, 2) }}</div>
            </div>
            <div class="glass-card" style="padding: 1rem;">
                <div class="stat-label">Range Net</div>
                <div class="stat-value {{ $rangeNet >= 0 ? 'positive' : 'negative' }}" style="font-size: 1.6rem;">{{ $symbol }}{{ number_format($rangeNet, 2) }}</div>
            </div>
        </div>

        <div class="dashboard-grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); margin-bottom: 0;">
            <div class="glass-card" style="padding: 1rem;">
                <h4 style="margin: 0 0 0.8rem; color: var(--text-primary);">Income vs Expense Trend</h4>
                <div style="position: relative; height: 320px; width: 100%;">
                    <canvas id="cashflowTrendChart"></canvas>
                </div>
            </div>
            <div class="glass-card" style="padding: 1rem;">
                <h4 style="margin: 0 0 0.8rem; color: var(--text-primary);">Expense by Category</h4>
                @if(count($categorySeries) > 0)
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="expenseCategoryChart"></canvas>
                    </div>
                @else
                    <p style="margin: 0; color: var(--text-secondary);">No expense data found for this date range.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="glass-card">
        <h3 class="mb-4" style="color: var(--text-primary);">Recent Transactions</h3>

        @if($recentTransactions->count() > 0)
            <div style="overflow-x: auto;">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                            <tr>
                                <td data-label="Date" style="color: var(--text-secondary);">{{ $transaction->transaction_date->format('M d, Y') }}</td>
                                <td data-label="Description">{{ $transaction->description }}</td>
                                <td data-label="Category">
                                    <span class="badge {{ $transaction->type === 'income' ? 'badge-income' : 'badge-expense' }}">
                                        {{ $transaction->category->name }}
                                    </span>
                                </td>
                                <td data-label="Amount" class="{{ $transaction->type === 'income' ? 'positive' : 'negative' }}" style="font-weight: 600;">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}{{ $symbol }}{{ number_format($transaction->amount, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('transactions.index') }}" class="nav-link" style="font-size: 0.9rem;">View All Transactions &rarr;</a>
            </div>
        @else
            <div style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                <p>No transactions yet.</p>
                <a href="{{ route('transactions.create') }}" class="btn-primary mt-4">Record your first expense</a>
            </div>
        @endif
    </div>

    <script id="chart-labels" type="application/json">{!! json_encode($chartLabels) !!}</script>
    <script id="chart-income-series" type="application/json">{!! json_encode($incomeSeries) !!}</script>
    <script id="chart-expense-series" type="application/json">{!! json_encode($expenseSeries) !!}</script>
    <script id="chart-category-labels" type="application/json">{!! json_encode($categoryLabels) !!}</script>
    <script id="chart-category-series" type="application/json">{!! json_encode($categorySeries) !!}</script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') {
                return;
            }

            const labels = JSON.parse(document.getElementById('chart-labels').textContent || '[]');
            const incomeSeries = JSON.parse(document.getElementById('chart-income-series').textContent || '[]');
            const expenseSeries = JSON.parse(document.getElementById('chart-expense-series').textContent || '[]');
            const categoryLabels = JSON.parse(document.getElementById('chart-category-labels').textContent || '[]');
            const categorySeries = JSON.parse(document.getElementById('chart-category-series').textContent || '[]');

            const trendCanvas = document.getElementById('cashflowTrendChart');
            if (trendCanvas && !trendCanvas.dataset.chartReady) {
                trendCanvas.dataset.chartReady = '1';
                new Chart(trendCanvas, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Income',
                                data: incomeSeries,
                                borderColor: '#059669',
                                backgroundColor: 'rgba(5, 150, 105, 0.15)',
                                tension: 0.35,
                                borderWidth: 2,
                                fill: true
                            },
                            {
                                label: 'Expense',
                                data: expenseSeries,
                                borderColor: '#dc2626',
                                backgroundColor: 'rgba(220, 38, 38, 0.12)',
                                tension: 0.35,
                                borderWidth: 2,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#e2e8f0'
                                }
                            },
                            x: {
                                grid: {
                                    color: '#f1f5f9'
                                }
                            }
                        }
                    }
                });
            }

            const categoryCanvas = document.getElementById('expenseCategoryChart');
            if (categoryCanvas && categorySeries.length > 0 && !categoryCanvas.dataset.chartReady) {
                categoryCanvas.dataset.chartReady = '1';
                new Chart(categoryCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: categoryLabels,
                        datasets: [
                            {
                                data: categorySeries,
                                backgroundColor: ['#0f766e', '#14b8a6', '#0ea5e9', '#6366f1', '#f59e0b', '#f97316', '#ef4444', '#a855f7'],
                                borderWidth: 0
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
