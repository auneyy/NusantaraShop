@extends('layout.app')

@section('content')
<style>
  /* Help Page Styles */
  .hero-help {
    background: linear-gradient(135deg, #8B4513 0%, #422D1C 100%);
    padding: 100px 0 80px 0;
    color: white;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .hero-help::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="white" opacity="0.1"/><circle cx="80" cy="40" r="1" fill="white" opacity="0.05"/><circle cx="40" cy="80" r="1" fill="white" opacity="0.1"/><circle cx="60" cy="60" r="1" fill="white" opacity="0.03"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
  }

  .hero-help h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 2;
  }

  .hero-help p {
    font-size: 1.3rem;
    font-weight: 400;
    margin-bottom: 3rem;
    opacity: 0.9;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    position: relative;
    z-index: 2;
  }

  .search-container {
    position: relative;
    max-width: 600px;
    margin: 0 auto;
    z-index: 2;
  }

  .search-input {
    width: 100%;
    padding: 20px 60px 20px 25px;
    border: none;
    border-radius: 50px;
    font-size: 1.1rem;
    background-color: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    color: #422D1C;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
  }

  .search-input::placeholder {
    color: #999;
  }

  .search-input:focus {
    outline: none;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    background-color: white;
  }

  .search-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background-color: #422D1C;
    border: none;
    border-radius: 50px;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: all 0.3s ease;
  }

  .search-btn:hover {
    background-color: #8B4513;
    transform: translateY(-50%) scale(1.1);
  }

  .topics-section {
    padding: 100px 0;
    background-color:rgb(235, 235, 235);
  }

  .section-title {
    text-align: center;
    color: #422D1C;
    font-weight: 700;
    font-size: 2.5rem;
    margin-bottom: 80px;
  }

  .topic-card {
    background: white;
    border-radius: 20px;
    padding: 50px 30px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
    border: 2px solid transparent;
    cursor: pointer;
  }

  .topic-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    border-color: #422D1C;
  }

  .topic-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 25px auto;
    background: linear-gradient(135deg, #422D1C, #8B4513);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
  }

  .topic-title {
    color: #422D1C;
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 20px;
  }

  .topic-description {
    color: #666;
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 0;
  }

  .featured-articles {
    padding: 100px 0;
    background-color:rgb(235, 235, 235);
  }

  .articles-container {
    max-width: 800px;
    margin: 0 auto;
  }

  .article-item {
    background:rgb(255, 255, 255);
    border-radius: 15px;
    padding: 25px 30px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    cursor: pointer;
    text-decoration: none;
  }

  .article-item:hover {
    background: white;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border-color: #422D1C;
    transform: translateX(5px);
    text-decoration: none;
  }

  .article-title {
    color: #422D1C;
    font-weight: 600;
    font-size: 1.2rem;
    margin: 0;
    text-decoration: none;
  }

  .article-item:hover .article-title {
    color: #422D1C;
  }

  .article-arrow {
    color: #8B4513;
    font-size: 1.5rem;
    transition: transform 0.3s ease;
  }

  .article-item:hover .article-arrow {
    transform: translateX(5px);
  }

  .contact-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, rgb(239, 229, 209) 100%);
    text-align: center;
  }

  .contact-title {
    color: #422D1C;
    font-weight: 700;
    font-size: 2.2rem;
    margin-bottom: 20px;
  }

  .contact-description {
    color: #666;
    font-size: 1.2rem;
    margin-bottom: 40px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
  }

  .btn-contact {
    background-color: #422D1C;
    border-color: #422D1C;
    color: white;
    padding: 15px 40px;
    font-weight: 600;
    border-radius: 50px;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
  }

  .btn-contact:hover {
    background-color: #8B4513;
    border-color: #8B4513;
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .hero-help h1 {
      font-size: 2.5rem;
    }

    .hero-help p {
      font-size: 1.1rem;
      padding: 0 20px;
    }

    .hero-help {
      padding: 60px 0 50px 0;
    }

    .section-title {
      font-size: 2rem;
      margin-bottom: 50px;
    }

    .topic-card {
      padding: 30px 20px;
      margin-bottom: 30px;
    }

    .topic-icon {
      width: 60px;
      height: 60px;
      font-size: 2rem;
    }

    .topics-section,
    .featured-articles {
      padding: 60px 0;
    }

    .article-item {
      flex-direction: column;
      text-align: center;
      gap: 15px;
      padding: 20px;
    }

    .contact-title {
      font-size: 1.8rem;
    }

    .contact-description {
      font-size: 1.1rem;
      padding: 0 20px;
    }

    .search-container {
      margin: 0 20px;
    }
  }

  @media (max-width: 576px) {
    .hero-help h1 {
      font-size: 2rem;
    }

    .search-input {
      padding: 15px 50px 15px 20px;
    }

    .search-btn {
      width: 40px;
      height: 40px;
    }
  }
</style>

<!-- Hero Section -->
<div class="hero-help">
  <div class="container">
    <h1>Bagaimana Kami Bisa Membantu?</h1>
    <p>Temukan solusi dan jawaban dari tim dukungan kami dengan cepat atau hubungi kami langsung</p>
    
    <div class="search-container">
      <input type="text" class="search-input" placeholder="Cari jawaban atau topik bantuan..." id="helpSearch">
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
        <div class="topic-card" data-topic="getting-started">
          <div class="topic-icon">
            <i class="bi bi-play-circle"></i>
          </div>
          <h4 class="topic-title">Memulai</h4>
          <p class="topic-description">Dapatkan akun Anda dan mulai berbelanja hanya dalam beberapa langkah mudah</p>
        </div>
      </div>
      
      <div class="col-md-4 mb-4">
        <div class="topic-card" data-topic="account-billing">
          <div class="topic-icon">
            <i class="bi bi-credit-card"></i>
          </div>
          <h4 class="topic-title">Akun dan Pembayaran</h4>
          <p class="topic-description">Kelola akun Anda, buat pesanan baru, data pengguna dan pembayaran</p>
        </div>
      </div>
      
      <div class="col-md-4 mb-4">
        <div class="topic-card" data-topic="troubleshooting">
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
<div class="featured-articles">
  <div class="container">
    <h2 class="section-title">Artikel Unggulan</h2>
    
    <div class="articles-container">
      <a href="#" class="article-item" data-article="register">
        <h5 class="article-title">Cara mendaftar akun NusantaraShop</h5>
        <div class="article-arrow">
          <i class="bi bi-arrow-right"></i>
        </div>
      </a>
      
      <a href="#" class="article-item" data-article="payment">
        <h5 class="article-title">Metode pembayaran yang tersedia</h5>
        <div class="article-arrow">
          <i class="bi bi-arrow-right"></i>
        </div>
      </a>
      
      <a href="#" class="article-item" data-article="tracking">
        <h5 class="article-title">Cara melacak pesanan Anda</h5>
        <div class="article-arrow">
          <i class="bi bi-arrow-right"></i>
        </div>
      </a>
      
      <a href="#" class="article-item" data-article="return">
        <h5 class="article-title">Kebijakan pengembalian dan penukaran</h5>
        <div class="article-arrow">
          <i class="bi bi-arrow-right"></i>
        </div>
      </a>
      
      <a href="#" class="article-item" data-article="sizing">
        <h5 class="article-title">Panduan ukuran baju batik</h5>
        <div class="article-arrow">
          <i class="bi bi-arrow-right"></i>
        </div>
      </a>
    </div>
  </div>
</div>

<!-- Contact Section -->
<div class="contact-section">
  <div class="container">
    <h2 class="contact-title">Tidak Menemukan Jawaban Untuk Pertanyaan Anda?</h2>
    <p class="contact-description">Hubungi kami untuk detail layanan tambahan dan informasi harga untuk kebutuhan khusus</p>
    <a href="{{ route('contact') }}" class="btn-contact">HUBUNGI KAMI</a>
  </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Search functionality
  const searchInput = document.getElementById('helpSearch');
  const searchBtn = document.getElementById('searchBtn');

  function performSearch() {
    const query = searchInput.value.trim();
    if (query) {
      // Show loading state
      searchBtn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
      
      // Simulate search (replace with actual search functionality)
      setTimeout(() => {
        searchBtn.innerHTML = '<i class="bi bi-search"></i>';
        
        // You can implement actual search here
        // For now, we'll show an alert
        showSearchMessage(`Mencari: "${query}"`);
        
        // Clear search input
        searchInput.value = '';
      }, 1000);
    }
  }

  // Search event listeners
  searchInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      performSearch();
    }
  });

  searchBtn.addEventListener('click', performSearch);

  // Topic card click handlers
  document.querySelectorAll('.topic-card').forEach(card => {
    card.addEventListener('click', function() {
      const topic = this.getAttribute('data-topic');
      const title = this.querySelector('.topic-title').textContent;
      
      showSearchMessage(`Navigasi ke topik: ${title}`);
      
      // You can implement navigation to specific topic page here
      // window.location.href = `/help/topic/${topic}`;
    });
  });

  // Article click handlers
  document.querySelectorAll('.article-item').forEach(item => {
    item.addEventListener('click', function(e) {
      e.preventDefault();
      const article = this.getAttribute('data-article');
      const title = this.querySelector('.article-title').textContent;
      
      showSearchMessage(`Membuka artikel: ${title}`);
      
      // You can implement navigation to specific article page here
      // window.location.href = `/help/article/${article}`;
    });
  });

  // Helper function to show messages
  function showSearchMessage(message) {
    const alertDiv = document.createElement('div');
    alertDiv.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      background: #422D1C;
      color: white;
      padding: 15px 20px;
      border-radius: 10px;
      z-index: 9999;
      font-weight: 600;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    `;
    alertDiv.textContent = message;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
      if (alertDiv.parentNode) {
        document.body.removeChild(alertDiv);
      }
    }, 3000);
  }

  // Add smooth scrolling for internal links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth'
        });
      }
    });
  });
});
</script>

@endsection