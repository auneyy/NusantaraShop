@extends('layout.app')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    
    .content-wrapper {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

    .product-card-wrapper {
        width: 100%;
        max-width: none;
        margin: 0 auto;
    }

    .product-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .product-card-link:hover {
        text-decoration: none;
    }

    .minimalist-product-card {
        border: none;
        border-radius: 0;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #ffffff;
        position: relative;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.5);
    }

    .minimalist-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .product-image-container {
        position: relative;
        width: 100%;
        aspect-ratio: 4 / 5;
        overflow: hidden;
    }

    .product-image-primary,
    .product-image-secondary {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.4s ease;
    }

    .product-image-secondary {
        opacity: 0;
    }

    .minimalist-product-card:hover .product-image-primary {
        opacity: 0;
    }

    .minimalist-product-card:hover .product-image-secondary {
        opacity: 1;
    }

    .card-body-clean {
        padding: 1rem;
        text-align: center;
    }

    .product-title {
        font-size: 16px !important;
        font-weight: 500;
        color: black;
        margin-bottom: 0.25rem;
    }

    .product-price {
        font-size: 14px !important;
        font-weight: 500;
        color: #8B4513;
        margin-bottom: 0;
    }

    .section-title {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .section-title h2 {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
        margin-top: 1.5rem;
    }

    /* Search Header Styles */
    .search-header-section {
        background: #ffffff;
        padding: 60px 0 40px;
        border-bottom: 1px solid #e5e5e5;
        margin-bottom: 2rem;
    }

    .search-title {
        font-size: 2.5rem;
        font-weight: 400;
        color: #2c2c2c;
        text-align: center;
        margin-bottom: 40px;
        letter-spacing: 0.5px;
    }

    .search-box-container {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
    }

    .search-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        background: #ffffff;
        border: 2px solid #2c2c2c;
        border-radius: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .search-input-wrapper:focus-within {
        border-color: #422D1C;
        box-shadow: 0 4px 12px rgba(66, 45, 28, 0.15);
    }

    .search-input {
        width: 100%;
        border: none;
        padding: 18px 60px 18px 24px;
        font-size: 1rem;
        color: #2c2c2c;
        background: transparent;
        outline: none;
    }

    .search-input::placeholder {
        color: #999;
        font-weight: 300;
    }

    .search-icon-btn {
        position: absolute;
        right: 0;
        background: transparent;
        border: none;
        padding: 18px 24px;
        cursor: pointer;
        color: #2c2c2c;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .search-icon-btn:hover {
        color: #422D1C;
    }

    .close-search-btn {
        position: absolute;
        right: 60px;
        background: transparent;
        border: none;
        padding: 18px 12px;
        cursor: pointer;
        color: #999;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .close-search-btn:hover {
        color: #2c2c2c;
    }

    /* Results Info */
    .results-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 0 1rem;
    }

    .results-count {
        font-size: 1.1rem;
        color: #2c2c2c;
        font-weight: 400;
    }

    /* Sorting Controls */
    .sorting-controls {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .sort-select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #fff;
        font-size: 14px;
        color: #2d3748;
        cursor: pointer;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .sort-select:hover {
        border-color: #422D1C;
    }

    .sort-select:focus {
        border-color: #422D1C;
        box-shadow: 0 0 0 2px rgba(66, 45, 28, 0.15);
        outline: none;
    }

    /* No Results */
    .no-results {
        text-align: center;
        padding: 100px 20px;
    }

    .no-results-icon {
        font-size: 4rem;
        color: #d0d0d0;
        margin-bottom: 30px;
    }

    .no-results-title {
        font-size: 1.8rem;
        font-weight: 400;
        color: #2c2c2c;
        margin-bottom: 15px;
    }

    .no-results-text {
        font-size: 1rem;
        color: #666;
        line-height: 1.6;
        max-width: 600px;
        margin: 0 auto 30px;
    }

    .btn-home {
        display: inline-block;
        background: #2c2c2c;
        color: #ffffff;
        padding: 14px 32px;
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        border: 1px solid #2c2c2c;
    }

    .btn-home:hover {
        background: #422D1C;
        border-color: #422D1C;
        color: #ffffff;
    }
</style>

<div class="content-wrapper">
    <!-- Search Header -->
    <div class="search-header-section">
        <div class="container">
            <h1 class="search-title">Search Results</h1>
            
            <div class="search-box-container">
                <form method="GET" action="{{ route('search') }}">
                    <div class="search-input-wrapper">
                        <input 
                            type="text" 
                            name="q"
                            class="search-input" 
                            placeholder="Search for products..."
                            value="{{ $searchTerm ?? '' }}"
                            autocomplete="off">
                        
                        @if(!empty($searchTerm))
                            <button type="button" class="close-search-btn" onclick="document.querySelector('.search-input').value=''; this.form.submit();">
                                <i class="bi bi-x"></i>
                            </button>
                        @endif
                        
                        <button type="submit" class="search-icon-btn">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        @if($products->count() > 0)
            <!-- Results Info & Controls -->
            <div class="results-info">
                <div class="results-count">
                    <strong>{{ $products->total() }}</strong> results found for "<strong>{{ $searchTerm }}</strong>"
                </div>
                
                <!-- Sorting Controls -->
                <div class="sorting-controls">
                    <form method="GET" action="{{ route('search') }}">
                        <input type="hidden" name="q" value="{{ $searchTerm }}">
                        @if(!empty($category))
                            <input type="hidden" name="category" value="{{ $category }}">
                        @endif
                        @if(!empty($minPrice))
                            <input type="hidden" name="min_price" value="{{ $minPrice }}">
                        @endif
                        @if(!empty($maxPrice))
                            <input type="hidden" name="max_price" value="{{ $maxPrice }}">
                        @endif
                        
                        <select name="sort_by" class="sort-select" onchange="this.form.submit()">
                            <option value="latest" {{ ($sortBy ?? '') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="name" {{ ($sortBy ?? '') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                            <option value="price_low" {{ ($sortBy ?? '') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ ($sortBy ?? '') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row g-3">
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product-card-wrapper">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>

        @else
            <!-- No Results -->
            <div class="no-results">
                <div class="no-results-icon">
                    <i class="bi bi-search"></i>
                </div>
                <h2 class="no-results-title">No products found</h2>
                <p class="no-results-text">
                    @if(!empty($searchTerm))
                        We couldn't find any products matching "<strong>{{ $searchTerm }}</strong>".
                        <br>Try different keywords or browse our categories.
                    @else
                        No products available at the moment.
                    @endif
                </p>
                <a href="{{ route('home') ?? url('/') }}" class="btn-home">Continue Shopping</a>
            </div>
        @endif
    </div>
</div>
@endsection