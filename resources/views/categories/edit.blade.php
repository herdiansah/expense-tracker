<x-app-layout>
    <div class="mb-6 mx-auto" style="max-width: 450px;">
        <a href="{{ route('categories.index') }}" class="nav-link page-back-link">&larr; Back to Categories</a>
        <h2 class="title-gradient page-title">Edit Category</h2>
    </div>

    <div class="glass-card mx-auto" style="max-width: 450px;">
        <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 0.75rem;">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required autofocus>
                @error('name')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 0.75rem;">
                <label class="form-label">Type</label>
                <div class="flex gap-4" style="margin-top: 0.5rem;">
                    <label class="flex items-center gap-2" style="cursor: pointer;">
                        <input type="radio" name="type" value="expense" {{ old('type', $category->type) === 'expense' ? 'checked' : '' }}>
                        <span>Expense</span>
                    </label>
                    <label class="flex items-center gap-2" style="cursor: pointer;">
                        <input type="radio" name="type" value="income" {{ old('type', $category->type) === 'income' ? 'checked' : '' }}>
                        <span>Income</span>
                    </label>
                </div>
                @error('type')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5 flex gap-4">
                <button type="submit" class="btn-primary">Update Category</button>
            </div>
        </form>
    </div>
</x-app-layout>
