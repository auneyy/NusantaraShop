@extends('layout.app')

@section('title', 'Ubah Password')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    /* Reset dan Base Styles */
    .change-password-container {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        background-color: #f5f5f5 !important;
        min-height: 100vh;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Override container default */
    .change-password-container .container {
        max-width: 500px !important;
        margin: 40px auto !important;
        padding: 0 20px !important;
    }

    /* Page Title */
    .change-password-title {
        text-align: center !important;
        margin-bottom: 30px !important;
    }

    .change-password-title h1 {
        font-size: 32px !important;
        color: #333 !important;
        font-weight: 600 !important;
        margin: 0 !important;
    }

    /* Success Message */
    .change-password-success {
        background-color: #d4edda !important;
        border: 1px solid #c3e6cb !important;
        color: #155724 !important;
        padding: 12px 16px !important;
        border-radius: 8px !important;
        margin-bottom: 20px !important;
        font-size: 14px !important;
        display: flex !important;
        align-items: center !important;
    }

    .change-password-success i {
        margin-right: 8px !important;
        color: #28a745 !important;
    }

    /* Main Form Container */
    .change-password-form-container {
        background: white !important;
        border-radius: 12px !important;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08) !important;
        padding: 40px !important;
        margin: 0 !important;
    }

    /* Form Group */
    .change-password-form-group {
        margin-bottom: 24px !important;
    }

    .change-password-form-group.large {
        margin-bottom: 32px !important;
    }

    /* Labels */
    .change-password-label {
        display: block !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #333 !important;
        margin-bottom: 8px !important;
    }

    /* Password Input Container */
    .change-password-input-container {
        position: relative !important;
    }

    /* Form Inputs */
    .change-password-input {
        width: 100% !important;
        padding: 12px 16px !important;
        padding-right: 45px !important;
        border: 1px solid #ddd !important;
        border-radius: 6px !important;
        font-size: 14px !important;
        background: white !important;
        transition: all 0.3s !important;
        color: #333 !important;
    }

    .change-password-input:focus {
        outline: none !important;
        border-color: #8B4513 !important;
        box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1) !important;
    }

    /* Password Toggle Button */
    .change-password-toggle {
        position: absolute !important;
        right: 12px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        background: none !important;
        border: none !important;
        color: #666 !important;
        cursor: pointer !important;
        padding: 4px !important;
        border-radius: 3px !important;
        transition: color 0.3s !important;
    }

    .change-password-toggle:hover {
        color: #8B4513 !important;
    }

    /* Error Messages */
    .change-password-error {
        color: #dc3545 !important;
        font-size: 12px !important;
        margin-top: 4px !important;
        display: block !important;
    }

    /* Password Strength Indicator */
    .change-password-strength {
        margin-top: 8px !important;
        font-size: 12px !important;
    }

    .change-password-strength-bar {
        height: 4px !important;
        background-color: #f0f0f0 !important;
        border-radius: 2px !important;
        margin-top: 4px !important;
        overflow: hidden !important;
    }

    .change-password-strength-fill {
        height: 100% !important;
        width: 0% !important;
        transition: all 0.3s ease !important;
        border-radius: 2px !important;
    }

    .strength-weak .change-password-strength-fill {
        width: 25% !important;
        background-color: #dc3545 !important;
    }

    .strength-fair .change-password-strength-fill {
        width: 50% !important;
        background-color: #fd7e14 !important;
    }

    .strength-good .change-password-strength-fill {
        width: 75% !important;
        background-color: #ffc107 !important;
    }

    .strength-strong .change-password-strength-fill {
        width: 100% !important;
        background-color: #28a745 !important;
    }

    /* Password Requirements */
    .change-password-requirements {
        margin-top: 8px !important;
        font-size: 12px !important;
        color: #666 !important;
    }

    .change-password-requirements ul {
        margin: 4px 0 0 16px !important;
        padding: 0 !important;
    }

    .change-password-requirements li {
        margin-bottom: 2px !important;
        display: flex !important;
        align-items: center !important;
    }

    .change-password-requirements li i {
        margin-right: 6px !important;
        width: 12px !important;
    }

    .requirement-met {
        color: #28a745 !important;
    }

    .requirement-not-met {
        color: #dc3545 !important;
    }

    /* Action Buttons */
    .change-password-actions {
        display: flex !important;
        gap: 15px !important;
        margin-top: 32px !important;
        padding-top: 24px !important;
        border-top: 1px solid #e0e0e0 !important;
    }

    .change-password-btn {
        padding: 12px 24px !important;
        border-radius: 6px !important;
        text-decoration: none !important;
        font-weight: 500 !important;
        text-align: center !important;
        cursor: pointer !important;
        border: none !important;
        transition: all 0.3s !important;
        font-size: 14px !important;
        flex: 1 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .change-password-btn-primary {
        background-color: #8B4513 !important;
        color: white !important;
    }

    .change-password-btn-primary:hover {
        background-color: #7A3F12 !important;
        color: white !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(139, 69, 19, 0.2) !important;
    }

    .change-password-btn-primary:disabled {
        opacity: 0.7 !important;
        cursor: not-allowed !important;
        transform: none !important;
    }

    .change-password-btn-secondary {
        background-color: white !important;
        color: #666 !important;
        border: 1px solid #ddd !important;
    }

    .change-password-btn-secondary:hover {
        background-color: #f5f5f5 !important;
        color: #333 !important;
        text-decoration: none !important;
        border-color: #ccc !important;
        transform: translateY(-1px) !important;
    }

    /* Form validation styles */
    .change-password-input.error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
    }

    .change-password-input.success {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1) !important;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .change-password-container .container {
            margin: 20px auto !important;
            padding: 0 15px !important;
        }

        .change-password-form-container {
            padding: 24px !important;
        }

        .change-password-actions {
            flex-direction: column !important;
        }

        .change-password-title h1 {
            font-size: 24px !important;
        }
    }

    /* Security Tips */
    .change-password-tips {
        background-color: #f8f9fa !important;
        border-left: 4px solid #8B4513 !important;
        padding: 16px !important;
        margin-top: 20px !important;
        border-radius: 4px !important;
        font-size: 13px !important;
        color: #666 !important;
    }

    .change-password-tips h4 {
        color: #333 !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        margin-bottom: 8px !important;
        display: flex !important;
        align-items: center !important;
    }

    .change-password-tips h4 i {
        margin-right: 8px !important;
        color: #8B4513 !important;
    }

    .change-password-tips ul {
        margin: 8px 0 0 0 !important;
        padding-left: 16px !important;
    }

    .change-password-tips li {
        margin-bottom: 4px !important;
    }

    /* Override any existing styles */
    .change-password-container * {
        box-sizing: border-box !important;
    }

    /* Additional form styling */
    .change-password-form-container form {
        margin: 0 !important;
    }

    /* Hover effects */
    .change-password-form-container:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
        transition: box-shadow 0.3s ease !important;
    }
</style>
@endpush

@section('content')
<div class="change-password-container">
    <div class="container">
        <!-- Page Title -->
        <div class="change-password-title">
            <h1>
                <i class="fas fa-lock" style="margin-right: 12px; color: #8B4513;"></i>
                Ubah Password
            </h1>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="change-password-success" id="success-message">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Main Form Container -->
        <div class="change-password-form-container">
            <form method="POST" action="{{ route('password.update') }}" id="change-password-form">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div class="change-password-form-group">
                    <label for="current_password" class="change-password-label">
                        <i class="fas fa-key" style="margin-right: 8px;"></i>
                        Password Lama
                    </label>
                    <div class="change-password-input-container">
                        <input type="password" 
                               name="current_password" 
                               id="current_password"
                               class="change-password-input {{ $errors->has('current_password') ? 'error' : '' }}" 
                               required
                               autocomplete="current-password">
                        <button type="button" class="change-password-toggle" onclick="togglePassword('current_password')">
                            <i class="fas fa-eye" id="current_password_icon"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <span class="change-password-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="change-password-form-group">
                    <label for="password" class="change-password-label">
                        <i class="fas fa-lock" style="margin-right: 8px;"></i>
                        Password Baru
                    </label>
                    <div class="change-password-input-container">
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="change-password-input {{ $errors->has('password') ? 'error' : '' }}" 
                               required
                               autocomplete="new-password"
                               onkeyup="checkPasswordStrength(this.value)">
                        <button type="button" class="change-password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password_icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="change-password-error">{{ $message }}</span>
                    @enderror
                    
                    <!-- Password Strength Indicator -->
                    <div class="change-password-strength" id="password-strength" style="display: none;">
                        <div class="change-password-strength-bar">
                            <div class="change-password-strength-fill" id="strength-fill"></div>
                        </div>
                        <span id="strength-text"></span>
                    </div>

                    <!-- Password Requirements -->
                    <div class="change-password-requirements" id="password-requirements" style="display: none;">
                        <ul>
                            <li id="req-length"><i class="fas fa-times"></i> Minimal 8 karakter</li>
                            <li id="req-uppercase"><i class="fas fa-times"></i> Satu huruf besar</li>
                            <li id="req-lowercase"><i class="fas fa-times"></i> Satu huruf kecil</li>
                            <li id="req-number"><i class="fas fa-times"></i> Satu angka</li>
                            <li id="req-special"><i class="fas fa-times"></i> Satu karakter khusus</li>
                        </ul>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="change-password-form-group large">
                    <label for="password_confirmation" class="change-password-label">
                        <i class="fas fa-shield-alt" style="margin-right: 8px;"></i>
                        Konfirmasi Password Baru
                    </label>
                    <div class="change-password-input-container">
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation"
                               class="change-password-input" 
                               required
                               autocomplete="new-password"
                               onkeyup="checkPasswordMatch()">
                        <button type="button" class="change-password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" id="password_confirmation_icon"></i>
                        </button>
                    </div>
                    <span class="change-password-error" id="password-match-error" style="display: none;">Password tidak cocok</span>
                    <span style="color: #28a745; font-size: 12px; margin-top: 4px; display: none;" id="password-match-success">
                        <i class="fas fa-check"></i> Password cocok
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="change-password-actions">
                    <button type="submit" class="change-password-btn change-password-btn-primary" id="submit-btn">
                        <i class="fas fa-save" style="margin-right: 8px;"></i>
                        <span id="submit-text">Ubah Password</span>
                    </button>
                    <a href="{{ route('profile.index') }}" class="change-password-btn change-password-btn-secondary">
                        <i class="fas fa-times" style="margin-right: 8px;"></i>
                        Batal
                    </a>
                </div>
            </form>

            <!-- Security Tips -->
            <div class="change-password-tips">
                <h4>
                    <i class="fas fa-shield-alt"></i>
                    Tips Keamanan Password
                </h4>
                <ul>
                    <li>Gunakan kombinasi huruf besar, kecil, angka, dan karakter khusus</li>
                    <li>Hindari menggunakan informasi pribadi seperti tanggal lahir atau nama</li>
                    <li>Jangan gunakan password yang sama untuk akun lain</li>
                    <li>Ubah password secara berkala untuk keamanan yang lebih baik</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + '_icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Check password strength
function checkPasswordStrength(password) {
    const strengthIndicator = document.getElementById('password-strength');
    const strengthFill = document.getElementById('strength-fill');
    const strengthText = document.getElementById('strength-text');
    const requirements = document.getElementById('password-requirements');
    
    if (password.length === 0) {
        strengthIndicator.style.display = 'none';
        requirements.style.display = 'none';
        return;
    }
    
    strengthIndicator.style.display = 'block';
    requirements.style.display = 'block';
    
    let strength = 0;
    const checks = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /\d/.test(password),
        special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
    };
    
    // Update requirements
    Object.keys(checks).forEach(key => {
        const element = document.getElementById('req-' + key);
        const icon = element.querySelector('i');
        if (checks[key]) {
            element.classList.add('requirement-met');
            element.classList.remove('requirement-not-met');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-check');
            strength++;
        } else {
            element.classList.add('requirement-not-met');
            element.classList.remove('requirement-met');
            icon.classList.remove('fa-check');
            icon.classList.add('fa-times');
        }
    });
    
    // Update strength indicator
    const strengthClasses = ['strength-weak', 'strength-fair', 'strength-good', 'strength-strong'];
    strengthIndicator.className = 'change-password-strength';
    
    if (strength <= 2) {
        strengthIndicator.classList.add('strength-weak');
        strengthText.textContent = 'Lemah';
        strengthText.style.color = '#dc3545';
    } else if (strength === 3) {
        strengthIndicator.classList.add('strength-fair');
        strengthText.textContent = 'Cukup';
        strengthText.style.color = '#fd7e14';
    } else if (strength === 4) {
        strengthIndicator.classList.add('strength-good');
        strengthText.textContent = 'Baik';
        strengthText.style.color = '#ffc107';
    } else {
        strengthIndicator.classList.add('strength-strong');
        strengthText.textContent = 'Kuat';
        strengthText.style.color = '#28a745';
    }
}

// Check password match
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const errorElement = document.getElementById('password-match-error');
    const successElement = document.getElementById('password-match-success');
    const confirmInput = document.getElementById('password_confirmation');
    
    if (confirmPassword === '') {
        errorElement.style.display = 'none';
        successElement.style.display = 'none';
        confirmInput.classList.remove('error', 'success');
        return;
    }
    
    if (password !== confirmPassword) {
        errorElement.style.display = 'block';
        successElement.style.display = 'none';
        confirmInput.classList.add('error');
        confirmInput.classList.remove('success');
    } else {
        errorElement.style.display = 'none';
        successElement.style.display = 'block';
        confirmInput.classList.remove('error');
        confirmInput.classList.add('success');
    }
}

// Form submission handling
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('change-password-form');
    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');
    
    form.addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Password baru dan konfirmasi password tidak cocok!');
            return;
        }
        
        submitBtn.disabled = true;
        submitText.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i>Mengubah...';
    });
    
    // Auto-hide success message
    const successMessage = document.getElementById('success-message');
    if (successMessage) {
        setTimeout(function() {
            successMessage.style.opacity = '0';
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 300);
        }, 5000);
    }
    
    // Input validation feedback
    document.querySelectorAll('.change-password-input').forEach(function(input) {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.id !== 'password_confirmation') {
                this.classList.remove('error');
            }
        });
    });
});
</script>
@endsection