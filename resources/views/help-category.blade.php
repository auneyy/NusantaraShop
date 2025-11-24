{{-- File: resources/views/help-category.blade.php --}}
@extends('layout.app')

@section('content')
<style>
:root {
  --primary-color: #422D1C;
  --secondary-color: #8B4513;
  --accent-color: #D4A76A;
  --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.page-header {
  background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
  padding: 6rem 0 3rem;
  color: white;
}

.breadcrumb {
  background: transparent;
  padding: 0;
  margin-bottom: 1rem;
}

.breadcrumb-item a { color: white; text-decoration: none; }
.breadcrumb-item a:hover { text-decoration: underline; }
.breadcrumb-item.active { color: white; }
.breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.6); }

.category-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 60px;
  height: 60px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 15px;
  margin-bottom: 1rem;
  font-size: 2rem;
}

.category-content {
  padding: 4rem 0;
  background: #f8f9fa;
  min-height: 50vh;
}

.articles-list {
  background: white;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: var(--shadow-md);
}

.article-card {
  background: white;
  border-radius: 12px;
  padding: 1.5rem;
  margin-bottom: 1rem;
  border: 1px solid #e0e0e0;
  transition: var(--transition);
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.article-card:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow-lg);
  border-color: var(--accent-color);
}

.article-card-title {
  color: var(--primary-color);
  font-weight: 600;
  font-size: 1.1rem;
  margin: 0;
}

.article-card-excerpt {
  color: #666;
  font-size: 0.95rem;
  margin: 0.5rem 0 0 0;
}

.article-arrow {
  color: var(--accent-color);
  font-size: 1.5rem;
  transition: var(--transition);
}

.article-card:hover .article-arrow {
  transform: translateX(8px);
}

.empty-state {
  text-align: center;
  padding: 4rem 2rem;
}

.empty-state i {
  font-size: 4rem;
  color: #ccc;
}

/* Modal */
.article-modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
  z-index: 9999;
  overflow-y: auto;
}

.article-modal.active {
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-content-article {
  background: white;
  border-radius: 20px;
  padding: 3rem;
  max-width: 800px;
  width: 90%;
  margin: 2rem auto;
  position: relative;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-close {
  position: absolute;
  top: 1rem;
  right: 1.5rem;
  background: none;
  border: none;
  font-size: 2rem;
  color: #666;
  cursor: pointer;
  transition: var(--transition);
}

.modal-close:hover {
  color: var(--primary-color);
}

.modal-article-title {
  color: var(--primary-color);
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 1rem;
  padding-right: 2rem;
}

.modal-article-category {
  display: inline-block;
  background: var(--accent-color);
  color: white;
  padding: 0.4rem 1rem;
  border-radius: 20px;
  font-size: 0.85rem;
  margin-bottom: 1.5rem;
}

.modal-article-content {
  line-height: 1.8;
  color: #333;
}

.modal-article-content h3, .modal-article-content h4 {
  color: var(--primary-color);
  margin-top: 1.5rem;
}

.modal-article-content ul, .modal-article-content ol {
  margin-left: 1.5rem;
}

@media (max-width: 768px) {
  .page-header { padding: 5rem 0 2rem; }
  .modal-content-article { padding: 2rem; width: 95%; }
  .modal-article-title { font-size: 1.4rem; }
}
</style>

<!-- Page Header -->
<div class="page-header">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('help') }}">Bantuan</a></li>
        <li class="breadcrumb-item active">{{ $categoryName }}</li>
      </ol>
    </nav>
    
    <div class="category-icon">
      @if($category == 'getting-started')
        <i class="bi bi-play-circle"></i>
      @elseif($category == 'account-billing')
        <i class="bi bi-credit-card"></i>
      @else
        <i class="bi bi-gear"></i>
      @endif
    </div>
    
    <h1 class="display-5 fw-bold mb-3">{{ $categoryName }}</h1>
    <p class="lead mb-0">
      @if($category == 'getting-started')
        Panduan untuk memulai berbelanja di BatikKraton
      @elseif($category == 'account-billing')
        Kelola akun, pesanan, dan pembayaran Anda
      @else
        Solusi untuk masalah yang sering terjadi
      @endif
    </p>
  </div>
</div>

<!-- Articles Content -->
<div class="category-content">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 mx-auto">
        <div class="articles-list">
          @if($articles->count() > 0)
            <h5 class="mb-4" style="color: var(--primary-color); font-weight: 700;">
              <i class="bi bi-journal-text me-2"></i>{{ $articles->count() }} Artikel Ditemukan
            </h5>
            
            @foreach($articles as $article)
            <div class="article-card" data-article-id="{{ $article->id }}">
              <div style="flex: 1;">
                <h5 class="article-card-title">{{ $article->title }}</h5>
                <p class="article-card-excerpt">{{ Str::limit(strip_tags($article->content), 100) }}</p>
              </div>
              <i class="bi bi-arrow-right article-arrow"></i>
            </div>
            @endforeach
          @else
            <div class="empty-state">
              <i class="bi bi-inbox d-block mb-3"></i>
              <h4 style="color: #666;">Belum ada artikel</h4>
              <p class="text-muted">Artikel dalam kategori ini akan segera ditambahkan</p>
            </div>
          @endif
        </div>
        
        <div class="text-center mt-4">
          <a href="{{ route('help') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Bantuan
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Article Modal -->
<div class="article-modal" id="articleModal">
  <div class="modal-content-article">
    <button class="modal-close" id="modalClose">&times;</button>
    <div id="modalBody"></div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const articles = @json($articles);
  const categoryName = @json($categoryName);
  const modal = document.getElementById('articleModal');
  const modalBody = document.getElementById('modalBody');
  const modalClose = document.getElementById('modalClose');
  
  // Article click handler
  document.querySelectorAll('.article-card').forEach(card => {
    card.addEventListener('click', function() {
      const articleId = this.getAttribute('data-article-id');
      const article = articles.find(a => a.id == articleId);
      
      if (article) {
        modalBody.innerHTML = `
          <h2 class="modal-article-title">${article.title}</h2>
          <span class="modal-article-category">${categoryName}</span>
          <div class="modal-article-content">${article.content}</div>
        `;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
      }
    });
  });
  
  // Close modal
  function closeModal() {
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';
  }
  
  modalClose.addEventListener('click', closeModal);
  modal.addEventListener('click', function(e) {
    if (e.target === modal) closeModal();
  });
  
  // ESC key to close
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && modal.classList.contains('active')) {
      closeModal();
    }
  });
});
</script>
@endsection