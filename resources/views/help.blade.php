@extends('layout.app')

@section('content')
<style>
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

  /* Base Styles */
  body {
    color: var(--dark-text);
    line-height: 1.7;
    background-color: #fff;
  }

  /* Hero Section */
  .hero-help {
    position: relative;
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), 
                url('/storage/product_images/banner-bantuan.png') center/cover no-repeat fixed;
    min-height: 620px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 2rem 1rem;
    overflow: hidden;
    color: var(--light-text);
    background-attachment: scroll;
  }

  .hero-content {
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
    animation: fadeInUp 0.8s ease-out;
  }

  .hero-help h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.2;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  }

  .hero-help p {
    font-size: 1.3rem;
    opacity: 0.9;
    margin-bottom: 2.5rem;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
  }

  /* Search Bar */
  .search-container {
    position: relative;
    max-width: 700px;
    margin: 0 auto;
    z-index: 2;
    transition: var(--transition);
  }

  .search-wrapper {
    position: relative;
    width: 100%;
  }

  .search-input {
    width: 100%;
    padding: 1.5rem 2.5rem 1.5rem 1.8rem;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    font-size: 1.1rem;
    background-color: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    color: white;
    box-shadow: var(--shadow-lg);
    transition: var(--transition);
  }

  .search-input::placeholder {
    color: rgba(255, 255, 255, 0.8);
  }

  .search-input:focus {
    outline: none;
    background-color: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.4);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
  }

  .search-btn {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    background: var(--primary-color);
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
  }

  .search-btn:hover {
    background: var(--secondary-color);
    transform: translateY(-50%) scale(1.05);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  }

  /* Topics Section */
  .topics-section {
    padding: 6rem 0;
    background-color: var(--light-bg);
    position: relative;
    overflow: hidden;
  }

  .section-title {
    text-align: center;
    color: var(--primary-color);
    font-weight: 800;
    font-size: 2.8rem;
    margin-bottom: 5rem;
    position: relative;
    display: inline-block;
    left: 50%;
    transform: translateX(-50%);
  }

  .section-title::after {
    content: '';
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    border-radius: 2px;
  }

  .topics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    padding: 0 2rem;
  }

  .topic-card {
    background: white;
    border-radius: 20px;
    padding: 3rem 2rem;
    text-align: center;
    box-shadow: var(--shadow-md);
    transition: var(--transition);
    height: 100%;
    position: relative;
    overflow: hidden;
    z-index: 1;
    border: 1px solid rgba(0, 0, 0, 0.05);
  }

  .topic-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    transition: var(--transition);
    z-index: -1;
  }

  .topic-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: var(--shadow-lg);
  }

  .topic-card:hover .topic-icon {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 15px 30px rgba(139, 69, 19, 0.3);
  }

  .topic-icon {
    width: 90px;
    height: 90px;
    margin: 0 auto 2rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    transition: var(--transition);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
  }

  .topic-title {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 1.5rem;
    position: relative;
    padding-bottom: 1rem;
  }

  .topic-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 2px;
    background: linear-gradient(90deg, var(--primary-color), transparent);
  }

  .topic-description {
    color: #666;
    font-size: 1rem;
    line-height: 1.7;
    margin-bottom: 0;
  }

  /* Featured Articles */
  .featured-articles {
    padding: 6rem 0;
    background: white;
    position: relative;
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
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  }

  .article-item:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    border-color: var(--accent-color);
  }

  .article-item:hover .article-title {
    color: var(--secondary-color);
  }

  .article-item:hover .article-arrow {
    transform: translateX(8px);
    color: var(--secondary-color);
  }

  .article-title {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 1.2rem;
    margin: 0;
    transition: var(--transition);
    flex: 1;
  }

  .article-arrow {
    color: var(--accent-color);
    font-size: 1.5rem;
    transition: var(--transition);
    margin-left: 1.5rem;
  }

  /* Contact Section */
  .contact-section {
    padding: 6rem 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #f0e8dd 100%);
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .contact-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 10px;
    background: rgba(98, 96, 96, 0.2);
  }

  .contact-content {
    max-width: 700px;
    margin: 0 auto;
    padding: 0 2rem;
  }

  .contact-title {
    color: var(--primary-color);
    font-weight: 800;
    font-size: 2rem;
    margin-bottom: 1.5rem;
    line-height: 1.3;
  }

  .contact-description {
    color: #666;
    font-size: 1.2rem;
    margin-bottom: 3rem;
    line-height: 1.7;
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
    justify-content: center;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    overflow: hidden;
    z-index: 1;
    box-shadow: 0 4px 15px rgba(66, 45, 28, 0.3);
  }

  .btn-contact::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, var(--secondary-color), var(--primary-color));
    z-index: -1;
    opacity: 0;
    transition: var(--transition);
  }

  .btn-contact:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(66, 45, 28, 0.4);
  }

  .btn-contact:hover::before {
    opacity: 1;
  }

  .btn-contact i {
    margin-left: 8px;
    transition: var(--transition);
  }

  .btn-contact:hover i {
    transform: translateX(5px);
  }

  /* Animations */
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Responsive Design */
  @media (max-width: 992px) {
    .hero-help h1 {
      font-size: 3rem;
    }

    .section-title {
      font-size: 2.5rem;
    }
  }

  @media (max-width: 768px) {
    .hero-help {
      padding: 6rem 1rem;
      background-attachment: scroll;
    }

    .hero-help h1 {
      font-size: 2.5rem;
    }

    .hero-help p {
      font-size: 1.15rem;
      padding: 0 1rem;
    }

    .section-title {
      font-size: 2.2rem;
      margin-bottom: 4rem;
    }

    .topics-grid {
      grid-template-columns: 1fr;
      max-width: 500px;
      margin: 0 auto;
    }

    .topic-card {
      padding: 2.5rem 1.5rem;
    }

    .article-item {
      padding: 1.5rem;
      flex-direction: column;
      text-align: center;
    }

    .article-title {
      margin-bottom: 1rem;
    }

    .article-arrow {
      margin-left: 0;
    }
  }

  @media (max-width: 576px) {
    .hero-help h1 {
      font-size: 2rem;
      line-height: 1.3;
    }

    .hero-help p {
      font-size: 1rem;
    }

    .section-title {
      font-size: 1.8rem;
    }

    .search-input {
      padding: 1.2rem 1.8rem 1.2rem 1.5rem;
      font-size: 1rem;
    }

    .search-btn {
      width: 45px;
      height: 45px;
    }

    .contact-title {
      font-size: 2rem;
    }

    .contact-description {
      font-size: 1.1rem;
    }

    .btn-contact {
      padding: 1rem 2.5rem;
      font-size: 1rem;
    }
  }

  /* Utility Classes */
  .text-gradient {
    background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
  }

  .features-section {
     background-color: white;
     margin-bottom: 80px;
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

<!-- FAQ Section -->
<div class="features-section"">
  <div class="container">
    <div class="text-center mb-5 mt-5">
      <h2 style="color: #422D1C; font-weight: 700;">Pertanyaan Umum</h2>
      <p style="color: #666; font-size: 1.1rem;">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
    </div>

    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="feature-card" style="text-align: left; padding: 2rem;">
          <h5 style="color: #422D1C; font-weight: 600; margin-bottom: 1rem;">
            <i class="bi bi-question-circle-fill me-2" style="color: #8B4513;"></i>
            Bagaimana cara perawatan batik?
          </h5>
          <p class="text-muted">Cuci dengan air dingin, hindari deterjen keras, dan jemur di tempat teduh untuk menjaga kualitas warna dan kain.</p>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="feature-card" style="text-align: left; padding: 2rem;">
          <h5 style="color: #422D1C; font-weight: 600; margin-bottom: 1rem;">
            <i class="bi bi-truck me-2" style="color: #8B4513;"></i>
            Berapa lama waktu pengiriman?
          </h5>
          <p class="text-muted">Pengiriman dalam kota 1-2 hari, luar kota 3-5 hari kerja. Gratis ongkir untuk pembelian di atas Rp 500.000.</p>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="feature-card" style="text-align: left; padding: 2rem;">
          <h5 style="color: #422D1C; font-weight: 600; margin-bottom: 1rem;">
            <i class="bi bi-arrow-repeat me-2" style="color: #8B4513;"></i>
            Apakah bisa return/tukar?
          </h5>
          <p class="text-muted">Ya, kami menerima return/tukar dalam 7 hari dengan kondisi produk masih dalam keadaan baik dan belum dicuci.</p>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="feature-card" style="text-align: left; padding: 2rem;">
          <h5 style="color: #422D1C; font-weight: 600; margin-bottom: 1rem;">
            <i class="bi bi-shield-check me-2" style="color: #8B4513;"></i>
            Apakah produk asli?
          </h5>
          <p class="text-muted">Semua produk batik kami adalah produk asli dari pengrajin terpercaya dengan sertifikat keaslian.</p>
        </div>
      </div>
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