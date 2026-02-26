<x-app-layout>
    <div class="page-header mx-auto" style="max-width: 600px;">
        <h2 class="title-gradient page-title">Reports & Exports</h2>
    </div>

    <div class="glass-card mx-auto" style="max-width: 600px;">
        <h3 class="mb-4" style="color: var(--text-primary);">Generate Transaction Report</h3>
        <p style="color: var(--text-secondary); margin-bottom: 1.25rem;">
            Filter your transactions by date, category, and type, then export the results as a CSV file to use in Excel or other spreadsheet software.
        </p>

        <form action="{{ route('reports.export') }}" method="GET" class="space-y-4">
            <div class="dashboard-grid" style="grid-template-columns: 1fr 1fr; gap: 0.9rem; margin-bottom: 0;">
                <div class="form-group" style="margin-bottom: 0.75rem;">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="form-group" style="margin-bottom: 0.75rem;">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
            </div>

            <div class="dashboard-grid" style="grid-template-columns: 1fr 1fr; gap: 0.9rem; margin-bottom: 0;">
                <div class="form-group" style="margin-bottom: 0.75rem;">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }} ({{ ucfirst($category->type) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0.75rem;">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control">
                        <option value="">All Types</option>
                        <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Expense</option>
                        <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Income</option>
                    </select>
                </div>
            </div>

            <div class="mt-5 flex gap-4">
                <button type="submit" class="btn-primary">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export to CSV
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
