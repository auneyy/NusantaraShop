{{-- resources/views/partials/reviews_list.blade.php --}}

@if($reviews->count() > 0)
    <div class="reviews-container">
        @foreach($reviews as $review)
            <div class="review-card mb-4">
                <div class="review-header">
                    <div class="review-avatar">
                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                    </div>
                    <div class="review-user">
                        <div class="review-user-name">{{ $review->user->name }}</div>
                        <div class="d-flex align-items-center">
                            <div class="rating-stars me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        @if($review->is_verified)
                            <span class="badge bg-success mt-1" style="font-size: 0.7rem;">
                                <i class="fas fa-check-circle"></i> Verified Purchase
                            </span>
                        @endif
                    </div>
                </div>
                
                @if($review->komentar)
                    <div class="review-comment mt-3">
                        <p class="mb-0" style="line-height: 1.6; color: #333;">{{ $review->komentar }}</p>
                    </div>
                @endif
                
                @if($review->images)
                    <div class="review-images mt-3">
                        @php
                            $images = is_array($review->images) ? $review->images : json_decode($review->images, true);
                        @endphp
                        @if($images)
                            @foreach($images as $image)
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="Review Image" 
                                     class="review-image" 
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; margin-right: 10px; cursor: pointer; border: 1px solid #e0e0e0;"
                                     onclick="showImageModal('{{ asset('storage/' . $image) }}')">
                            @endforeach
                        @endif
                    </div>
                @endif

                {{-- Helpful/Like Section (Optional) --}}
                <div class="review-footer mt-3 pt-3 border-top" style="border-color: #f0f0f0 !important;">
                    <small class="text-muted">
                        <i class="far fa-calendar"></i> {{ $review->created_at->format('d M Y, H:i') }}
                    </small>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($reviews->hasPages())
        <div class="review-pagination mt-4 d-flex justify-content-center">
            <nav aria-label="Review pagination">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($reviews->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="{{ $reviews->currentPage() - 1 }}" onclick="loadReviews({{ $reviews->currentPage() - 1 }}); return false;">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Page Numbers --}}
                    @php
                        $start = max($reviews->currentPage() - 2, 1);
                        $end = min($start + 4, $reviews->lastPage());
                        $start = max($end - 4, 1);
                    @endphp

                    @if($start > 1)
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="1" onclick="loadReviews(1); return false;">1</a>
                        </li>
                        @if($start > 2)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        <li class="page-item {{ $i == $reviews->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="#" data-page="{{ $i }}" onclick="loadReviews({{ $i }}); return false;">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    @if($end < $reviews->lastPage())
                        @if($end < $reviews->lastPage() - 1)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="{{ $reviews->lastPage() }}" onclick="loadReviews({{ $reviews->lastPage() }}); return false;">
                                {{ $reviews->lastPage() }}
                            </a>
                        </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($reviews->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="{{ $reviews->currentPage() + 1 }}" onclick="loadReviews({{ $reviews->currentPage() + 1 }}); return false;">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    @endif
@else
    <div class="no-reviews">
        <div class="text-center py-5">
            <i class="fas fa-comments" style="font-size: 3rem; color: #dee2e6; margin-bottom: 1rem;"></i>
            <h5 style="color: #6c757d;">Belum Ada Ulasan</h5>
            <p class="text-muted">Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
        </div>
    </div>
@endif

<style>
/* Additional styles for review list */
.review-card {
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 1.5rem;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.review-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.review-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: bold;
    margin-right: 1rem;
    flex-shrink: 0;
}

.review-user-name {
    font-weight: 600;
    font-size: 1rem;
    color: #212529;
    margin-bottom: 0.25rem;
}

.review-date {
    font-size: 0.85rem;
    color: #6c757d;
}

.rating-stars {
    font-size: 1rem;
}

.review-comment {
    color: #495057;
    font-size: 0.95rem;
}

.review-image {
    transition: transform 0.2s ease;
}

.review-image:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Pagination Styling */
.pagination {
    margin: 0;
}

.page-item .page-link {
    border: 1px solid #dee2e6;
    color: #422D1C;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    margin: 0 0.25rem;
    transition: all 0.2s ease;
}

.page-item .page-link:hover {
    background-color: #422D1C;
    color: white;
    border-color: #422D1C;
}

.page-item.active .page-link {
    background-color: #422D1C;
    border-color: #422D1C;
    color: white;
}

.page-item.disabled .page-link {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
}

.no-reviews {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 2rem;
}

@media (max-width: 768px) {
    .review-card {
        padding: 1rem;
    }
    
    .review-avatar {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .review-images {
        flex-wrap: wrap;
    }
    
    .review-image {
        width: 80px !important;
        height: 80px !important;
    }
}
</style>

<script>
// Function to show image in modal
function showImageModal(imageSrc) {
    const modal = document.getElementById('reviewImageModal');
    const modalImg = document.getElementById('modalImage');
    
    if (modal && modalImg) {
        modal.style.display = 'block';
        modalImg.src = imageSrc;
        document.body.style.overflow = 'hidden';
    }
}
</script>