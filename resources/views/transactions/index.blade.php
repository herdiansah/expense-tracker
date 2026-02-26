<x-app-layout>
    <div class="page-header">
        <h2 class="title-gradient page-title">Transactions</h2>
        <a href="{{ route('transactions.create') }}" class="btn-primary">
            + New Transaction
        </a>
    </div>

    <!-- Filters -->
    <div class="glass-card mb-8">
        <form action="{{ route('transactions.index') }}" method="GET" class="flex gap-4 items-center" style="flex-wrap: wrap;">
            <div class="form-group" style="margin-bottom: 0; min-width: 200px; flex: 1;">
                <label class="form-label" style="font-size: 0.85rem;">Type</label>
                <select name="type" class="form-control" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Expense</option>
                    <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Income</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0; min-width: 200px; flex: 1;">
                <label class="form-label" style="font-size: 0.85rem;">Category</label>
                <select name="category_id" class="form-control" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }} ({{ ucfirst($category->type) }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0; align-self: flex-end;">
                <a href="{{ route('transactions.index') }}" class="btn-secondary" style="padding: 0.75rem 1rem;">Clear Filters</a>
            </div>
        </form>
    </div>

    <div class="glass-card">
        @if($transactions->count() > 0)
            <div style="overflow-x: auto;">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td data-label="Date" style="color: var(--text-secondary); white-space: nowrap;">{{ $transaction->transaction_date->format('M d, Y') }}</td>
                                <td data-label="Description">{{ $transaction->description }}</td>
                                <td data-label="Category">
                                    <span class="badge {{ $transaction->type === 'income' ? 'badge-income' : 'badge-expense' }}">
                                        {{ $transaction->category->name }}
                                    </span>
                                </td>
                                <td data-label="Amount" class="{{ $transaction->type === 'income' ? 'positive' : 'negative' }}" style="font-weight: 600; white-space: nowrap;">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}{{ \App\Http\Controllers\ReportController::currencySymbol(auth()->user()->currency) }}{{ number_format($transaction->amount, 2) }}
                                </td>
                                <td data-label="Payment Method" style="color: var(--text-secondary);">{{ $transaction->payment_method ?? '-' }}</td>
                                <td data-label="Actions" class="actions-cell text-right flex justify-between gap-2" style="justify-content: flex-end;">
                                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn-secondary" style="padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.85rem;">Edit</a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Delete this transaction?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger" style="padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.85rem;">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $transactions->withQueryString()->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                <p>No transactions found matching your criteria.</p>
            </div>
        @endif
    </div>
</x-app-layout>
