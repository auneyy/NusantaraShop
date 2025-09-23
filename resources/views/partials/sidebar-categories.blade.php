<style>
    .filter-sidebar {
        position: sticky;
        top: 20px;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .filter-section {
        border-bottom: 1px solid #eee;
        margin-bottom: 15px;
        padding-bottom: 10px;
    }

    .filter-header {
        font-size: 1rem;
        font-weight: 600;
        color: #222;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        padding: 8px 0;
    }

    .filter-header:hover {
        color: #422D1C;
    }

    .filter-options {
        margin-top: 8px;
        display: none;
        padding-left: 5px;
    }

    .filter-options.show {
        display: block;
    }

    .filter-option {
        display: block;
        font-size: 0.9rem;
        color: #444;
        margin: 6px 0;
        cursor: pointer;
        text-decoration: none;
    }

    .filter-option:hover {
        color: #422D1C;
    }

    .filter-option.active {
        font-weight: 600;
        color: #422D1C;
    }
</style>

<div class="filter-sidebar">

    <!-- Filter Kategori -->
    <div class="filter-section">
        <div class="filter-header" onclick="toggleFilter('categoryFilter')">
            Kategori <span>+</span>
        </div>
        <div id="categoryFilter" class="filter-options">
            <a href="{{ route('products.index') }}" 
               class="filter-option {{ request('category') ? '' : 'active' }}">
               Semua
            </a>
            @foreach($categories->sortBy('name') as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                   class="filter-option {{ request('category') == $category->slug ? 'active' : '' }}">
                   {{ $category->name }} ({{ $category->products_count }})
                </a>
            @endforeach
        </div>
    </div>

    <!-- Filter Harga -->
    <div class="filter-section">
        <div class="filter-header" onclick="toggleFilter('priceFilter')">
            Harga <span>+</span>
        </div>
        <div id="priceFilter" class="filter-options">
            <a href="{{ route('products.index', ['sort' => 'asc']) }}"
               class="filter-option {{ request('sort') == 'asc' ? 'active' : '' }}">
               Harga Terendah
            </a>
            <a href="{{ route('products.index', ['sort' => 'desc']) }}"
               class="filter-option {{ request('sort') == 'desc' ? 'active' : '' }}">
               Harga Tertinggi
            </a>
        </div>
    </div>

</div>

<script>
    function toggleFilter(id) {
        document.getElementById(id).classList.toggle('show');
    }
</script>
