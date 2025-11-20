@extends('layout.app')

@section('content')
<style>
  * {
    box-sizing: border-box;
  }

  /* Hero Section - Enhanced */
  .contact-hero {
    background-image: url('/storage/product_images/batikpramisoloc.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    padding: 120px 0 80px 0;
    min-height: 85vh;
    text-align: center;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    color: white;
  }

  .contact-hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1;
  }

  .contact-hero > * {
    position: relative;
    z-index: 2;
  }

  .contact-hero h1 {
    color: #ffffff;
    font-weight: 700;
    font-size: 3rem;
    margin-bottom: 1rem;
    text-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    letter-spacing: -0.02em;
  }

  .contact-hero p {
    color: rgb(228, 228, 228);
    font-size: 1.15rem;
    font-weight: 300;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.7;
  }

  /* Main Contact Container - New Layout */
  .contact-main {
    padding: 80px 0;
    background: #f8f9fa;
    position: relative;
  }

  .contact-main::before {
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

  .contact-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .contact-grid {
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 40px;
    align-items: start;
  }

  /* Get in Touch Section - Left Side */
  .get-in-touch {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 4px 20px rgba(66, 45, 28, 0.08);
    position: sticky;
    top: 100px;
  }

  .get-in-touch h2 {
    color: #422D1C;
    font-weight: 700;
    font-size: 1.8rem;
    margin-bottom: 1rem;
  }

  .get-in-touch-desc {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 2rem;
  }

  /* Contact Info Items */
  .contact-info-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-bottom: 2rem;
  }

  .contact-info-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 12px 0;
    transition: all 0.3s ease;
  }

  .contact-info-item:hover {
    transform: translateX(5px);
  }

  .contact-icon {
    background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
    border-radius: 50%;
    width: 48px;
    height: 48px;
    min-width: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: white;
    box-shadow: 0 4px 15px rgba(66, 45, 28, 0.2);
    transition: all 0.3s ease;
  }

  .contact-info-item:hover .contact-icon {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(66, 45, 28, 0.3);
  }

  .contact-details h5 {
    color: #422D1C;
    font-weight: 600;
    font-size: 1rem;
    margin: 0 0 4px 0;
  }

  .contact-details p {
    color: #666;
    margin: 0;
    font-size: 0.9rem;
    line-height: 1.5;
  }

  /* Social Links */
  .social-section {
    padding-top: 1.5rem;
    border-top: 1px solid #e9ecef;
  }

  .social-section h6 {
    color: #422D1C;
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 1rem;
  }

  .social-links {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
  }

  .social-link {
    background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
    color: white;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.1rem;
    box-shadow: 0 2px 10px rgba(66, 45, 28, 0.2);
  }

  .social-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(66, 45, 28, 0.3);
    color: white;
  }

  /* Send Message Section - Right Side */
  .send-message {
    background: white;
    border-radius: 20px;
    padding: 50px;
    box-shadow: 0 4px 20px rgba(66, 45, 28, 0.08);
  }

  .send-message h2 {
    color: #422D1C;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 2rem;
  }

  /* Form Styling */
  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group.full-width {
    grid-column: 1 / -1;
  }

  .form-label {
    color: #422D1C;
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
    font-size: 0.9rem;
  }

  .form-control {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid rgba(66, 45, 28, 0.15);
    border-radius: 12px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #f8f9fa;
    color: #333;
  }

  .form-control::placeholder {
    color: rgba(66, 45, 28, 0.4);
  }

  .form-control:focus {
    outline: none;
    border-color: #8B4513;
    background: white;
    box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.08);
  }

  .form-control:hover:not(:focus) {
    border-color: rgba(139, 69, 19, 0.25);
    background: white;
  }

  .form-control.textarea {
    min-height: 140px;
    resize: vertical;
    line-height: 1.6;
  }

  /* Button */
  .btn-send {
    background: linear-gradient(135deg, #422D1C 0%, #5D3522 25%, #8B4513 75%, #A0522D 100%);
    color: white;
    border: none;
    padding: 16px 40px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    width: 100%;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(66, 45, 28, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .btn-send:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(66, 45, 28, 0.4);
  }

  .btn-send:active {
    transform: translateY(0);
  }

  /* Alert */
  .alert {
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 1.5rem;
    border: none;
  }

  .alert-success {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(40, 167, 69, 0.08) 100%);
    color: #155724;
    border-left: 4px solid #28a745;
  }

  /* Invalid feedback */
  .is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1) !important;
  }

  .invalid-feedback {
    display: none;
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 0.5rem;
  }

  /* Map Section */
  .map-section {
    padding: 80px 0;
    background: white;
  }

  .map-section-title {
    text-align: center;
    margin-bottom: 3rem;
  }

  .map-section-title h2 {
    color: #422D1C;
    font-weight: 700;
    font-size: 2.2rem;
    margin-bottom: 1rem;
  }

  .map-section-title p {
    color: #666;
    font-size: 1.05rem;
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
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(66, 45, 28, 0.1);
    background: white;
    position: relative;
    aspect-ratio: 16/9;
    min-height: 400px;
    transition: all 0.3s ease;
  }

  .map-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 50px rgba(66, 45, 28, 0.15);
  }

  .map-container iframe {
    width: 100%;
    height: 100%;
    border: 0;
    position: absolute;
    top: 0;
    left: 0;
  }

  /* FAQ Section */
  .faq-section {
    padding: 80px 0;
    background: #f8f9fa;
  }

  .faq-title {
    text-align: center;
    margin-bottom: 3rem;
  }

  .faq-title h2 {
    color: #422D1C;
    font-weight: 700;
    font-size: 2.2rem;
    margin-bottom: 1rem;
  }

  .faq-title p {
    color: #666;
    font-size: 1.05rem;
    max-width: 600px;
    margin: 0 auto;
  }

  .faq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .faq-card {
    background: white;
    border-radius: 16px;
    padding: 30px;
    transition: all 0.3s ease;
    border: 1px solid rgba(66, 45, 28, 0.08);
    box-shadow: 0 2px 15px rgba(66, 45, 28, 0.05);
  }

  .faq-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(66, 45, 28, 0.12);
  }

  .faq-card h5 {
    color: #422D1C;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .faq-card h5 i {
    color: #8B4513;
    font-size: 1.2rem;
  }

  .faq-card p {
    color: #666;
    line-height: 1.6;
    margin: 0;
    font-size: 0.95rem;
  }

  /* Responsive */
  @media (max-width: 992px) {
    .contact-grid {
      grid-template-columns: 1fr;
      gap: 30px;
    }

    .get-in-touch {
      position: relative;
      top: 0;
    }

    .send-message {
      padding: 40px 30px;
    }

    .form-row {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 768px) {
    .contact-hero {
      padding: 100px 0 60px 0;
      min-height: 40vh;
      background-attachment: scroll;
    }

    .contact-hero h1 {
      font-size: 2.2rem;
    }

    .contact-hero p {
      font-size: 1rem;
    }

    .contact-main {
      padding: 60px 0;
    }

    .get-in-touch,
    .send-message {
      padding: 30px 25px;
    }

    .send-message h2 {
      font-size: 1.6rem;
    }

    .get-in-touch h2 {
      font-size: 1.5rem;
    }

    .map-container {
      min-height: 300px;
    }

    .faq-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 576px) {
    .contact-hero h1 {
      font-size: 1.8rem;
    }

    .get-in-touch,
    .send-message {
      padding: 25px 20px;
      border-radius: 16px;
    }

    .contact-icon {
      width: 42px;
      height: 42px;
      min-width: 42px;
      font-size: 1rem;
    }

    .social-link {
      width: 38px;
      height: 38px;
      font-size: 1rem;
    }
  }

  html {
    scroll-behavior: smooth;
  }
</style>

<!-- Hero Section -->
<div class="contact-hero">
  <div class="container">
    <h1>Hubungi Kami</h1>
    <p>Kami siap membantu Anda dengan pertanyaan apapun tentang produk batik tradisional Indonesia kami</p>
  </div>
</div>

<!-- Main Contact Section -->
<div class="contact-main">
  <div class="contact-wrapper">
    <div class="contact-grid">
      <!-- Left Side - Get in Touch -->
      <div class="get-in-touch">
        <h2>Get in touch</h2>
        <p class="get-in-touch-desc">Kami siap membantu Anda dengan pertanyaan apapun terkait produk batik dan layanan kami</p>
        
        <div class="contact-info-list">
          <div class="contact-info-item">
            <div class="contact-icon">
              <i class="bi bi-geo-alt-fill"></i>
            </div>
            <div class="contact-details">
              <h5>Head Office</h5>
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
              <h5>Email Us</h5>
              <p>info@nusantarashop.com<br>
              support@nusantarashop.com</p>
            </div>
          </div>
          
          <div class="contact-info-item">
            <div class="contact-icon">
              <i class="bi bi-telephone-fill"></i>
            </div>
            <div class="contact-details">
              <h5>Call Us</h5>
              <p>Phone: +6221.2002.2012<br>
              Fax: +6221.2002.2013</p>
            </div>
          </div>
        </div>
        
        <div class="social-section">
          <h6>Follow our social media</h6>
          <div class="social-links">
            <a href="#" class="social-link" title="Facebook">
              <i class="bi bi-facebook"></i>
            </a>
            <a href="#" class="social-link" title="Instagram">
              <i class="bi bi-instagram"></i>
            </a>
            <a href="#" class="social-link" title="Twitter">
              <i class="bi bi-twitter"></i>
            </a>
            <a href="#" class="social-link" title="LinkedIn">
              <i class="bi bi-linkedin"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Right Side - Send Message Form -->
      <div class="send-message">
        <h2>Send us a message</h2>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        
        <form action="{{ route('contact.store') }}" method="POST">
          @csrf

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" 
                     name="name" placeholder="Name" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label">Company</label>
              <input type="text" class="form-control" 
                     name="company" placeholder="Company">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Phone</label>
              <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                     name="phone" placeholder="Phone">
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" 
                     name="email" placeholder="Email" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          
          <div class="form-group full-width">
            <label class="form-label">Subject</label>
            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                   name="subject" placeholder="Subject">
            @error('subject')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="form-group full-width">
            <label class="form-label">Message</label>
            <textarea class="form-control textarea @error('message') is-invalid @enderror" 
                      name="message" placeholder="Message" required></textarea>
            @error('message')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          
          <button type="submit" class="btn-send">
            <i class="bi bi-send-fill"></i>
            Send
          </button>
        </form>
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
      </div>
    </div>
  </div>
</div>

<!-- FAQ Section -->
<div class="faq-section">
  <div class="container">
    <div class="faq-title">
      <h2>Pertanyaan Umum</h2>
      <p>Temukan jawaban untuk pertanyaan yang sering diajukan pelanggan tentang produk dan layanan kami</p>
    </div>

    <div class="faq-grid">
      <div class="faq-card">
        <h5>
          <i class="bi bi-question-circle-fill"></i>
          Bagaimana cara perawatan batik?
        </h5>
        <p>Cuci dengan air dingin, hindari deterjen keras, dan jemur di tempat teduh untuk menjaga kualitas warna dan kain. Setrika dengan suhu sedang.</p>
      </div>
      
      <div class="faq-card">
        <h5>
          <i class="bi bi-truck"></i>
          Berapa lama waktu pengiriman?
        </h5>
        <p>Pengiriman dalam kota 1-2 hari, luar kota 3-5 hari kerja. Gratis ongkir untuk pembelian di atas Rp 500.000 ke seluruh Indonesia.</p>
      </div>
      
      <div class="faq-card">
        <h5>
          <i class="bi bi-arrow-repeat"></i>
          Apakah bisa return/tukar?
        </h5>
        <p>Ya, kami menerima return/tukar dalam 7 hari dengan kondisi produk masih dalam keadaan baik, belum dicuci, dan dengan kemasan asli.</p>
      </div>
      
      <div class="faq-card">
        <h5>
          <i class="bi bi-shield-check"></i>
          Apakah produk asli?
        </h5>
        <p>Semua produk batik kami adalah produk asli dari pengrajin terpercaya dengan sertifikat keaslian dan jaminan kualitas terbaik.</p>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('form[action*="contact.store"]');
    
    if (contactForm) {
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
            }
        });
    }
    
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
});
</script>

@endsection