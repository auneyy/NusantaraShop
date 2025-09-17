@extends('layout.app')

@section('content')
<style>
  .contact-hero {
    background-image: url('/storage/product_images/header-kontak.png');
    background-size: cover;
    background-position: center;
    padding: 120px 0 80px 0;
    height: 200px;
    text-align: center;
    position: relative;
  }

  .contact-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(66, 45, 28, 0.4);
    z-index: 1;
  }

  .contact-hero .container {
    position: relative;
    z-index: 2;
  }

  .contact-hero h1 {
    color: #FFFFFF;
    font-weight: 600;
    font-size: 2.5rem;
    margin-bottom: 1rem;
    letter-spacing: -0.02em;
  }

  .contact-hero p {
    color: #FFFFFF;
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
    opacity: 0.95;
    line-height: 1.6;
  }

  .contact-section {
    padding: 80px 0;
    background: #FFFFFF;
  }

  .contact-container {
    background: #FFFFFF;
    max-width: 1100px;
    margin: 0 auto;
    box-shadow: 0 2px 20px rgba(66, 45, 28, 0.08);
    border: 1px solid rgba(66, 45, 28, 0.1);
  }

  .contact-form-section {
    padding: 60px 50px;
    background: #FFFFFF;
  }

  .contact-info-section {
    background: #422D1C;
    padding: 60px 50px;
    color: #FFFFFF;
    position: relative;
  }

  .section-title {
    color: #422D1C;
    font-weight: 600;
    font-size: 1.875rem;
    margin-bottom: 2rem;
    letter-spacing: -0.01em;
  }

  .contact-info-section .section-title {
    color: #FFFFFF;
  }

  .form-group {
    margin-bottom: 1.75rem;
  }

  .form-label {
    color: #422D1C;
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
    font-size: 0.95rem;
  }

  .form-control {
    width: 100%;
    padding: 16px 20px;
    border: 1px solid #E5E7EB;
    background-color: #FFFFFF;
    font-size: 1rem;
    transition: all 0.2s ease;
    color: #374151;
  }

  .form-control:focus {
    outline: none;
    border-color: #422D1C;
    box-shadow: 0 0 0 3px rgba(66, 45, 28, 0.1);
  }

  .form-control::placeholder {
    color: #9CA3AF;
  }

  .form-control.textarea {
    min-height: 120px;
    resize: vertical;
    font-family: inherit;
  }

  .btn-send {
    background: #422D1C;
    color: #FFFFFF;
    border: none;
    padding: 18px 36px;
    font-weight: 500;
    font-size: 1rem;
    transition: all 0.2s ease;
    cursor: pointer;
    width: 100%;
    letter-spacing: 0.01em;
  }

  .btn-send:hover {
    background: #2D1F14;
    transform: translateY(-1px);
  }

  .contact-info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 2.5rem;
    padding: 0;
  }

  .contact-icon {
    background: rgba(255, 255, 255, 0.15);
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    font-size: 1.1rem;
    flex-shrink: 0;
    color: #FFFFFF;
  }

  .contact-details h5 {
    margin-bottom: 8px;
    font-weight: 500;
    font-size: 1rem;
    color: #FFFFFF;
  }

  .contact-details p {
    margin: 0;
    opacity: 0.9;
    line-height: 1.6;
    color: #FFFFFF;
    font-size: 0.95rem;
  }

  .social-links {
    display: flex;
    gap: 12px;
    margin-top: 40px;
  }

  .social-link {
    background: rgba(255, 255, 255, 0.15);
    color: #FFFFFF;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.2s ease;
    font-size: 1.1rem;
  }

  .social-link:hover {
    background: #FFFFFF;
    color: #422D1C;
    transform: translateY(-2px);
  }

  .map-section {
    padding: 80px 0;
    background: #F0EDE4;
  }

  .map-section-title {
    text-align: center;
    margin-bottom: 3rem;
  }

  .map-section-title h2 {
    color: #422D1C;
    font-weight: 600;
    font-size: 1.875rem;
    margin-bottom: 0.75rem;
    letter-spacing: -0.01em;
  }

  .map-section-title p {
    color: #6B7280;
    font-size: 1.1rem;
    margin: 0;
  }

  .map-container {
    overflow: hidden;
    height: 400px;
    background: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6B7280;
    font-size: 1rem;
    border: 1px solid rgba(66, 45, 28, 0.1);
    box-shadow: 0 2px 8px rgba(66, 45, 28, 0.06);
  }

  .faq-section {
    padding: 80px 0;
    background: #FFFFFF;
  }

  .faq-section-title {
    text-align: center;
    margin-bottom: 3rem;
  }

  .faq-section-title h2 {
    color: #422D1C;
    font-weight: 600;
    font-size: 1.875rem;
    margin-bottom: 0.75rem;
    letter-spacing: -0.01em;
  }

  .faq-section-title p {
    color: #6B7280;
    font-size: 1.1rem;
    margin: 0;
  }

  .faq-item {
    background: #FFFFFF;
    padding: 2rem;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(66, 45, 28, 0.1);
    transition: all 0.2s ease;
  }

  .faq-item:hover {
    box-shadow: 0 4px 12px rgba(66, 45, 28, 0.08);
    transform: translateY(-2px);
  }

  .faq-item h5 {
    color: #422D1C;
    font-weight: 500;
    margin-bottom: 1rem;
    font-size: 1rem;
    display: flex;
    align-items: center;
  }

  .faq-item h5 i {
    color: #422D1C;
    margin-right: 12px;
    opacity: 0.8;
  }

  .faq-item p {
    color: #6B7280;
    margin: 0;
    line-height: 1.6;
    font-size: 0.95rem;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .contact-hero {
      padding: 80px 0 60px 0;
      height: 400px;
    }

    .contact-hero h1 {
      font-size: 2rem;
    }

    .contact-section {
      padding: 60px 0;
    }

    .contact-container {
      margin: 0 20px;
    }

    .contact-form-section,
    .contact-info-section {
      padding: 40px 30px;
    }

    .section-title,
    .map-section-title h2,
    .faq-section-title h2 {
      font-size: 1.5rem;
    }

    .contact-info-item {
      margin-bottom: 2rem;
    }

    .contact-icon {
      width: 40px;
      height: 40px;
      margin-right: 16px;
    }

    .social-links {
      justify-content: center;
      margin-top: 30px;
    }

    .map-section,
    .faq-section {
      padding: 60px 0;
    }

    .map-container {
      height: 300px;
      margin: 0 20px;
    }

    .faq-item {
      padding: 1.5rem;
      margin: 0 20px 1.5rem 20px;
    }
  }

  @media (max-width: 576px) {
    .contact-form-section,
    .contact-info-section {
      padding: 30px 25px;
    }

    .contact-hero h1 {
      font-size: 1.75rem;
    }

    .contact-hero p {
      font-size: 1rem;
    }

    .faq-item {
      padding: 1.25rem;
    }
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
            <form id="contactForm">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" class="form-control" name="name" placeholder="Masukkan nama lengkap" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control" name="phone" placeholder="Masukkan nomor telepon">
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <label class="form-label">Email *</label>
                <input type="email" class="form-control" name="email" placeholder="Masukkan alamat email" required>
              </div>
              
              <div class="form-group">
                <label class="form-label">Subjek</label>
                <select class="form-control" name="subject">
                  <option value="">Pilih subjek pesan</option>
                  <option value="product">Pertanyaan Produk</option>
                  <option value="order">Status Pesanan</option>
                  <option value="complaint">Keluhan</option>
                  <option value="suggestion">Saran</option>
                  <option value="partnership">Kerjasama</option>
                  <option value="other">Lainnya</option>
                </select>
              </div>
              
              <div class="form-group">
                <label class="form-label">Pesan *</label>
                <textarea class="form-control textarea" name="message" placeholder="Tulis pesan Anda di sini..." required></textarea>
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
      <p>Kunjungi showroom kami untuk melihat langsung koleksi batik terbaik</p>
    </div>
    
    <div class="map-container">
      <div class="text-center">
        <i class="bi bi-map" style="font-size: 2.5rem; color: #422D1C; margin-bottom: 1rem;"></i>
        <p><strong>Google Maps akan ditampilkan di sini</strong></p>
        <p>Integrasikan dengan Google Maps API untuk menampilkan lokasi toko</p>
      </div>
    </div>
  </div>
</div>

<!-- FAQ Section -->
<div class="faq-section">
  <div class="container">
    <div class="faq-section-title">
      <h2>Pertanyaan Umum</h2>
      <p>Temukan jawaban untuk pertanyaan yang sering diajukan</p>
    </div>

    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="faq-item">
          <h5>
            <i class="bi bi-question-circle-fill"></i>
            Bagaimana cara perawatan batik?
          </h5>
          <p>Cuci dengan air dingin, hindari deterjen keras, dan jemur di tempat teduh untuk menjaga kualitas warna dan kain.</p>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="faq-item">
          <h5>
            <i class="bi bi-truck"></i>
            Berapa lama waktu pengiriman?
          </h5>
          <p>Pengiriman dalam kota 1-2 hari, luar kota 3-5 hari kerja. Gratis ongkir untuk pembelian di atas Rp 500.000.</p>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="faq-item">
          <h5>
            <i class="bi bi-arrow-repeat"></i>
            Apakah bisa return/tukar?
          </h5>
          <p>Ya, kami menerima return/tukar dalam 7 hari dengan kondisi produk masih dalam keadaan baik dan belum dicuci.</p>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="faq-item">
          <h5>
            <i class="bi bi-shield-check"></i>
            Apakah produk asli?
          </h5>
          <p>Semua produk batik kami adalah produk asli dari pengrajin terpercaya dengan sertifikat keaslian.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle contact form submission
    const contactForm = document.getElementById('contactForm');
    
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(contactForm);
        const name = formData.get('name');
        const email = formData.get('email');
        const phone = formData.get('phone');
        const subject = formData.get('subject');
        const message = formData.get('message');
        
        // Basic validation
        if (!name || !email || !message) {
            showMessage('Mohon lengkapi semua field yang wajib diisi', 'error');
            return;
        }
        
        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showMessage('Format email tidak valid', 'error');
            return;
        }
        
        // Simulate form submission
        showMessage('Mengirim pesan...', 'info');
        
        // Simulate API call
        setTimeout(() => {
            showMessage('Pesan berhasil dikirim! Kami akan merespon dalam 24 jam.', 'success');
            contactForm.reset();
        }, 2000);
    });
    
    // Add subtle animations to form inputs
    const formInputs = document.querySelectorAll('.form-control');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'translateY(-1px)';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Function to show messages
function showMessage(text, type) {
    const message = document.createElement('div');
    const bgColor = type === 'success' ? '#10B981' : type === 'error' ? '#EF4444' : '#3B82F6';
    
    message.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${bgColor};
        color: white;
        padding: 16px 24px;
        border-radius: 4px;
        z-index: 9999;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideIn 0.3s ease;
        font-size: 0.95rem;
    `;
    
    message.textContent = text;
    document.body.appendChild(message);
    
    setTimeout(() => {
        if (message.parentNode) {
            message.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                document.body.removeChild(message);
            }, 300);
        }
    }, 4000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>

@endsection

