@extends('layout.app')

@section('content')
<style>
  .search-results-container {
    min-height: 80vh;
    padding: 40px 0;
    background: #f8f9fa;
  }

  .search-header {
    background: white;
    padding: 30px 0;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
  }

  .search-query-highlight {
    color: #422D1C;
    font-weight: 600;
  }

  .search-stats {
    color: #6c757d;
    font-size: 1rem;
    margin-top: 10px;
  }

  .search-filters {
    background: white;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  }

  .filter-section {
    margin-bottom: 25px;
  }

  .filter-title {
    color: #422D1C;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
  }

  .filter-title i {
    margin-right: 8px;
    font-size: 1rem;
  }

  .filter-options {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  .filter-option {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    padding: 8px 15px;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    text-decoration: none;
    color: #495057;
  }

  .filter-option:hover,
  .filter-option.active {
    background: #422D1C;
    border-color: #422D1C;
    color: white;
  }

  .price-range-inputs {
    display: flex;
    gap: 10px;
    align-items: center;
  }

  .price-input {
    width: 120px;
    padding: 8px 12px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 0.9rem;
  }

  .price-input:focus {
    outline: none;
    border-color: #422D1C;
  }

  .sort-dropdown {
    background: white;
    border: 2px solid #e9ecef;
    padding: 10px 15px;
    border-radius: 8px;
    font-size: 0.9rem;
    cursor: pointer;
  }

  .sort-dropdown:focus {
    outline: none;
    border-color: #422D1C;
  }

  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
  }

  .product-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }

  .product-image {
    width: 100%;
    height: 280px;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .product-card:hover .product-image {
    transform: scale(1.08);
  }

  .product-info {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .product-category {
    color: #8B4513;
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .product-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #422D1C;
    margin-bottom: 12px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex-grow: 1;
  }

  .product-price {
    font-size: 1.4rem;
    font-weight: 700;
    color: #8B4513;
    margin-bottom: 15px;
  }

  .product-description {
    font-size: 0.9rem;
    color: #6c757d;
    line-height: 1.5;
    margin-bottom: 15px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .btn-view-product {
    background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    margin-top: auto;
  }

  .btn-view-product:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(66, 45, 28, 0.3);
    color: white;
  }

  .no-results {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    margin: 40px 0;
  }

  .no-results-icon {
    font-size: 5rem;
    color: #dee2e6;
    margin-bottom: 25px;
  }

  .no-results h3 {
    color: #422D1C;
    font-weight: 600;
    font-size: 1.8rem;
    margin-bottom: 15px;
  }

  .no-results p {
    color: #6c757d;
    font-size: 1.1rem;
    margin-bottom: 30px;
    line-height: 1.6;
  }

  .btn-back-shopping {
    background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
    color: white;
    border: none;
    padding: 15px 35px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
  }

  .btn-back-shopping:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(66, 45, 28, 0.3);
    color: white;
  }

  .pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 50px;
  }

  .pagination {
    background: white;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  }

  .page-link {
    color: #422D1C;
    border: none;
    padding: 10px 15px;
    margin: 0 2px;
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .page-link:hover,
  .page-item.active .page-link {
    background-color: #422D1C;
    color: white;
  }

  .results-summary {
    background: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 25px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
  }

  .clear-filters-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    font-size: 0.85rem;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
  }

  .clear-filters-btn:hover {
    background: #c82333;
    color: white;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .products-grid {
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
    }

    .search-results-container {
      padding: 20px 0;
    }

    .search-header {
      padding: 20px 0;
    }

    .search-filters {
      padding: 20px;
    }

    .filter-options {
      justify-content: center;
    }

    .price-range-inputs {
      justify-content: center;
      flex-wrap: wrap;
    }

    .product-image {
      height: 220px;
    }

    .product-info {
      padding: 15px;
    }
  }
</style>

<div class="search-results-container">
  <div class="search-header">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1>
            <i class="bi bi-search me-3"></i>Hasil Pencarian
            @if(!empty($query))
              untuk "<span class="search-query-highlight">{{ $query }}</span>"
            @endif
          </h1>
          <div class="search-stats">
            Ditemukan <strong>{{ $products->total() }}</strong> produk
            @if(!empty($query))
              yang cocok dengan pencarian Anda
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    @if($products->count() > 0)
      <!-- Search Filters -->
      <div class="search-filters">
        <form method="GET" action="{{ route('search') }}" id="searchForm">
          <input type="hidden" name="search" value="{{ $query }}">
          
          <div class="row">
            <!-- Category Filter -->
            @if(isset($categories) && $categories->count() > 0)
            <div class="col-md-6 col-lg-4">
              <div class="filter-section">
                <div class="filter-title">
                  <i class="bi bi-grid"></i>Kategori
                </div>
                <div class="filter-options">
                  <a href="{{ request()->fullUrlWithQuery(['category' => '']) }}" 
                     class="filter-option {{ empty($category) ? 'active' : '' }}">
                    Semua
                  </a>
                  @foreach($categories->take(4) as $cat)
                    <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}" 
                       class="filter-option {{ $category == $cat->slug ? 'active' : '' }}">
                      {{ $cat->name }}
                    </a>
                  @endforeach
                </div>
              </div>
            </div>
            @endif

            <!-- Price Range Filter -->
            <div class="col-md-6 col-lg-4">
              <div class="filter-section">
                <div class="filter-title">
                  <i class="bi bi-currency-dollar"></i>Rentang Harga
                </div>
                <div class="price-range-inputs">
                  <input type="number" name="min_price" value="{{ $minPrice ?? '' }}" 
                         placeholder="Min" class="price-input">
                  <span>-</span>
                  <input type="number" name="max_price" value="{{ $maxPrice ?? '' }}" 
                         placeholder="Max" class="price-input">
                  <button type="submit" class="btn btn-sm" style="background: #422D1C; color: white;">
                    <i class="bi bi-search"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- Sort Options -->
            <div class="col-md-6 col-lg-4">
              <div class="filter-section">
                <div class="filter-title">
                  <i class="bi bi-sort-down"></i>Urutkan
                </div>
                <select name="sort_by" class="sort-dropdown" onchange="this.form.submit()">
                  <option value="latest" {{ ($sortBy ?? '') == 'latest' ? 'selected' : '' }}>
                    Terbaru
                  </option>
                  <option value="price_low" {{ ($sortBy ?? '') == 'price_low' ? 'selected' : '' }}>
                    Harga Terendah
                  </option>
                  <option value="price_high" {{ ($sortBy ?? '') == 'price_high' ? 'selected' : '' }}>
                    Harga Tertinggi
                  </option>
                  <option value="name" {{ ($sortBy ?? '') == 'name' ? 'selected' : '' }}>
                    Nama A-Z
                  </option>
                </select>
              </div>
            </div>
          </div>

          <!-- Clear Filters -->
          @if(!empty($category) || !empty($minPrice) || !empty($maxPrice) || !empty($sortBy))
            <div class="mt-3">
              <a href="{{ route('search') }}?search={{ $query }}" class="clear-filters-btn">
                <i class="bi bi-x-circle me-1"></i>Hapus Filter
              </a>
            </div>
          @endif
        </form>
      </div>

      <!-- Results Summary -->
      <div class="results-summary">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            Menampilkan {{ $products->firstItem() }}-{{ $products->lastItem() }} 
            dari {{ $products->total() }} produk
          </div>
          <div class="text-muted">
            Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}
          </div>
        </div>
      </div>

      <!-- Products Grid -->
      <div class="products-grid">
        @foreach($products as $product)
          <div class="product-card">
            @if($product->images && $product->images->count() > 0)
              <img src="{{ asset($product->images->first()->image_path) }}" 
                   alt="{{ $product->name }}" class="product-image">
            @else
              <img src="{{ asset('storage/product_images/default.jpg') }}" 
                   alt="{{ $product->name }}" class="product-image">
            @endif
            
            <div class="product-info">
              @if($product->category)
                <div class="product-category">{{ $product->category->name }}</div>
              @endif
              
              <h5 class="product-title">{{ $product->name }}</h5>
              
              @if($product->description)
                <p class="product-description">{{ $product->description }}</p>
              @endif
              
              <div class="product-price">
                Rp {{ number_format($product->price, 0, ',', '.') }}
              </div>
              
              <a href="{{ route('products.show', $product->slug ?? $product->id) }}" 
                 class="btn-view-product">
                <i class="bi bi-eye me-2"></i>Lihat Detail
              </a>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination -->
      @if($products->hasPages())
        <div class="pagination-container">
          {{ $products->appends(request()->query())->links() }}
        </div>
      @endif

    @else
      <!-- No Results -->
      <div class="no-results">
        <div class="no-results-icon">
          <i class="bi bi-search"></i>
        </div>
        <h3>Tidak ada produk yang ditemukan</h3>
        <p>
          @if(!empty($query))
            Maaf, kami tidak dapat menemukan produk yang sesuai dengan pencarian 
            "<strong>{{ $query }}</strong>".
          @else
            Tidak ada produk yang tersedia saat ini.
          @endif
          <br>
          Coba gunakan kata kunci yang berbeda atau jelajahi kategori produk kami.
        </p>
        <a href="{{ route('home') }}" class="btn-back-shopping">
          <i class="bi bi-house me-2"></i>Kembali Berbelanja
        </a>
      </div>
    @endif
  </div>
</div>

@endsection