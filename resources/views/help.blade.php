@extends('layout.app')

@section('content')
<style>
/* Tambahkan style yang sudah ada di sini */
:root {
  --primary-color: #422D1C;
  --secondary-color: #8B4513;
  --accent-color: #D4A76A;
  --light-bg: #F9F5F0;
  --dark-text: #2D2424;
  --light-text: #F5F5F5;
  --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

html, body {
  margin: 0;
  padding: 0;
}

.hero-help {
  position: relative;
  background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.1)), 
              url('/storage/product_images/heroimagebantuan.png') center/cover no-repeat;
  min-height: 85vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  overflow: hidden;
  color: var(--light-text);
  margin-top: 0;
  padding: 120px 0 80px 0;
}

.hero-content {
  max-width: 450px;
  margin: 0 auto;
  position: relative;
  z-index: 2;
}

.hero-help h1 {
  font-size: 3rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  line-height: 1.2;
  text-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
}

.hero-help p {
  font-size: 1.1rem;
  opacity: 0.9;
  margin-bottom: 2rem;
}

.search-container {
  position: relative;
  max-width: 600px;
  margin: 0 auto;
  z-index: 2;
}

.search-input {
  width: 100%;
  padding: 1rem 2rem 1rem 1.5rem;
  border: 2px solid rgba(255, 255, 255, 0.2);
  border-radius: 50px;
  font-size: 1rem;
  background-color: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(8px);
  color: white;
  transition: var(--transition);
}

.search-input::placeholder {
  color: rgba(255, 255, 255, 0.8);
}

.search-btn {
  position: absolute;
  right: 6px;
  top: 50%;
  transform: translateY(-50%);
  background: var(--primary-color);
  border: none;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  cursor: pointer;
  transition: var(--transition);
}

.topics-section {
  padding: 4rem 0;
  background-color: white;
}

.section-title {
  text-align: center;
  color: var(--primary-color);
  font-weight: 700;
  font-size: 2rem;
  margin-bottom: 3rem;
  position: relative;
  display: inline-block;
  left: 50%;
  transform: translateX(-50%);
}

.section-title::after {
  content: '';
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 60px;
  height: 3px;
  background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
}

.topic-card {
  background: white;
  border-radius: 15px;
  padding: 2rem;
  text-align: center;
  box-shadow: var(--shadow-md);
  transition: var(--transition);
  border: 1px solid rgba(0, 0, 0, 0.05);
  cursor: pointer;
}

.topic-card:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-lg);
}

.topic-icon {
  width: 70px;
  height: 70px;
  margin: 0 auto 1.5rem;
  background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 2rem;
}

.featured-articles {
  padding: 4rem 0;
  background: white;
}

.articles-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 0 2rem;
}

.article-item {
  background: white;
  border-radius: 15px;
  padding: 1.8rem 2.5rem;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  transition: var(--transition);
  border: 1px solid rgba(0, 0, 0, 0.05);
  box-shadow: var(--shadow-sm);
  text-decoration: none;
  cursor: pointer;
}

.article-item:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow-lg);
  border-color: var(--accent-color);
}

.article-title {
  color: var(--primary-color);
  font-weight: 600;
  font-size: 1.1rem;
  margin: 0;
  flex: 1;
}

.article-category {
  font-size: 0.85rem;
  color: #666;
  margin-top: 0.3rem;
}

.article-arrow {
  color: var(--accent-color);
  font-size: 1.5rem;
  transition: var(--transition);
  margin-left: 1.5rem;
}

.article-item:hover .article-arrow {
  transform: translateX(8px);
}

.features-section {
  background-color: white;
  padding: 3rem 0;
  margin-bottom: 3rem;
}

.feature-card {
  background: rgba(255, 255, 255, 0.9);
  border-radius: 20px;
  padding: 2rem;
  transition: var(--transition);
  border: 1px solid rgba(66, 45, 28, 0.08);
  box-shadow: 0 4px 20px rgba(66, 45, 28, 0.05);
}

.feature-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 25px 50px rgba(66, 45, 28, 0.15);
}

.contact-section {
  padding: 4rem 0;
  background: linear-gradient(135deg, #f8f9fa 0%, #f0e8dd 100%);
  text-align: center;
}

.btn-contact {
  background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
  border: none;
  color: white;
  padding: 1.1rem 3rem;
  font-weight: 600;
  border-radius: 50px;
  font-size: 1.1rem;
  transition: var(--transition);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  box-shadow: 0 4px 15px rgba(66, 45, 28, 0.3);
}

.btn-contact:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(66, 45, 28, 0.4);
  color: white;
}

/* Modal Styles */
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
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-close {
  position: absolute;
  top: 1.5rem;
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
  transform: rotate(90deg);
}

.modal-article-title {
  color: var(--primary-color);
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 1rem;
}

.modal-article-category {
  display: inline-block;
  background: var(--accent-color);
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-size: 0.9rem;
  margin-bottom: 1.5rem;
}

.modal-article-content {
  line-height: 1.8;
  color: #333;
  font-size: 1.05rem;
}

@media (max-width: 768px) {
  .hero-help {
    padding: 80px 1rem 60px 1rem;
    min-height: 350px;
  }
  
  .hero-help h1 {
    font-size: 2rem;
  }
  
  .modal-content-article {
    padding: 2rem;
    width: 95%;
  }
  
  .modal-article-title {
    font-size: 1.5rem;
  }
}
</style>

<!-- Hero Section -->
<div class="hero-help">
  <div class="container">
    <div class="hero-content">
      <h1>Bagaimana Kami Bisa Membantu?</h1>
      <p>Temukan jawaban untuk pertanyaan Anda</p>
    </div>
    
    <div class="search-container">
      <input type="text" class="search-input" placeholder="Cari artikel bantuan..." id="helpSearch">
      <button class="search-btn" type="button" id="searchBtn">
        <i class="bi bi-search"></i>
      </button>
    </div>
  </div>
</div>

<!-- Browse Topics Section -->
<div class="topics-section">
  <div class="container">
    <h2 class="section-title">Jelajahi Semua Topik</h2>
    
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="topic-card" data-category="getting-started">
          <div class="topic-icon">
            <i class="bi bi-play-circle"></i>
          </div>
          <h4 class="topic-title">Memulai</h4>
          <p class="topic-description">Dapatkan akun Anda dan mulai berbelanja hanya dalam beberapa langkah mudah</p>
        </div>
      </div>
      
      <div class="col-md-4 mb-4">
        <div class="topic-card" data-category="account-billing">
          <div class="topic-icon">
            <i class="bi bi-credit-card"></i>
          </div>
          <h4 class="topic-title">Akun dan Pembayaran</h4>
          <p class="topic-description">Kelola akun Anda, buat pesanan baru, data pengguna dan pembayaran</p>
        </div>
      </div>
      
      <div class="col-md-4 mb-4">
        <div class="topic-card" data-category="troubleshooting">
          <div class="topic-icon">
            <i class="bi bi-gear"></i>
          </div>
          <h4 class="topic-title">Pemecahan Masalah</h4>
          <p class="topic-description">Jawaban untuk masalah konfigurasi yang paling umum dan isu-isu lainnya</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Featured Articles Section -->
@if($featuredArticles->count() > 0)
<div class="featured-articles">
  <div class="container">
    <h2 class="section-title">Artikel Pilihan</h2>
    
    <div class="articles-container" id="articlesContainer">
      @foreach($featuredArticles as $article)
      <div class="article-item" data-article-id="{{ $article->id }}">
        <div>
          <h5 class="article-title">{{ $article->title }}</h5>
          @if($article->category)
          <p class="article-category mb-0">
            <i class="bi bi-tag-fill me-1"></i>{{ $article->category_name }}
          </p>
          @endif
        </div>
        <i class="bi bi-arrow-right article-arrow"></i>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endif

<!-- FAQ Section -->
<div class="features-section">
  <div class="container">
    <div class="text-center mb-5">
      <h2 style="color: #422D1C; font-weight: 700;">Pertanyaan Umum</h2>
      <p style="color: #666; font-size: 1.1rem;">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
    </div>

    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="feature-card" style="text-align: left; padding: 2rem;">
          <h5 style="color: #422D1C; font-weight: 600; margin-bottom: 0;">
            <i class="bi bi-question-circle-fill me-2" style="color: #8B4513;"></i>
            Bagaimana cara perawatan batik?
          </h5>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="feature-card" style="text-align: left; padding: 2rem;">
          <h5 style="color: #422D1C; font-weight: 600; margin-bottom: 0;">
            <i class="bi bi-truck me-2" style="color: #8B4513;"></i>
            Berapa lama waktu pengiriman?
          </h5>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="feature-card" style="text-align: left; padding: 2rem;">
          <h5 style="color: #422D1C; font-weight: 600; margin-bottom: 0;">
            <i class="bi bi-arrow-repeat me-2" style="color: #8B4513;"></i>
            Apakah bisa return/tukar?
          </h5>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="feature-card" style="text-align: left; padding: 2rem;">
          <h5 style="color: #422D1C; font-weight: 600; margin-bottom: 0;">
            <i class="bi bi-shield-check me-2" style="color: #8B4513;"></i>
            Apakah produk asli?
          </h5>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Contact Section -->
<div class="contact-section">
  <div class="container">
    <h2 class="contact-title" style="color: #422D1C; font-weight: 700; font-size: 2rem; margin-bottom: 1.5rem;">
      Tidak Menemukan Jawaban Untuk Pertanyaan Anda?
    </h2>
    <p class="contact-description" style="color: #666; font-size: 1.1rem; margin-bottom: 2rem;">
      Hubungi kami untuk detail layanan tambahan dan informasi harga untuk kebutuhan khusus
    </p>
    <a href="{{ route('contact') }}" class="btn-contact">
      HUBUNGI KAMI <i class="bi bi-arrow-right ms-2"></i>
    </a>
  </div>
</div>

<!-- Article Modal -->
<div class="article-modal" id="articleModal">
  <div class="modal-content-article">
    <button class="modal-close" id="modalClose">&times;</button>
    <div id="modalBody">
      <!-- Content will be loaded here -->
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const articles = @json($allArticles);
  const modal = document.getElementById('articleModal');
  const modalBody = document.getElementById('modalBody');
  const modalClose = document.getElementById('modalClose');
  
  // Article click handler
  document.querySelectorAll('.article-item').forEach(item => {
    item.addEventListener('click', function() {
      const articleId = this.getAttribute('data-article-id');
      const article = articles.find(a => a.id == articleId);
      
      if (article) {
        let categoryBadge = '';
        if (article.category_name) {
          categoryBadge = `<span class="modal-article-category">${article.category_name}</span>`;
        }
        
        modalBody.innerHTML = `
          <h2 class="modal-article-title">${article.title}</h2>
          ${categoryBadge}
          <div class="modal-article-content">${article.content}</div>
        `;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
      }
    });
  });
  
  // Close modal
  modalClose.addEventListener('click', function() {
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';
  });
  
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      modal.classList.remove('active');
      document.body.style.overflow = 'auto';
    }
  });
  
  // Topic card filter
  document.querySelectorAll('.topic-card').forEach(card => {
    card.addEventListener('click', function() {
      const category = this.getAttribute('data-category');
      filterArticlesByCategory(category);
    });
  });
  
  function filterArticlesByCategory(category) {
    const filteredArticles = articles.filter(a => a.category === category);
    const container = document.getElementById('articlesContainer');
    
    if (filteredArticles.length > 0) {
      container.innerHTML = '';
      filteredArticles.forEach(article => {
        const articleHtml = `
          <div class="article-item" data-article-id="${article.id}">
            <div>
              <h5 class="article-title">${article.title}</h5>
              ${article.category_name ? `<p class="article-category mb-0"><i class="bi bi-tag-fill me-1"></i>${article.category_name}</p>` : ''}
            </div>
            <i class="bi bi-arrow-right article-arrow"></i>
          </div>
        `;
        container.innerHTML += articleHtml;
      });
      
      // Re-attach click handlers
      container.querySelectorAll('.article-item').forEach(item => {
        item.addEventListener('click', function() {
          const articleId = this.getAttribute('data-article-id');
          const article = articles.find(a => a.id == articleId);
          
          if (article) {
            let categoryBadge = '';
            if (article.category_name) {
              categoryBadge = `<span class="modal-article-category">${article.category_name}</span>`;
            }
            
            modalBody.innerHTML = `
              <h2 class="modal-article-title">${article.title}</h2>
              ${categoryBadge}
              <div class="modal-article-content">${article.content}</div>
            `;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
          }
        });
      });
      
      // Scroll to articles
      container.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }
  
  // Search functionality
  const searchInput = document.getElementById('helpSearch');
  const searchBtn = document.getElementById('searchBtn');
  
  function performSearch() {
    const query = searchInput.value.trim().toLowerCase();
    if (query) {
      const results = articles.filter(a => 
        a.title.toLowerCase().includes(query) || 
        a.content.toLowerCase().includes(query)
      );
      
      const container = document.getElementById('articlesContainer');
      if (results.length > 0) {
        container.innerHTML = '';
        results.forEach(article => {
          const articleHtml = `
            <div class="article-item" data-article-id="${article.id}">
              <div>
                <h5 class="article-title">${article.title}</h5>
                ${article.category_name ? `<p class="article-category mb-0"><i class="bi bi-tag-fill me-1"></i>${article.category_name}</p>` : ''}
              </div>
              <i class="bi bi-arrow-right article-arrow"></i>
            </div>
          `;
          container.innerHTML += articleHtml;
        });
        
        // Re-attach click handlers
        container.querySelectorAll('.article-item').forEach(item => {
          item.addEventListener('click', function() {
            const articleId = this.getAttribute('data-article-id');
            const article = articles.find(a => a.id == articleId);
            
            if (article) {
              let categoryBadge = '';
              if (article.category_name) {
                categoryBadge = `<span class="modal-article-category">${article.category_name}</span>`;
              }
              
              modalBody.innerHTML = `
                <h2 class="modal-article-title">${article.title}</h2>
                ${categoryBadge}
                <div class="modal-article-content">${article.content}</div>
              `;
              modal.classList.add('active');
              document.body.style.overflow = 'hidden';
            }
          });
        });
        
        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
      } else {
        container.innerHTML = '<p class="text-center text-muted">Tidak ada artikel yang ditemukan</p>';
      }
    }
  }
  
  searchInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      performSearch();
    }
  });
  
  searchBtn.addEventListener('click', performSearch);
});
</script>

@endsection