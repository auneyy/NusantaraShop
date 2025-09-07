<style>
    .elegant-category-sidebar {
        list-style: none;
        padding: 0;
        margin: 0;
        position: sticky;
        top: 20px;
    }

    .elegant-category-sidebar-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #222;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e0e0e0;
        margin-bottom: 1rem;
    }

    .elegant-category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        color: #555;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 400;
        font-size: 0.95rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .elegant-category-item:hover {
        background-color: #f7f7f7;
        color: #222;
        padding-left: 10px;
    }

    .elegant-category-item.active {
        background-color: #eaeaea;
        color: #222;
        font-weight: 500;
    }

    .elegant-category-item:last-child {
        border-bottom: none;
    }

    .elegant-category-badge {
        background: #ececec !important;
        color: #422D1C !important;
        padding: 4px 8px;
        font-size: 0.75rem;
        font-weight: 500;
        min-width: 25px;
        text-align: center;
        border-radius: 12px;
        transition: all 0.2s ease;
    }
</style>

<div class="elegant-category-sidebar">
    <h5 class="elegant-category-sidebar-title">Kategori</h5>
    <ul class="list-group list-group-flush">
        @foreach($categories->sortBy('name') as $category)
            <a
                href="{{ route('products.index') }}?category={{ $category->slug }}"
                class="elegant-category-item list-group-item-action {{ request('category') == $category->slug ? 'active' : '' }}"
            >
                {{ $category->name }}
                <span class="elegant-category-badge">{{ $category->products_count }}</span>
            </a>
        @endforeach
    </ul>
</div>
