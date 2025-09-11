@extends('layout.app')

@section('content')
<style>

  .contact-hero {
    background-image: url('/storage/product_images/header-kontak.png');
    background-size: cover;
    background-position: center;
    padding: 150px 0 100px 0;
    height: 600px;
    text-align: center;
  }

  .contact-hero h1 {
    color:rgb(255, 255, 255);
    font-weight: 700;
    font-size: 2.5rem;
    margin-bottom: 1rem;
    justify-content: center;
    display: flex;
    margin-top: 80px;
  }

  .contact-hero p {
    color: #f8f9fa;
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
  }

  .contact-section {
    padding: 80px 0;
    background:rgb(234, 234, 234);
    min-height: 100vh;
    display: flex;
    align-items: center;
  }

  .contact-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(66, 45, 28, 0.1);
    overflow: hidden;
    max-width: 1000px;
    margin: 0 auto;
  }

  .contact-form-section {
    padding: 50px;
    background: white;
  }

  .contact-info-section {
    background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
    padding: 50px;
    color: white;
    position: relative;
    overflow: hidden;
  }

  .contact-info-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="batik" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23batik)"/></svg>');
    opacity: 0.3;
  }

  .contact-info-section > * {
    position: relative;
    z-index: 2;
  }

  .section-title {
    color: #422D1C;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 2rem;
  }

  .contact-info-section .section-title {
    color: white;
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-label {
    color: #422D1C;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: block;
  }

  .form-control {
    width: 100%;
    padding: 15px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
  }

  .form-control:focus {
    outline: none;
    border-color: #422D1C;
    background-color: white;
    box-shadow: 0 0 0 3px rgba(66, 45, 28, 0.1);
  }

  .form-control.textarea {
    min-height: 120px;
    resize: vertical;
  }

  .btn-send {
    background: linear-gradient(135deg, #422D1C 0%, #8B4513 100%);
    color: white;
    border: none;
    padding: 15px 40px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
    width: 100%;
  }

  .btn-send:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(66, 45, 28, 0.3);
  }

  .contact-info-item {
    display: flex;
    align-items: center;
    margin-bottom: 2rem;
    padding: 15px 0;
  }

  .contact-icon {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    font-size: 1.2rem;
  }

  .contact-details h5 {
    margin-bottom: 5px;
    font-weight: 600;
  }

  .contact-details p {
    margin: 0;
    opacity: 0.9;
    line-height: 1.4;
  }

  .social-links {
    display: flex;
    gap: 15px;
    margin-top: 30px;
  }

  .social-link {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.2rem;
  }

  .social-link:hover {
    background: white;
    color: #422D1C;
    transform: translateY(-3px);
  }

  .map-section {
    padding: 80px 0;
    background:rgb(234, 234, 234);
  }

  .map-container {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    height: 400px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
    font-size: 1.1rem;
  }

  .features-section {
    padding: 80px 0;
    background: white;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .contact-hero {
      padding: 60px 0 40px 0;
    }

    .contact-hero h1 {
      font-size: 2rem;
    }

    .contact-section {
      padding: 40px 0;
    }

    .contact-container {
      margin: 0 20px;
      border-radius: 15px;
    }

    .contact-form-section,
    .contact-info-section {
      padding: 30px;
    }

    .contact-info-item {
      margin-bottom: 1.5rem;
    }

    .contact-icon {
      width: 40px;
      height: 40px;
      margin-right: 15px;
    }

    .social-links {
      justify-content: center;
    }

    .map-section {
      padding: 60px 0;
    }

    .map-container {
      height: 300px;
      margin: 0 20px;
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
    <div class="text-center mb-5">
      <h2 style="color: #422D1C; font-weight: 700;">Lokasi Toko Kami</h2>
      <p style="color: #666; font-size: 1.1rem;">Kunjungi showroom kami untuk melihat langsung koleksi batik terbaik</p>
    </div>
    
    <div class="map-container">
      <div class="text-center">
        <i class="bi bi-map" style="font-size: 3rem; color: #422D1C; margin-bottom: 1rem;"></i>
        <p><strong>Google Maps akan ditampilkan di sini</strong></p>
        <p>Integrasikan dengan Google Maps API untuk menampilkan lokasi toko</p>
      </div>
    </div>
  </div>
</div>

<!-- FAQ Section -->
<div class="features-section" style="background: white;">
  <div class="container">
    <div class="text-center mb-5">
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
    
    // Add smooth animations to form inputs
    const formInputs = document.querySelectorAll('.form-control');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Function to show messages
function showMessage(text, type) {
    const message = document.createElement('div');
    const bgColor = type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8';
    
    message.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${bgColor};
        color: white;
        padding: 15px 25px;
        border-radius: 10px;
        z-index: 9999;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        animation: slideIn 0.3s ease;
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