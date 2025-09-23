@extends('layout.app')

@section('content')
<style>
  * {
    box-sizing: border-box;
  }

/* Hero Section */
.contact-hero {
  position: relative;
  display: flex;
  flex-direction: column; /* supaya teks tersusun vertikal */
  align-items: center;
  justify-content: center;
  min-height: 450px;
  text-align: center;
  overflow: hidden;
}

/* Gambar hero (tidak nge-zoom) */
.hero-bg {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover; /* selalu penuh */
  object-position: center top; /* fokus ke bagian atas/tengah gambar */
  z-index: 0;
}

/* Overlay di atas gambar */
.contact-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* hitam transparan */
  z-index: 1;
}

/* Teks di atas overlay */
.contact-hero h1,
.contact-hero p {
  position: relative;
  z-index: 2;
}

.contact-hero h1 {
  color: #ffffff;
  font-weight: 700;
  font-size: 2.5rem;
  margin-bottom: 1rem;
  letter-spacing: -0.02em;
}

.contact-hero p {
  color: rgba(248, 249, 250, 0.95);
  font-size: 1.1rem;
  font-weight: 600;
  max-width: 600px;
  margin: 0 auto;
  line-height: 1.7;
}

  /* Contact Section - Reduced */
  .contact-section {
    padding: 50px 0;
    min-height: auto;
    position: relative;
  }

  /* Tambahkan subtle pattern */
  .contact-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
  }

  .contact-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    box-shadow: 
      0 20px 40px rgba(66, 45, 28, 0.1),
      0 0 0 1px rgba(255, 255, 255, 0.2);
    overflow: hidden;
    max-width: 900px;
    margin: 0 auto;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
  }

  .contact-container:hover {
    transform: translateY(-5px);
    box-shadow: 
      0 25px 50px rgba(66, 45, 28, 0.15),
      0 0 0 1px rgba(255, 255, 255, 0.3);
  }

  /* Form Section Styling - Reduced */
  .contact-form-section {
    padding: 40px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
    position: relative;
  }

  /* Info Section - Enhanced Gradient */
  .contact-info-section {
    background: linear-gradient(135deg, #422D1C 0%, #5D3522 25%, #8B4513 75%, #A0522D 100%);
    padding: 40px;
    color: white;
    position: relative;
    overflow: hidden;
  }

  /* Tambahkan pattern batik subtle */
  .contact-info-section::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: 
      radial-gradient(circle at 30% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 30%),
      radial-gradient(circle at 70% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 40%),
      repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255,255,255,0.02) 20px, rgba(255,255,255,0.02) 40px);
    animation: slowFloat 25s ease-in-out infinite;
    pointer-events: none;
  }

  @keyframes slowFloat {
    0%, 100% { transform: translateX(0) translateY(0) rotate(0deg); }
    25% { transform: translateX(-10px) translateY(-5px) rotate(1deg); }
    50% { transform: translateX(5px) translateY(-10px) rotate(-1deg); }
    75% { transform: translateX(-5px) translateY(5px) rotate(1deg); }
  }

  .contact-info-section > * {
    position: relative;
    z-index: 2;
  }

  /* Typography Improvements */
  .section-title {
    color: #422D1C;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    display: inline-block;
    letter-spacing: -0.02em;
  }

  .section-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
    border-radius: 2px;
  }

  .contact-info-section .section-title {
    color: white;
  }

  .contact-info-section .section-title::after {
    background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
  }

  /* Form Styling - Reduced Size */
  .form-group {
    margin-bottom: 1.5rem;
    position: relative;
  }

  .form-label {
    color: #422D1C;
    font-weight: 600;
    margin-bottom: 0.6rem;
    display: block;
    font-size: 0.9rem;
    letter-spacing: 0.3px;
    transition: all 0.3s ease;
  }

  .form-control {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid rgba(66, 45, 28, 0.12);
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 400;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: rgba(248, 249, 250, 0.8);
    backdrop-filter: blur(5px);
    color: #333;
    position: relative;
  }

  .form-control::placeholder {
    color: rgba(66, 45, 28, 0.5);
    font-weight: 300;
  }

  .form-control:focus {
    outline: none;
    border-color: #8B4513;
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 
      0 0 0 3px rgba(139, 69, 19, 0.1),
      0 6px 20px rgba(66, 45, 28, 0.15);
    transform: translateY(-1px);
  }

  .form-control:hover:not(:focus) {
    border-color: rgba(139, 69, 19, 0.25);
    background: rgba(255, 255, 255, 0.9);
  }

  .form-control.textarea {
    min-height: 120px;
    resize: vertical;
    line-height: 1.6;
  }

  /* Enhanced Button Styling */
  .btn-send {
    background: linear-gradient(135deg, #422D1C 0%, #5D3522 25%, #8B4513 75%, #A0522D 100%);
    color: white;
    border: none;
    padding: 14px 35px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    letter-spacing: 0.5px;
    cursor: pointer;
    width: 100%;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 15px rgba(66, 45, 28, 0.3);
  }

  .btn-send::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.6s;
  }

  .btn-send:hover::before {
    left: 100%;
  }

  .btn-send:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(66, 45, 28, 0.4);
  }

  .btn-send:active {
    transform: translateY(-1px);
  }

  /* Contact Info Items - Reduced Size */
  .contact-info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1.8rem;
    padding: 15px 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 10px;
  }

  .contact-info-item:hover {
    transform: translateX(8px);
    background: rgba(255, 255, 255, 0.05);
    padding-left: 12px;
  }

  .contact-icon {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    font-size: 1.2rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .contact-info-item:hover .contact-icon {
    background: rgba(255, 255, 255, 0.25);
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
  }

  .contact-details h5 {
    margin-bottom: 6px;
    font-weight: 600;
    font-size: 1.1rem;
  }

  .contact-details p {
    margin: 0;
    opacity: 0.9;
    line-height: 1.5;
    font-weight: 300;
    font-size: 0.95rem;
  }

  /* Social Links - Reduced Size */
  .social-links {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    justify-content: flex-start;
  }

  .social-link {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    color: white;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 1.2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .social-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
    border-radius: 50%;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .social-link:hover::before {
    opacity: 1;
  }

  .social-link:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  }

  /* Map Section - Reduced Size */
  .map-section {
    padding: 60px 0;
    position: relative;
  }

  .map-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
      radial-gradient(circle at 20% 30%, rgba(139, 69, 19, 0.02) 0%, transparent 50%),
      radial-gradient(circle at 80% 70%, rgba(66, 45, 28, 0.03) 0%, transparent 50%);
    pointer-events: none;
  }

  .map-section-title {
    text-align: center;
    margin-bottom: 2.5rem;
    position: relative;
    z-index: 2;
  }

  .map-section-title h2 {
    color: #422D1C;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0.8rem;
    position: relative;
    display: inline-block;
  }

  .map-section-title h2::after {
    content: '';
    position: absolute;
    bottom: -6px;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
    border-radius: 2px;
  }

  .map-section-title p {
    color: #666;
    font-size: 1rem;
    font-weight: 300;
    max-width: 500px;
    margin: 0 auto;
    line-height: 1.6;
  }

  .map-wrapper {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .map-container {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 
      0 20px 40px rgba(66, 45, 28, 0.1),
      0 0 0 1px rgba(255, 255, 255, 0.3);
    background: white;
    position: relative;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    aspect-ratio: 16/9;
    min-height: 300px;
  }

  .map-container:hover {
    transform: translateY(-5px);
    box-shadow: 
      0 25px 50px rgba(66, 45, 28, 0.15),
      0 0 0 1px rgba(255, 255, 255, 0.4);
  }

  .map-container iframe {
    width: 100%;
    height: 100%;
    border: 0;
    position: absolute;
    top: 0;
    left: 0;
    border-radius: 20px;
  }

  .map-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    color: #666;
    font-size: 1rem;
    z-index: 1;
    border-radius: 20px;
  }

  .map-placeholder i {
    font-size: 3rem;
    color: #422D1C;
    margin-bottom: 1rem;
    opacity: 0.7;
  }

  .map-placeholder p {
    margin: 0.4rem 0;
    text-align: center;
    line-height: 1.5;
  }

  .map-placeholder .map-address {
    background: rgba(66, 45, 28, 0.05);
    padding: 0.8rem 1.5rem;
    border-radius: 12px;
    margin-top: 0.8rem;
    border-left: 3px solid #8B4513;
  }

  /* Alert Enhancements */
  .alert {
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 1.5rem;
    border: none;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  }

  .alert-success {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(40, 167, 69, 0.08) 100%);
    color: #155724;
    border-left: 3px solid #28a745;
  }

  /* Invalid feedback styling */
  .is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
  }

  .invalid-feedback {
    display: none;
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.4rem;
    font-weight: 500;
  }
  

  /* Responsive Design */
  @media (max-width: 1200px) {
    .map-container {
      min-height: 280px;
    }
    
    .map-wrapper {
      padding: 0 25px;
    }
  }

  @media (max-width: 992px) {
    .map-container {
      min-height: 250px;
      border-radius: 16px;
    }
    
    .map-container iframe {
      border-radius: 16px;
    }
    
    .map-placeholder {
      border-radius: 16px;
    }
    
    .map-section-title h2 {
      font-size: 1.8rem;
    }
  }

  @media (max-width: 768px) {
    .contact-hero {
      padding: 60px 0 40px 0;
      height: 50vh;
      min-height: 400px;
      background-attachment: scroll;
    }

    .contact-hero h1 {
      font-size: 2rem;
    }

    .contact-hero p {
      font-size: 1rem;
    }

    .contact-section {
      padding: 40px 0;
    }

    .contact-container {
      margin: 0 20px;
      border-radius: 16px;
    }

    .contact-form-section,
    .contact-info-section {
      padding: 30px;
    }

    .section-title {
      font-size: 1.6rem;
    }

    .contact-info-item {
      margin-bottom: 1.5rem;
    }

    .contact-icon {
      width: 45px;
      height: 45px;
      margin-right: 16px;
      font-size: 1.1rem;
    }

    .social-links {
      justify-content: center;
    }

    .map-section {
      padding: 50px 0;
    }

    .map-wrapper {
      padding: 0 20px;
    }

    .map-container {
      height: 220px;
      min-height: 220px;
      border-radius: 14px;
    }

    .map-container iframe {
      border-radius: 14px;
    }

    .map-placeholder {
      border-radius: 14px;
    }

    .map-placeholder i {
      font-size: 2.5rem;
      margin-bottom: 0.8rem;
    }

    .map-placeholder .map-address {
      padding: 0.6rem 1.2rem;
      margin-top: 0.6rem;
    }

    .map-section-title {
      margin-bottom: 2rem;
    }

    .map-section-title h2 {
      font-size: 1.6rem;
    }

    .map-section-title p {
      font-size: 0.95rem;
      padding: 0 20px;
    }
  }

  @media (max-width: 576px) {
    .contact-form-section,
    .contact-info-section {
      padding: 25px;
    }

    .section-title {
      font-size: 1.5rem;
    }

    .contact-hero h1 {
      font-size: 1.8rem;
    }

    .contact-hero p {
      font-size: 0.95rem;
    }

    .form-control {
      padding: 12px 14px;
    }

    .btn-send {
      padding: 12px 30px;
      font-size: 0.95rem;
    }

    .contact-info-item:hover {
      transform: none;
      padding-left: 0;
    }

    .map-container {
      height: 200px;
      min-height: 200px;
      border-radius: 12px;
    }

    .map-container iframe {
      border-radius: 12px;
    }

    .map-placeholder {
      border-radius: 12px;
      padding: 16px;
    }

    .map-section-title h2 {
      font-size: 1.5rem;
    }

    .map-wrapper {
      padding: 0 15px;
    }
  }

  /* Smooth scrolling */
  html {
    scroll-behavior: smooth;
  }

  /* Additional utility classes */
  .text-center {
    text-align: center;
  }

  .mb-5 {
    margin-bottom: 3rem;
  }

  .me-2 {
    margin-right: 0.5rem;
  }
</style>

<!-- Hero Section -->
<div class="contact-hero">
  <img src="/storage/product_images/batikpramisoloc.jpg" alt="Hero Image" class="hero-bg">
  <div class="hero-overlay">
    <h1>Hubungi Kami</h1>
    <p>Kami siap membantu Anda dengan pertanyaan apapun tentang produk batik tradisional Indonesia kami</p>
  </div>
</div>


<!-- Contact Section -->
<div class="contact-section">
  <div class="container">
    <div class="contact-container">
      <div class="row g-0">
        <!-- Contact Form -->
        <div class="col-lg-7">
          <div class="contact-form-section">
            <h2 class="section-title">Kirim Pesan</h2>

            <!-- Flash message sukses -->
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            
            <!-- Form Contact -->
            <form action="{{ route('contact.store') }}" method="POST">
              @csrf

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           name="name" placeholder="Masukkan nama lengkap" required>
                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                           name="phone" placeholder="Masukkan nomor telepon">
                    @error('phone')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <label class="form-label">Email *</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" placeholder="Masukkan alamat email" required>
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              
              <div class="form-group">
                <label class="form-label">Subjek</label>
                <select class="form-control @error('subject') is-invalid @enderror" name="subject">
                  <option value="">Pilih subjek pesan</option>
                  <option value="product">Pertanyaan Produk</option>
                  <option value="order">Status Pesanan</option>
                  <option value="complaint">Keluhan</option>
                  <option value="suggestion">Saran</option>
                  <option value="partnership">Kerjasama</option>
                  <option value="other">Lainnya</option>
                </select>
                @error('subject')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              
              <div class="form-group">
                <label class="form-label">Pesan *</label>
                <textarea class="form-control textarea @error('message') is-invalid @enderror" 
                          name="message" placeholder="Tulis pesan Anda di sini..." required></textarea>
                @error('message')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              
              <button type="submit" class="btn-send">
                <i class="bi bi-send me-2"></i>
                Kirim Pesan
              </button>
            </form>
          </div>
        </div>

        <!-- Contact Info -->
        <div class="col-lg-5">
          <div class="contact-info-section">
            <h2 class="section-title">Informasi Kontak</h2>
            
            <div class="contact-info-item">
              <div class="contact-icon">
                <i class="bi bi-geo-alt-fill"></i>
              </div>
              <div class="contact-details">
                <h5>Alamat Toko</h5>
                <p>Jl. Kalimasada Nomor 30, <br>Polehan, Kec. Blimbing, <br>Kota Malang, Jawa Timur 65121</p>
              </div>
            </div>
            
            <div class="contact-info-item">
              <div class="contact-icon">
                <i class="bi bi-envelope-fill"></i>
              </div>
              <div class="contact-details">
                <h5>Email</h5>
                <p>nusantarashop@gmail.com<br>
                nusantara@gmail.com</p>
              </div>
            </div>
            
            <div class="contact-info-item">
              <div class="contact-icon">
                <i class="bi bi-telephone-fill"></i>
              </div>
              <div class="contact-details">
                <h5>Telepon</h5>
                <p>+62 895 4036 50987<br>
                WhatsApp: +62 895 4036 50987</p>
              </div>
            </div>
            
            <div class="contact-info-item">
              <div class="contact-icon">
                <i class="bi bi-clock-fill"></i>
              </div>
              <div class="contact-details">
                <h5>Jam Operasional</h5>
                <p>Senin - Sabtu: 08:00 - 17:00<br>
                Minggu: 09:00 - 15:00</p>
              </div>
            </div>
            
            <div class="social-links">
              <a href="#" class="social-link" title="Facebook">
                <i class="bi bi-facebook"></i>
              </a>
              <a href="#" class="social-link" title="Instagram">
                <i class="bi bi-instagram"></i>
              </a>
              <a href="#" class="social-link" title="WhatsApp">
                <i class="bi bi-whatsapp"></i>
              </a>
              <a href="#" class="social-link" title="YouTube">
                <i class="bi bi-youtube"></i>
              </a>
              <a href="#" class="social-link" title="Email">
                <i class="bi bi-envelope"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Map Section -->
<div class="map-section">
  <div class="container">
    <div class="map-section-title">
      <h2>Lokasi Toko Kami</h2>
      <p>Kunjungi showroom kami untuk melihat langsung koleksi batik terbaik dengan kualitas premium</p>
    </div>
    
    <div class="map-wrapper">
      <div class="map-container">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1608.8318003068664!2d112.64875388795775!3d-7.98039598338346!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd629f5508489c1%3A0x421bf67059618740!2sPenjahit%20Rumahan%20Mbak%20Diah!5e0!3m2!1sen!2sid!4v1758158566351!5m2!1sen!2sid" 
          width="100%" 
          height="100%" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade"
          title="Lokasi Toko Nusantara Batik">
        </iframe>
        
        <!-- Fallback placeholder jika iframe tidak load -->
        <div class="map-placeholder" style="display: none;">
          <i class="bi bi-map"></i>
          <p><strong>Lokasi Toko Nusantara Batik</strong></p>
          <div class="map-address">
            <p><strong>Jl. Raya Malang No. 123</strong><br>
            Kecamatan Klojen, Malang<br>
            Jawa Timur 65111</p>
            <p style="margin-top: 0.5rem; font-size: 0.9rem; opacity: 0.8;">
              <i class="bi bi-telephone me-1"></i> +62 341 123 4567<br>
              <i class="bi bi-clock me-1"></i> Buka: Senin-Sabtu 08:00-17:00
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle iframe loading error
    const iframe = document.querySelector('.map-container iframe');
    const placeholder = document.querySelector('.map-placeholder');
    
    if (iframe && placeholder) {
        iframe.addEventListener('error', function() {
            iframe.style.display = 'none';
            placeholder.style.display = 'flex';
        });
        
        // Check if iframe loaded successfully after a timeout
        setTimeout(function() {
            try {
                // Try to access iframe content (will throw error if not loaded)
                if (!iframe.contentDocument && !iframe.contentWindow) {
                    iframe.style.display = 'none';
                    placeholder.style.display = 'flex';
                }
            } catch (e) {
                // iframe loaded successfully from external source
                placeholder.style.display = 'none';
            }
        }, 3000);
    }
    
    // Handle contact form submission
    const contactForm = document.querySelector('form[action*="contact.store"]');
    if (contactForm) {
        // Add smooth form interactions
        const formInputs = contactForm.querySelectorAll('.form-control');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
        
        // Form validation enhancement
        contactForm.addEventListener('submit', function(e) {
            const requiredFields = contactForm.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            // Email validation
            const emailField = contactForm.querySelector('input[type="email"]');
            if (emailField && emailField.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailField.value)) {
                    emailField.classList.add('is-invalid');
                    isValid = false;
                }
            }
            
            if (!isValid) {
                e.preventDefault();
                showMessage('Mohon lengkapi semua field yang wajib diisi dengan benar', 'error');
            }
        });
    }
    
    // Map interaction enhancements
    const mapContainer = document.querySelector('.map-container');
    if (mapContainer) {
        mapContainer.addEventListener('click', function() {
            const iframe = this.querySelector('iframe');
            if (iframe) {
                iframe.style.pointerEvents = 'auto';
            }
        });
        
        mapContainer.addEventListener('mouseleave', function() {
            const iframe = this.querySelector('iframe');
            if (iframe) {
                iframe.style.pointerEvents = 'none';
            }
        });
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add loading animation for map
    const mapIframe = document.querySelector('.map-container iframe');
    if (mapIframe) {
        mapIframe.addEventListener('load', function() {
            this.style.opacity = '1';
            this.style.transition = 'opacity 0.3s ease';
        });
        
        mapIframe.style.opacity = '0.7';
    }
});

// Enhanced message function
function showMessage(text, type = 'info') {
    const message = document.createElement('div');
    const colors = {
        success: '#28a745',
        error: '#dc3545', 
        info: '#17a2b8',
        warning: '#ffc107'
    };
    
    const icons = {
        success: '✓',
        error: '✕',
        info: 'ℹ',
        warning: '⚠'
    };
    
    message.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${colors[type] || colors.info};
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        z-index: 9999;
        font-weight: 500;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        animation: slideInRight 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 8px;
        max-width: 400px;
        word-wrap: break-word;
    `;
    
    message.innerHTML = `
        <span style="font-size: 16px;">${icons[type] || icons.info}</span>
        <span>${text}</span>
        <button onclick="this.parentElement.remove()" style="
            background: none; 
            border: none; 
            color: white; 
            font-size: 18px; 
            cursor: pointer; 
            padding: 0; 
            margin-left: 8px;
            opacity: 0.7;
            transition: opacity 0.2s;
        " onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">×</button>
    `;
    
    document.body.appendChild(message);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (message.parentNode) {
            message.style.animation = 'slideOutRight 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            setTimeout(() => {
                if (message.parentNode) {
                    message.remove();
                }
            }, 300);
        }
    }, 5000);
}

// Add animation keyframes
if (!document.querySelector('#message-animations')) {
    const style = document.createElement('style');
    style.id = 'message-animations';
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .map-container iframe {
            transition: opacity 0.3s ease;
        }
        
        .form-group.focused .form-label {
            color: #8B4513;
            transform: translateY(-2px);
        }
    `;
    document.head.appendChild(style);
}
</script>

@endsection