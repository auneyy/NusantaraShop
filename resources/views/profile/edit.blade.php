@extends('layout.app')

@section('title', 'Edit Profil')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    /* Reset dan Base Styles */
    .edit-profile-container {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        min-height: 100vh;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Override container default */
    .edit-profile-container .container {
        max-width: 800px !important;
        margin: 40px auto !important;
        padding: 0 20px !important;
    }

    /* Page Title */
    .edit-profile-title {
        text-align: center !important;
        margin-bottom: 30px !important;
    }

    .edit-profile-title h1 {
        font-size: 32px !important;
        color: #333 !important;
        font-weight: 600 !important;
        margin: 0 !important;
    }

    /* Success Message */
    .edit-profile-success {
        background-color: #d4edda !important;
        border: 1px solid #c3e6cb !important;
        color: #155724 !important;
        padding: 12px 16px !important;
        border-radius: 8px !important;
        margin-bottom: 20px !important;
        font-size: 14px !important;
    }

    /* Main Form Container */
    .edit-profile-form-container {
        background: white !important;
        border-radius: 12px !important;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08) !important;
        padding: 40px !important;
        margin: 0 !important;
    }

    /* Form Group */
    .edit-profile-form-group {
        margin-bottom: 24px !important;
    }

    .edit-profile-form-group.large {
        margin-bottom: 32px !important;
    }

    /* Labels */
    .edit-profile-label {
        display: block !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #333 !important;
        margin-bottom: 8px !important;
    }

    .edit-profile-label-required::after {
        content: " *" !important;
        color: #dc3545 !important;
    }

    /* Profile Image Section */
    .edit-profile-image-section {
        display: flex !important;
        align-items: center !important;
        gap: 20px !important;
    }

    .edit-profile-avatar {
        width: 80px !important;
        height: 80px !important;
        border-radius: 50% !important;
        background: linear-gradient(135deg, #8B4513, #D2691E) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: white !important;
        font-size: 32px !important;
        font-weight: bold !important;
        overflow: hidden !important;
        position: relative !important;
        flex-shrink: 0 !important;
    }

    .edit-profile-avatar img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        border-radius: 50% !important;
    }

    /* File Input */
    .edit-profile-file-input {
        display: block !important;
        width: 100% !important;
        font-size: 14px !important;
        color: #666 !important;
        background: white !important;
        border: 1px solid #ddd !important;
        border-radius: 6px !important;
        padding: 8px !important;
        cursor: pointer !important;
        transition: all 0.3s !important;
    }

    .edit-profile-file-input::-webkit-file-upload-button {
        margin-right: 16px !important;
        padding: 6px 16px !important;
        border-radius: 4px !important;
        border: none !important;
        font-size: 12px !important;
        background-color: #f0f0f0 !important;
        color: #8B4513 !important;
        cursor: pointer !important;
        transition: background-color 0.3s !important;
    }

    .edit-profile-file-input::-webkit-file-upload-button:hover {
        background-color: #e0e0e0 !important;
    }

    /* Form Inputs */
    .edit-profile-input {
        width: 100% !important;
        padding: 12px 16px !important;
        border: 1px solid #ddd !important;
        border-radius: 6px !important;
        font-size: 14px !important;
        background: white !important;
        transition: all 0.3s !important;
        color: #333 !important;
    }

    .edit-profile-input:focus {
        outline: none !important;
        border-color: #8B4513 !important;
        box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1) !important;
    }

    .edit-profile-input:disabled {
        background-color: #f8f9fa !important;
        color: #6c757d !important;
        cursor: not-allowed !important;
    }

    /* Textarea */
    .edit-profile-textarea {
        width: 100% !important;
        padding: 12px 16px !important;
        border: 1px solid #ddd !important;
        border-radius: 6px !important;
        font-size: 14px !important;
        background: white !important;
        transition: all 0.3s !important;
        color: #333 !important;
        resize: vertical !important;
        min-height: 80px !important;
        font-family: inherit !important;
    }

    .edit-profile-textarea:focus {
        outline: none !important;
        border-color: #8B4513 !important;
        box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1) !important;
    }

    /* Select Input */
    .edit-profile-select {
        width: 100% !important;
        padding: 12px 16px !important;
        border: 1px solid #ddd !important;
        border-radius: 6px !important;
        font-size: 14px !important;
        background: white !important;
        transition: all 0.3s !important;
        color: #333 !important;
        cursor: pointer !important;
    }

    .edit-profile-select:focus {
        outline: none !important;
        border-color: #8B4513 !important;
        box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1) !important;
    }

    .edit-profile-select:disabled {
        background-color: #f8f9fa !important;
        color: #6c757d !important;
        cursor: not-allowed !important;
    }

    /* Error Messages */
    .edit-profile-error {
        color: #dc3545 !important;
        font-size: 12px !important;
        margin-top: 4px !important;
        display: block !important;
    }

    /* Loading Spinner */
    .edit-profile-loading {
        color: #8B4513 !important;
        font-size: 12px !important;
        margin-top: 4px !important;
        display: none !important;
    }

    /* Address Section */
    .edit-profile-address-section {
        background: #f8f9fa !important;
        border-radius: 8px !important;
        padding: 20px !important;
        margin-top: 10px !important;
        border: 1px solid #e9ecef !important;
    }

    .edit-profile-address-title {
        font-size: 16px !important;
        font-weight: 600 !important;
        color: #333 !important;
        margin-bottom: 16px !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }

    .edit-profile-address-grid {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 16px !important;
    }

    /* Action Buttons */
    .edit-profile-actions {
        display: flex !important;
        gap: 15px !important;
        margin-top: 32px !important;
        padding-top: 24px !important;
        border-top: 1px solid #e0e0e0 !important;
    }

    .edit-profile-btn {
        padding: 12px 24px !important;
        border-radius: 6px !important;
        text-decoration: none !important;
        font-weight: 500 !important;
        text-align: center !important;
        cursor: pointer !important;
        border: none !important;
        transition: all 0.3s !important;
        font-size: 14px !important;
        min-width: 120px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .edit-profile-btn-primary {
        background-color: #8B4513 !important;
        color: white !important;
    }

    .edit-profile-btn-primary:hover {
        background-color: #7A3F12 !important;
        color: white !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(139, 69, 19, 0.2) !important;
    }

    .edit-profile-btn-secondary {
        background-color: white !important;
        color: #666 !important;
        border: 1px solid #ddd !important;
    }

    .edit-profile-btn-secondary:hover {
        background-color: #f5f5f5 !important;
        color: #333 !important;
        text-decoration: none !important;
        border-color: #ccc !important;
        transform: translateY(-1px) !important;
    }

    /* Loading state for submit button */
    .edit-profile-btn-primary:disabled {
        opacity: 0.7 !important;
        cursor: not-allowed !important;
        transform: none !important;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .edit-profile-container .container {
            margin: 20px auto !important;
            padding: 0 15px !important;
        }

        .edit-profile-form-container {
            padding: 24px !important;
        }

        .edit-profile-image-section {
            flex-direction: column !important;
            text-align: center !important;
        }

        .edit-profile-address-grid {
            grid-template-columns: 1fr !important;
        }

        .edit-profile-actions {
            flex-direction: column !important;
        }

        .edit-profile-btn {
            width: 100% !important;
        }

        .edit-profile-title h1 {
            font-size: 24px !important;
        }
    }

    /* Form validation styles */
    .edit-profile-input.error,
    .edit-profile-textarea.error,
    .edit-profile-select.error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
    }

    /* Progress indicator for file upload */
    .edit-profile-upload-progress {
        margin-top: 8px !important;
        height: 4px !important;
        background-color: #f0f0f0 !important;
        border-radius: 2px !important;
        overflow: hidden !important;
        display: none !important;
    }

    .edit-profile-upload-progress-bar {
        height: 100% !important;
        background-color: #8B4513 !important;
        width: 0% !important;
        transition: width 0.3s ease !important;
    }

    /* Override any existing styles */
    .edit-profile-container * {
        box-sizing: border-box !important;
    }

    /* Additional form styling */
    .edit-profile-form-container form {
        margin: 0 !important;
    }

    /* Custom focus styles */
    .edit-profile-input:focus,
    .edit-profile-textarea:focus,
    .edit-profile-file-input:focus,
    .edit-profile-select:focus {
        outline: none !important;
    }

    /* Hover effects */
    .edit-profile-form-container:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
        transition: box-shadow 0.3s ease !important;
    }
</style>
@endpush

@section('content')
<div class="edit-profile-container">
    <div class="container">
        <!-- Page Title -->
        <div class="edit-profile-title">
            <h1>Edit Profil</h1>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="edit-profile-success">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Main Form Container -->
        <div class="edit-profile-form-container">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profile-form">
                @csrf
                @method('PUT')

                <!-- Profile Image Section -->
                <div class="edit-profile-form-group large">
                    <label class="edit-profile-label">
                        <i class="fas fa-camera" style="margin-right: 8px;"></i>
                        Foto Profil
                    </label>
                    <div class="edit-profile-image-section">
                        <div class="edit-profile-avatar">
                            @if($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" id="preview-image">
                            @else
                                <span id="avatar-initial">{{ $user->getInitials() }}</span>
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <input type="file" 
                                   name="profile_image" 
                                   id="profile_image" 
                                   accept="image/*" 
                                   class="edit-profile-file-input"
                                   onchange="previewImage(this)">
                            <div class="edit-profile-upload-progress" id="upload-progress">
                                <div class="edit-profile-upload-progress-bar" id="upload-progress-bar"></div>
                            </div>
                            @error('profile_image')
                                <span class="edit-profile-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Name Field -->
                <div class="edit-profile-form-group">
                    <label for="name" class="edit-profile-label edit-profile-label-required">
                        <i class="fas fa-user" style="margin-right: 8px;"></i>
                        Nama Lengkap
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $user->name) }}" 
                           class="edit-profile-input {{ $errors->has('name') ? 'error' : '' }}" 
                           required>
                    @error('name')
                        <span class="edit-profile-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="edit-profile-form-group">
                    <label for="email" class="edit-profile-label">
                        <i class="fas fa-envelope" style="margin-right: 8px;"></i>
                        Email
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $user->email) }}" 
                           class="edit-profile-input {{ $errors->has('email') ? 'error' : '' }}" 
                           disabled
                           style="background-color: #f8f9fa; color: #6c757d;">
                    <small style="color: #666; font-size: 12px; display: block; margin-top: 4px;">
                        Email tidak dapat diubah
                    </small>
                </div>

                <!-- Phone Field -->
                <div class="edit-profile-form-group">
                    <label for="phone" class="edit-profile-label edit-profile-label-required">
                        <i class="fas fa-phone" style="margin-right: 8px;"></i>
                        Nomor Telepon
                    </label>
                    <input type="text" 
                           name="phone" 
                           id="phone" 
                           value="{{ old('phone', $user->phone) }}" 
                           class="edit-profile-input {{ $errors->has('phone') ? 'error' : '' }}" 
                           required
                           placeholder="Contoh: 082143399676">
                    @error('phone')
                        <span class="edit-profile-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Personal Information -->
                <div class="edit-profile-address-grid">
                    <!-- Birth Date -->
                    <div class="edit-profile-form-group">
                        <label for="birth_date" class="edit-profile-label">
                            <i class="fas fa-birthday-cake" style="margin-right: 8px;"></i>
                            Tanggal Lahir
                        </label>
                        <input type="date" 
                               name="birth_date" 
                               id="birth_date" 
                               value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}" 
                               class="edit-profile-input {{ $errors->has('birth_date') ? 'error' : '' }}">
                        @error('birth_date')
                            <span class="edit-profile-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div class="edit-profile-form-group">
                        <label for="gender" class="edit-profile-label">
                            <i class="fas fa-venus-mars" style="margin-right: 8px;"></i>
                            Jenis Kelamin
                        </label>
                        <select name="gender" 
                                id="gender" 
                                class="edit-profile-select {{ $errors->has('gender') ? 'error' : '' }}">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                            <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('gender')
                            <span class="edit-profile-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Address Section -->
                <div class="edit-profile-form-group">
                    <div class="edit-profile-address-title">
                        <i class="fas fa-map-marker-alt"></i>
                        Alamat Lengkap
                    </div>
                    <div class="edit-profile-address-section">
                        
                        <!-- Province -->
                        <div class="edit-profile-form-group">
                            <label for="province_id" class="edit-profile-label edit-profile-label-required">
                                Provinsi
                            </label>
                            <select name="province_id" 
                                    id="province_id" 
                                    class="edit-profile-select {{ $errors->has('province_id') ? 'error' : '' }}"
                                    required
                                    onchange="loadCities(this.value)">
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province['province_id'] }}" 
                                            {{ old('province_id', $user->getAddressComponent('province_id')) == $province['province_id'] ? 'selected' : '' }}>
                                        {{ $province['province'] }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="edit-profile-loading" id="province-loading">
                                <i class="fas fa-spinner fa-spin"></i> Memuat kota...
                            </span>
                            @error('province_id')
                                <span class="edit-profile-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="edit-profile-form-group">
                            <label for="city_id" class="edit-profile-label edit-profile-label-required">
                                Kota/Kabupaten
                            </label>
                            <select name="city_id" 
                                    id="city_id" 
                                    class="edit-profile-select {{ $errors->has('city_id') ? 'error' : '' }}"
                                    required
                                    disabled>
                                <option value="">Pilih Kota/Kabupaten</option>
                                <!-- Cities will be loaded dynamically -->
                            </select>
                            @error('city_id')
                                <span class="edit-profile-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- District -->
                        <div class="edit-profile-form-group">
                            <label for="district" class="edit-profile-label edit-profile-label-required">
                                Kecamatan
                            </label>
                            <input type="text" 
                                   name="district" 
                                   id="district" 
                                   value="{{ old('district', $user->getAddressComponent('district')) }}" 
                                   class="edit-profile-input {{ $errors->has('district') ? 'error' : '' }}" 
                                   required
                                   placeholder="Masukkan nama kecamatan">
                            @error('district')
                                <span class="edit-profile-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Postal Code -->
                        <div class="edit-profile-form-group">
                            <label for="postal_code" class="edit-profile-label edit-profile-label-required">
                                Kode Pos
                            </label>
                            <input type="text" 
                                   name="postal_code" 
                                   id="postal_code" 
                                   value="{{ old('postal_code', $user->getAddressComponent('postal_code')) }}" 
                                   class="edit-profile-input {{ $errors->has('postal_code') ? 'error' : '' }}" 
                                   required
                                   placeholder="Contoh: 65145"
                                   maxlength="5">
                            @error('postal_code')
                                <span class="edit-profile-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Address Detail -->
                        <div class="edit-profile-form-group">
                            <label for="address" class="edit-profile-label edit-profile-label-required">
                                Alamat Lengkap
                            </label>
                            <textarea name="address" 
                                      id="address" 
                                      rows="3" 
                                      class="edit-profile-textarea {{ $errors->has('address') ? 'error' : '' }}"
                                      required
                                      placeholder="Masukkan alamat lengkap (nama jalan, nomor rumah, RT/RW, dll)">{{ old('address', $user->getAddressComponent('address')) }}</textarea>
                            @error('address')
                                <span class="edit-profile-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="edit-profile-actions">
                    <button type="submit" class="edit-profile-btn edit-profile-btn-primary" id="submit-btn">
                        <i class="fas fa-save" style="margin-right: 8px;"></i>
                        <span id="submit-text">Simpan Perubahan</span>
                    </button>
                    <a href="{{ route('profile.index') }}" class="edit-profile-btn edit-profile-btn-secondary">
                        <i class="fas fa-times" style="margin-right: 8px;"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview image function
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            var previewImg = document.getElementById('preview-image');
            var avatarInitial = document.getElementById('avatar-initial');
            
            if (previewImg) {
                previewImg.src = e.target.result;
            } else {
                // Create new img element if doesn't exist
                var newImg = document.createElement('img');
                newImg.src = e.target.result;
                newImg.id = 'preview-image';
                newImg.style.width = '100%';
                newImg.style.height = '100%';
                newImg.style.objectFit = 'cover';
                newImg.style.borderRadius = '50%';
                
                var avatarContainer = document.querySelector('.edit-profile-avatar');
                if (avatarInitial) {
                    avatarContainer.removeChild(avatarInitial);
                }
                avatarContainer.appendChild(newImg);
            }
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Load cities based on selected province
function loadCities(provinceId) {
    if (!provinceId) {
        document.getElementById('city_id').innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
        document.getElementById('city_id').disabled = true;
        return;
    }

    var citySelect = document.getElementById('city_id');
    var loadingElement = document.getElementById('province-loading');
    
    // Show loading
    loadingElement.style.display = 'block';
    citySelect.disabled = true;
    
    // Clear current options
    citySelect.innerHTML = '<option value="">Memuat kota...</option>';
    
    // Fetch cities from server
    fetch(`/profile/cities/${provinceId}`)
        .then(response => response.json())
        .then(data => {
            // Populate city select
            citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
            
            data.forEach(city => {
                var option = document.createElement('option');
                option.value = city.city_id;
                option.textContent = city.type + ' ' + city.city_name;
                citySelect.appendChild(option);
            });
            
            // Enable city select
            citySelect.disabled = false;
            
            // Set selected city if exists
            var selectedCityId = '{{ old('city_id', $user->getAddressComponent('city_id')) }}';
            if (selectedCityId) {
                citySelect.value = selectedCityId;
            }
        })
        .catch(error => {
            console.error('Error loading cities:', error);
            citySelect.innerHTML = '<option value="">Gagal memuat kota</option>';
        })
        .finally(() => {
            loadingElement.style.display = 'none';
        });
}

// Initialize form on page load
document.addEventListener('DOMContentLoaded', function() {
    // Load cities if province is already selected
    var provinceSelect = document.getElementById('province_id');
    var selectedProvince = provinceSelect.value;
    
    if (selectedProvince) {
        loadCities(selectedProvince);
    }
    
    // Form submission with loading state
    var form = document.getElementById('profile-form');
    var submitBtn = document.getElementById('submit-btn');
    var submitText = document.getElementById('submit-text');
    
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitText.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i>Menyimpan...';
    });
    
    // Auto-hide success message after 5 seconds
    var successMessage = document.querySelector('.edit-profile-success');
    if (successMessage) {
        setTimeout(function() {
            successMessage.style.opacity = '0';
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 300);
        }, 5000);
    }
    
    // Input validation feedback
    document.querySelectorAll('.edit-profile-input, .edit-profile-textarea, .edit-profile-select').forEach(function(input) {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });
        
        input.addEventListener('input', function() {
            this.classList.remove('error');
        });
    });
    
    // Format phone number input
    var phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^\d]/g, '');
    });
    
    // Format postal code input
    var postalInput = document.getElementById('postal_code');
    postalInput.addEventListener('input', function(e) {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^\d]/g, '');
    });
});
</script>
@endsection