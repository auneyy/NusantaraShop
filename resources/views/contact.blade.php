@extends('layout.app')

@section('content')
<style>
  * {
    box-sizing: border-box;
  }

  /* Hero Section - Enhanced */
  .contact-hero {
    background-image: url('/storage/product_images/kontak.png');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    padding: 180px 0 120px 0;
    height: 70vh;
    min-height: 600px;
    text-align: center;
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
  }

  .contact-hero h1 {
    color: #ffffff;
    font-weight: 700;
    font-size: 3.2rem;
    margin-bottom: 1.5rem;
    text-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    position: relative;
    z-index: 2;
    letter-spacing: -0.02em;
  }

  .contact-hero p {
    color:#422D1C;  
    font-size: 1.25rem;
    font-weight:400;
    max-width: 650px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
    line-height: 1.7;
  }

  /* Contact Section - Enhanced */
  .contact-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #f1f3f4 100%);
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
    background-image: 
      radial-gradient(circle at 25% 25%, rgba(139, 69, 19, 0.03) 0%, transparent 50%),
      radial-gradient(circle at 75% 75%, rgba(66, 45, 28, 0.02) 0%, transparent 50%);
    pointer-events: none;
  }

  .contact-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    box-shadow: 
      0 25px 50px rgba(66, 45, 28, 0.1),
      0 0 0 1px rgba(255, 255, 255, 0.2);
    border-radius: 24px;
    overflow: hidden;
    max-width: 1100px;
    margin: 0 auto;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
  }

  .contact-container:hover {
    transform: translateY(-8px);
    box-shadow: 
      0 35px 70px rgba(66, 45, 28, 0.15),
      0 0 0 1px rgba(255, 255, 255, 0.3);
  }

  /* Form Section Styling */
  .contact-form-section {
    padding: 60px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
    position: relative;
  }

  /* Info Section - Enhanced Gradient */
  .contact-info-section {
    background: linear-gradient(135deg, #422D1C 0%, #5D3522 25%, #8B4513 75%, #A0522D 100%);
    padding: 60px;
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
    font-size: 2.5rem;
    margin-bottom: 2.5rem;
    position: relative;
    display: inline-block;
    letter-spacing: -0.02em;
  }

  .section-title::after {
    content: '';
    position: absolute;
    bottom: -12px;
    left: 0;
    width: 60px;
    height: 4px;
    background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
    border-radius: 2px;
  }

  .contact-info-section .section-title {
    color: white;
  }

  .contact-info-section .section-title::after {
    background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
  }

  /* Form Styling - Enhanced */
  .form-group {
    margin-bottom: 2rem;
    position: relative;
  }

  .form-label {
    color: #422D1C;
    font-weight: 600;
    margin-bottom: 0.8rem;
    display: block;
    font-size: 0.95rem;
    letter-spacing: 0.3px;
    transition: all 0.3s ease;
  }

  .form-control {
    width: 100%;
    padding: 18px 20px;
    border: 2px solid rgba(66, 45, 28, 0.12);
    border-radius: 16px;
    font-size: 1rem;
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
      0 0 0 4px rgba(139, 69, 19, 0.1),
      0 8px 25px rgba(66, 45, 28, 0.15);
    transform: translateY(-2px);
  }

  .form-control:hover:not(:focus) {
    border-color: rgba(139, 69, 19, 0.25);
    background: rgba(255, 255, 255, 0.9);
  }

  .form-control.textarea {
    min-height: 140px;
    resize: vertical;
    line-height: 1.6;
  }

  /* Enhanced Button Styling */
  .btn-send {
    background: linear-gradient(135deg, #422D1C 0%, #5D3522 25%, #8B4513 75%, #A0522D 100%);
    color: white;
    border: none;
    padding: 18px 45px;
    border-radius: 16px;
    font-weight: 600;
    font-size: 1.1rem;
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
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(66, 45, 28, 0.4);
  }

  .btn-send:active {
    transform: translateY(-1px);
  }

  /* Contact Info Items - Enhanced */
  .contact-info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 2.5rem;
    padding: 20px 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 12px;
  }

  .contact-info-item:hover {
    transform: translateX(10px);
    background: rgba(255, 255, 255, 0.05);
    padding-left: 15px;
  }

  .contact-icon {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 25px;
    font-size: 1.4rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .contact-info-item:hover .contact-icon {
    background: rgba(255, 255, 255, 0.25);
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
  }

  .contact-details h5 {
    margin-bottom: 8px;
    font-weight: 600;
    font-size: 1.2rem;
  }

  .contact-details p {
    margin: 0;
    opacity: 0.9;
    line-height: 1.6;
    font-weight: 300;
  }

  /* Social Links - Enhanced */
  .social-links {
    display: flex;
    gap: 20px;
    margin-top: 40px;
    justify-content: flex-start;
  }

  .social-link {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 1.3rem;
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
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  }

  /* Map Section - Enhanced and Responsive */
  .map-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #f1f3f4 100%);
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
    margin-bottom: 4rem;
    position: relative;
    z-index: 2;
  }

  .map-section-title h2 {
    color: #422D1C;
    font-weight: 700;
    font-size: 2.5rem;
    margin-bottom: 1rem;
    position: relative;
    display: inline-block;
  }

  .map-section-title h2::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 4px;
    background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
    border-radius: 2px;
  }

  .map-section-title p {
    color: #666;
    font-size: 1.1rem;
    font-weight: 300;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
  }

  .map-wrapper {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .map-container {
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 
      0 25px 50px rgba(66, 45, 28, 0.1),
      0 0 0 1px rgba(255, 255, 255, 0.3);
    background: white;
    position: relative;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    aspect-ratio: 16/9;
    min-height: 400px;
  }

  .map-container:hover {
    transform: translateY(-8px);
    box-shadow: 
      0 35px 70px rgba(66, 45, 28, 0.15),
      0 0 0 1px rgba(255, 255, 255, 0.4);
  }

  .map-container iframe {
    width: 100%;
    height: 100%;
    border: 0;
    position: absolute;
    top: 0;
    left: 0;
    border-radius: 24px;
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
    font-size: 1.1rem;
    z-index: 1;
    border-radius: 24px;
  }

  .map-placeholder i {
    font-size: 4rem;
    color: #422D1C;
    margin-bottom: 1.5rem;
    opacity: 0.7;
  }

  .map-placeholder p {
    margin: 0.5rem 0;
    text-align: center;
    line-height: 1.5;
  }

  .map-placeholder .map-address {
    background: rgba(66, 45, 28, 0.05);
    padding: 1rem 2rem;
    border-radius: 16px;
    margin-top: 1rem;
    border-left: 4px solid #8B4513;
  }

  /* Features Section - Enhanced */
  .features-section {
    padding: 100px 0;
    background: white;
    position: relative;
  }

  .feature-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 2.5rem;
    height: 100%;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(66, 45, 28, 0.08);
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(66, 45, 28, 0.05);
  }

  .feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(139, 69, 19, 0.03), transparent);
    transition: left 0.6s;
  }

  .feature-card:hover::before {
    left: 100%;
  }

  .feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(66, 45, 28, 0.15);
    border-color: rgba(139, 69, 19, 0.15);
    background: rgba(255, 255, 255, 0.95);
  }

  .feature-card h5 {
    color: #422D1C;
    font-weight: 600;
    margin-bottom: 1.5rem;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
  }

  .feature-card p {
    color: #666;
    line-height: 1.7;
    font-weight: 300;
    margin: 0;
  }

  .feature-card i {
    color: #8B4513;
    font-size: 1.3rem;
    margin-right: 0.75rem;
  }

  /* Alert Enhancements */
  .alert {
    border-radius: 16px;
    padding: 20px 25px;
    margin-bottom: 2rem;
    border: none;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  }

  .alert-success {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(40, 167, 69, 0.08) 100%);
    color: #155724;
    border-left: 4px solid #28a745;
  }

  /* Invalid feedback styling */
  .is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1) !important;
  }

  .invalid-feedback {
    display: none;
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    font-weight: 500;
  }

  /* Responsive Design */
  @media (max-width: 1200px) {
    .map-container {
      min-height: 350px;
    }
    
    .map-wrapper {
      padding: 0 30px;
    }
  }

  @media (max-width: 992px) {
    .map-container {
      min-height: 300px;
      border-radius: 20px;
    }
    
    .map-container iframe {
      border-radius: 20px;
    }
    
    .map-placeholder {
      border-radius: 20px;
    }
    
    .map-section-title h2 {
      font-size: 2.2rem;
    }
  }

  @media (max-width: 768px) {
    .contact-hero {
      padding: 80px 0 60px 0;
      height: 60vh;
      min-height: 500px;
      background-attachment: scroll;
    }

    .contact-hero h1 {
      font-size: 2.5rem;
    }

    .contact-hero p {
      font-size: 1.1rem;
    }

    .contact-section {
      padding: 60px 0;
    }

    .contact-container {
      margin: 0 20px;
      border-radius: 20px;
    }

    .contact-form-section,
    .contact-info-section {
      padding: 40px;
    }

    .section-title {
      font-size: 2rem;
    }

    .contact-info-item {
      margin-bottom: 2rem;
    }

    .contact-icon {
      width: 50px;
      height: 50px;
      margin-right: 20px;
      font-size: 1.2rem;
    }

    .social-links {
      justify-content: center;
    }

    .map-section {
      padding: 80px 0;
    }

    .map-wrapper {
      padding: 0 20px;
    }

    .map-container {
      height: 280px;
      min-height: 280px;
      border-radius: 16px;
    }

    .map-container iframe {
      border-radius: 16px;
    }

    .map-placeholder {
      border-radius: 16px;
    }

    .map-placeholder i {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    .map-placeholder .map-address {
      padding: 0.75rem 1.5rem;
      margin-top: 0.75rem;
    }

    .map-section-title {
      margin-bottom: 3rem;
    }

    .map-section-title h2 {
      font-size: 2rem;
    }

    .map-section-title p {
      font-size: 1rem;
      padding: 0 20px;
    }

    .features-section {
      padding: 80px 0;
    }

    .feature-card {
      padding: 2rem;
      margin-bottom: 2rem;
    }
  }

  @media (max-width: 576px) {
    .contact-form-section,
    .contact-info-section {
      padding: 30px;
    }

    .section-title {
      font-size: 1.8rem;
    }

    .contact-hero h1 {
      font-size: 2rem;
    }

    .contact-hero p {
      font-size: 1rem;
    }

    .form-control {
      padding: 15px 18px;
    }

    .btn-send {
      padding: 15px 35px;
      font-size: 1rem;
    }

    .feature-card {
      padding: 1.5rem;
    }

    .contact-info-item:hover {
      transform: none;
      padding-left: 0;
    }

    .map-container {
      height: 250px;
      min-height: 250px;
      border-radius: 12px;
    }

    .map-container iframe {
      border-radius: 12px;
    }

    .map-placeholder {
      border-radius: 12px;
      padding: 20px;
    }

    .map-section-title h2 {
      font-size: 1.8rem;
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
  <div class="container">
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
                <p>Jl. Raya Malang No. 123<br>
                Kecamatan Klojen, Malang<br>
                Jawa Timur 65111</p>
              </div>
            </div>
            
            <div class="contact-info-item">
              <div class="contact-icon">
                <i class="bi bi-envelope-fill"></i>
              </div>
              <div class="contact-details">
                <h5>Email</h5>
                <p>info@nusantarashop.com<br>
                support@nusantarashop.com</p>
              </div>
            </div>
            
            <div class="contact-info-item">
              <div class="contact-icon">
                <i class="bi bi-telephone-fill"></i>
              </div>
              <div class="contact-details">
                <h5>Telepon</h5>
                <p>+62 341 123 4567<br>
                WhatsApp: +62 812 3456 7890</p>
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
      <p>Kunjungi showroom kami untuk melihat langsung koleksi batik terbaik dengan kualitas premium dan desain autentik</p>
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

<!-- FAQ Section -->
<div class="features-section">
  <div class="container">
    <div class="text-center mb-5">
      <h2 style="color: #422D1C; font-weight: 700;">Pertanyaan Umum</h2>
      <p style="color: #666; font-size: 1.1rem; max-width: 600px; margin: 0 auto;">Temukan jawaban untuk pertanyaan yang sering diajukan pelanggan tentang produk dan layanan kami</p>
    </div>

    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="feature-card">
          <h5>
            <i class="bi bi-question-circle-fill"></i>
            Bagaimana cara perawatan batik?
          </h5>
          <p>Cuci dengan air dingin, hindari deterjen keras, dan jemur di tempat teduh untuk menjaga kualitas warna dan kain. Setrika dengan suhu sedang.</p>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="feature-card">
          <h5>
            <i class="bi bi-truck"></i>
            Berapa lama waktu pengiriman?
          </h5>
          <p>Pengiriman dalam kota 1-2 hari, luar kota 3-5 hari kerja. Gratis ongkir untuk pembelian di atas Rp 500.000 ke seluruh Indonesia.</p>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="feature-card">
          <h5>
            <i class="bi bi-arrow-repeat"></i>
            Apakah bisa return/tukar?
          </h5>
          <p>Ya, kami menerima return/tukar dalam 7 hari dengan kondisi produk masih dalam keadaan baik, belum dicuci, dan dengan kemasan asli.</p>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="feature-card">
          <h5>
            <i class="bi bi-shield-check"></i>
            Apakah produk asli?
          </h5>
          <p>Semua produk batik kami adalah produk asli dari pengrajin terpercaya dengan sertifikat keaslian dan jaminan kualitas terbaik.</p>
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