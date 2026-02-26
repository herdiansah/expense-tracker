<x-app-layout>
    <div class="mb-6 mx-auto" style="max-width: 600px;">
        <a href="{{ route('transactions.index') }}" class="nav-link page-back-link">&larr; Back to Transactions</a>
        <h2 class="title-gradient page-title">New Transaction</h2>
    </div>

    <div class="glass-card mx-auto" style="max-width: 600px;">
        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="form-group" style="margin-bottom: 0.75rem;">
                <label class="form-label">Type</label>
                <div class="flex gap-4" style="margin-top: 0.5rem;">
                    <label class="flex items-center gap-2" style="cursor: pointer;">
                        <input type="radio" name="type" value="expense" {{ old('type', 'expense') === 'expense' ? 'checked' : '' }} onchange="filterCategories()">
                        <span>Expense</span>
                    </label>
                    <label class="flex items-center gap-2" style="cursor: pointer;">
                        <input type="radio" name="type" value="income" {{ old('type') === 'income' ? 'checked' : '' }} onchange="filterCategories()">
                        <span>Income</span>
                    </label>
                </div>
                @error('type')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="dashboard-grid" style="grid-template-columns: 1fr 1fr; gap: 0.9rem; margin-bottom: 0;">
                @php
                    $symbol = \App\Http\Controllers\ReportController::currencySymbol(auth()->user()->currency);
                @endphp
                <div class="form-group" style="margin-bottom: 0.75rem;">
                    <label for="amount" class="form-label">Amount ({{ $symbol }})</label>
                    <input type="number" step="0.01" min="0.01" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required>
                    @error('amount')
                        <p style="color: var(--danger); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 0.75rem;">
                    <label for="transaction_date" class="form-label">Date</label>
                    <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ old('transaction_date', now()->format('Y-m-d')) }}" required>
                    @error('transaction_date')
                        <p style="color: var(--danger); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="dashboard-grid" style="grid-template-columns: 1fr 1fr; gap: 0.9rem; margin-bottom: 0;">
                <div class="form-group" style="margin-bottom: 0.75rem;">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-type="{{ $category->type }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p style="color: var(--danger); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 0.75rem;">
                    <label for="payment_method" class="form-label">Payment Method (Optional)</label>
                    <input type="text" name="payment_method" id="payment_method" class="form-control" placeholder="e.g. Credit Card, Cash" value="{{ old('payment_method') }}">
                    @error('payment_method')
                        <p style="color: var(--danger); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 0.75rem;">
                <label for="description" class="form-label">Description</label>
                <input type="text" name="description" id="description" class="form-control" placeholder="What was this for?" value="{{ old('description') }}" required>
                @error('description')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 0.75rem;">
                <label for="notes" class="form-label">Additional Notes (Optional)</label>
                <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5">
                <button type="submit" class="btn-primary">Save Transaction</button>
            </div>
        </form>
    </div>

    <!-- Script to filter categories based on selected type -->
    <script>
        function filterCategories() {
            const selectedType = document.querySelector('input[name="type"]:checked').value;
            const categorySelect = document.getElementById('category_id');
            const options = categorySelect.querySelectorAll('option[data-type]');
            
            let firstVisible = null;

            options.forEach(option => {
                if (option.getAttribute('data-type') === selectedType) {
                    option.style.display = '';
                    if (!firstVisible) firstVisible = option;
                } else {
                    option.style.display = 'none';
                    if (categorySelect.value === option.value) {
                        categorySelect.value = '';
                    }
                }
            });
        }
        
        // Run on load
        document.addEventListener('DOMContentLoaded', filterCategories);
    </script>
</x-app-layout>
