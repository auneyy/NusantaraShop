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
            @php
                $currentParams = request()->except('category', 'page');
            @endphp
            <a href="{{ route('products.index', $currentParams) }}" 
               class="filter-option {{ !request('category') ? 'active' : '' }}">
               Semua
            </a>
            @foreach($categories->sortBy('name') as $category)
                @php
                    $params = array_merge($currentParams, ['category' => $category->slug]);
                @endphp
                <a href="{{ route('products.index', $params) }}"
                   class="filter-option {{ request('category') == $category->slug ? 'active' : '' }}">
                   {{ $category->name }} ({{ $category->products_count }})
                </a>
            @endforeach
        </div>
    </div>

    <!-- Filter Harga -->
    <div class="filter-section">
        <div class="filter-header" onclick="toggleFilter('priceFilter')">
            Urutkan <span>+</span>
        </div>
        <div id="priceFilter" class="filter-options">
            @php
                $currentParams = request()->except('sort', 'page');
            @endphp
            
            <!-- Default/Terbaru -->
            <a href="{{ route('products.index', $currentParams) }}"
               class="filter-option {{ !request('sort') ? 'active' : '' }}">
               Terbaru
            </a>

              <!-- Nama A-Z -->
            <a href="{{ route('products.index', array_merge($currentParams, ['sort' => 'name_asc'])) }}"
               class="filter-option {{ request('sort') == 'name_asc' ? 'active' : '' }}">
               Nama A-Z
            </a>
            
            <!-- Nama Z-A -->
            <a href="{{ route('products.index', array_merge($currentParams, ['sort' => 'name_desc'])) }}"
               class="filter-option {{ request('sort') == 'name_desc' ? 'active' : '' }}">
               Nama Z-A
            </a>
            
            <!-- Harga Terendah ke Tertinggi -->
            <a href="{{ route('products.index', array_merge($currentParams, ['sort' => 'price_asc'])) }}"
               class="filter-option {{ request('sort') == 'price_asc' ? 'active' : '' }}">
               Harga Terendah
            </a>
            
            <!-- Harga Tertinggi ke Terendah -->
            <a href="{{ route('products.index', array_merge($currentParams, ['sort' => 'price_desc'])) }}"
               class="filter-option {{ request('sort') == 'price_desc' ? 'active' : '' }}">
               Harga Tertinggi
            </a>
        </div>
    </div>
</div>

<script>
    function toggleFilter(id) {
        const element = document.getElementById(id);
        element.classList.toggle('show');
        
        // Update icon +/-
        const header = element.previousElementSibling;
        const span = header.querySelector('span');
        span.textContent = element.classList.contains('show') ? '−' : '+';
    }

    // Auto expand active filter
    document.addEventListener('DOMContentLoaded', function() {
        const activeFilters = document.querySelectorAll('.filter-option.active');
        activeFilters.forEach(active => {
            const filterSection = active.closest('.filter-options');
            if (filterSection) {
                filterSection.classList.add('show');
                const header = filterSection.previousElementSibling;
                const span = header.querySelector('span');
                span.textContent = '−';
            }
        });
    });
</script>