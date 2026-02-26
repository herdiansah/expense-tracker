<x-app-layout>
    <div class="page-header">
        <h2 class="title-gradient page-title">Categories</h2>
        <a href="{{ route('categories.create') }}" class="btn-primary">
            + Add Category
        </a>
    </div>

    <div class="glass-card">
        @if($categories->count() > 0)
            <div style="overflow-x: auto;">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td data-label="Name">{{ $category->name }}</td>
                                <td data-label="Type">
                                    <span class="badge {{ $category->type === 'income' ? 'badge-income' : 'badge-expense' }}">
                                        {{ ucfirst($category->type) }}
                                    </span>
                                </td>
                                <td data-label="Actions" class="actions-cell flex justify-between gap-2" style="justify-content: flex-end;">
                                    <a href="{{ route('categories.edit', $category) }}" class="btn-secondary" style="padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.85rem;">Edit</a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" style="margin: 0;">
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
        @else
            <div style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                <p>You haven't added any categories yet.</p>
                <a href="{{ route('categories.create') }}" class="btn-primary mt-4">Create your first category</a>
            </div>
        @endif
    </div>
</x-app-layout>
