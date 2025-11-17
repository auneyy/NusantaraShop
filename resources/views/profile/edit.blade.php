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

    /* Error Messages */
    .edit-profile-error {
        color: #dc3545 !important;
        font-size: 12px !important;
        margin-top: 4px !important;
        display: block !important;
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
    .edit-profile-input.error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
    }

    .edit-profile-textarea.error {
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
    .edit-profile-file-input:focus {
        outline: none !important;
    }

    /* Hover effects */
    .edit-profile-form-container:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
        transition: box-shadow 0.3s ease !important;
    }

    /* Icon styling for form fields */
    .edit-profile-input-group {
        position: relative !important;
    }

    .edit-profile-input-icon {
        position: absolute !important;
        left: 12px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        color: #666 !important;
        font-size: 16px !important;
    }

    .edit-profile-input.with-icon {
        padding-left: 40px !important;
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
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
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
                                <span id="avatar-initial">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
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
                    <label for="name" class="edit-profile-label">
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
                           required>
                    @error('email')
                        <span class="edit-profile-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone Field -->
                <div class="edit-profile-form-group">
                    <label for="phone" class="edit-profile-label">
                        <i class="fas fa-phone" style="margin-right: 8px;"></i>
                        Nomor Telepon
                    </label>
                    <input type="text" 
                           name="phone" 
                           id="phone" 
                           value="{{ old('phone', $user->phone) }}" 
                           class="edit-profile-input {{ $errors->has('phone') ? 'error' : '' }}" 
                           placeholder="Contoh: 082143399676">
                    @error('phone')
                        <span class="edit-profile-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Address Field -->
                <div class="edit-profile-form-group">
                    <label for="address" class="edit-profile-label">
                        <i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>
                        Alamat
                    </label>
                    <textarea name="address" 
                              id="address" 
                              rows="3" 
                              class="edit-profile-textarea {{ $errors->has('address') ? 'error' : '' }}"
                              placeholder="Masukkan alamat lengkap Anda">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <span class="edit-profile-error">{{ $message }}</span>
                    @enderror
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

// Form submission with loading state
document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('form');
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
});

// Input validation feedback
document.querySelectorAll('.edit-profile-input, .edit-profile-textarea').forEach(function(input) {
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
</script>
@endsection