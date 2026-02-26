<x-app-layout>
    <div class="mb-6 mx-auto" style="max-width: 450px;">
        <a href="{{ route('categories.index') }}" class="nav-link page-back-link">&larr; Back to Categories</a>
        <h2 class="title-gradient page-title">Add Category</h2>
    </div>

    <div class="glass-card mx-auto" style="max-width: 450px;">
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="form-group" style="margin-bottom: 0.75rem;">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Groceries" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 0.75rem;">
                <label class="form-label">Type</label>
                <div class="flex gap-4" style="margin-top: 0.5rem;">
                    <label class="flex items-center gap-2" style="cursor: pointer;">
                        <input type="radio" name="type" value="expense" {{ old('type', 'expense') === 'expense' ? 'checked' : '' }}>
                        <span>Expense</span>
                    </label>
                    <label class="flex items-center gap-2" style="cursor: pointer;">
                        <input type="radio" name="type" value="income" {{ old('type') === 'income' ? 'checked' : '' }}>
                        <span>Income</span>
                    </label>
                </div>
                @error('type')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5">
                <button type="submit" class="btn-primary">Save Category</button>
            </div>
        </form>
    </div>
</x-app-layout>
