@extends('layout.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .checkout-container {
        padding: 2rem 0;
        min-height: 80vh;
        background: #f8f9fa;
    }

    .checkout-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 30px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #422D1C;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #EFA942;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #EFA942;
        box-shadow: 0 0 0 0.2rem rgba(239, 169, 66, 0.25);
    }

    .product-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 1rem;
    }

    .product-info {
        flex: 1;
    }

    .product-name {
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.25rem;
    }

    .product-specs {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .product-price {
        font-weight: 600;
        color: #422D1C;
    }

    .summary-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        position: sticky;
        top: 2rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .summary-row.total {
        font-weight: 600;
        font-size: 1.1rem;
        color: #422D1C;
        border-top: 2px solid #dee2e6;
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .shipping-option {
        border: 2px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .shipping-option:hover {
        border-color: #EFA942;
        background: rgba(239, 169, 66, 0.05);
    }

    .shipping-option.selected {
        border-color: #EFA942;
        background: rgba(239, 169, 66, 0.1);
    }

    .shipping-option input[type="radio"] {
        margin-right: 0.75rem;
    }

    .courier-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .courier-name {
        font-weight: 600;
        color: #212529;
    }

    .courier-service {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .courier-cost {
        font-weight: 600;
        color: #422D1C;
    }

    .courier-etd {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .btn-checkout {
        background: linear-gradient(135deg, #EFA942 0%, #8B4513 100%);
        border: none;
        color: white;
        padding: 1rem 2rem;
        border-radius: 8px;
        width: 100%;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(66, 45, 28, 0.3);
        color: white;
    }

    .btn-checkout:disabled {
        background: #6c757d;
        cursor: not-allowed;
        transform: none;
    }

    .btn-primary {
        background: #007bff;
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover:not(:disabled) {
        background: #0056b3;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
    }

    .btn-primary:disabled {
        background: #6c757d;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.15em;
    }

    .loading-spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid #ffffff;
        border-top: 2px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 0.5rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .alert {
        border-radius: 8px;
        padding: 1rem 1.25rem;
    }

    .payment-methods {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .payment-option {
        border: 2px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-option:hover {
        border-color: #EFA942;
        background: rgba(239, 169, 66, 0.05);
    }

    .payment-option.selected {
        border-color: #EFA942;
        background: rgba(239, 169, 66, 0.1);
    }

    .payment-option input[type="radio"] {
        margin-bottom: 0.5rem;
    }

    .payment-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .payment-label {
        font-weight: 500;
        color: #212529;
    }

    @media (max-width: 768px) {
        .checkout-container {
            padding: 1rem 0;
        }
        
        .checkout-card {
            padding: 1.5rem;
        }
        
        .product-item {
            flex-direction: column;
            text-align: center;
        }
        
        .product-image {
            margin-right: 0;
            margin-bottom: 1rem;
        }
        
        .summary-card {
            position: static;
        }

        .payment-methods {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="checkout-container">
    <div class="container">
        <!-- Header -->
        <div class="checkout-card">
            <div class="checkout-header">
                <div class="checkout-step">
                    <div class="step-number">1</div>
                    <h4 class="mb-0">Checkout Pesanan Anda</h4>
                </div>
                <p class="mb-0">Lengkapi informasi pengiriman untuk melanjutkan ke pembayaran</p>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            
            <div class="row">
                <!-- Form Checkout -->
                <div class="col-lg-8">
                    <div class="checkout-card">
                        <div class="form-section">
                            <!-- Informasi Pengiriman -->
                            <h5 class="section-title">📦 Informasi Pengiriman</h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shipping_name">Nama Lengkap *</label>
                                        <input type="text" class="form-control" id="shipping_name" 
                                               name="shipping_name" value="{{ old('shipping_name', Auth::user()->name ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shipping_phone">Nomor Telepon *</label>
                                      <input type="text" 
                                        name="shipping_phone" 
                                        value="{{ old('shipping_phone', Auth::user()->phone ?? '') }}" 
                                        required 
                                        class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" name="shipping_email" 
                                   value="{{ $user->email ?? '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap *</label>
                            <textarea class="form-control" name="shipping_address" rows="3" required 
                                      placeholder="Nama jalan, nomor rumah, RT/RW, dll"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Provinsi *</label>
                                <select class="form-select" id="province" name="shipping_province" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kota/Kabupaten *</label>
                                <select class="form-select" id="city" name="shipping_city" required disabled>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kecamatan *</label>
                                <select class="form-select" id="district" name="shipping_district" required disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Pos *</label>
                                <input type="text" class="form-control" name="shipping_postal_code" 
                                       placeholder="Contoh: 12345" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" name="notes" rows="2" 
                                      placeholder="Catatan tambahan untuk pengiriman"></textarea>
                        </div>

                        <!-- Hidden inputs for location IDs and names -->
                        <input type="hidden" id="district_id" name="district_id">
                        <input type="hidden" id="province_name" name="province_name">
                        <input type="hidden" id="city_name" name="city_name">
                        <input type="hidden" id="district_name" name="district_name">
                        <input type="hidden" id="total_weight" name="total_weight" value="{{ $totalWeight }}">
                        
                        <!-- Hidden inputs for checkout -->
                        <input type="hidden" name="total_amount" id="total_amount_input" value="{{ $total }}">
                        <input type="hidden" id="shipping_cost_input" name="shipping_cost" value="0">
                        <input type="hidden" id="courier_name_input" name="courier_name" value="">
                        <input type="hidden" id="courier_service_input" name="courier_service" value="">
                        <input type="hidden" name="payment_method" id="payment_method_input" value="midtrans">
                        
                        <!-- Hidden inputs for items -->
                        @foreach($checkoutItems as $index => $item)
                        <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item['product']->id }}">
                        <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] }}">
                        <input type="hidden" name="items[{{ $index }}][size]" value="{{ $item['size'] }}">
                        @endforeach
                    </form>
                </div>

                <!-- Pilih Kurir -->
                <div class="checkout-card" id="courierSection" style="display: none;">
                    <h5 class="section-title">🚚 Pilih Kurir Pengiriman</h5>
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Pilih Kurir</label>
                            <select class="form-select" id="courierSelect">
                                <option value="">Pilih Kurir</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="tiki">TIKI</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-primary w-100" id="calculateShippingBtn" disabled>
                                📦 Cek Ongkir
                            </button>
                        </div>
                    </div>

                    <div id="shippingOptions" style="display: none;">
                        <label class="form-label">Pilih Layanan</label>
                        <div id="shippingOptionsList"></div>
                    </div>

                    <div id="courierLoading" class="text-center" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Mengambil data ongkir...</p>
                    </div>

                    <div id="courierError" class="alert alert-danger" style="display: none;"></div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="checkout-card">
                    <h5 class="section-title">💳 Metode Pembayaran</h5>
                    <div class="payment-methods">
                        <div class="payment-option" onclick="selectPayment('midtrans')">
                            <input type="radio" name="payment_method" value="midtrans" id="payment_midtrans" checked>
                            <div class="payment-icon">💳</div>
                            <div class="payment-label">Midtrans</div>
                            <small class="text-muted">Credit/Debit, VA, E-Wallet</small>
                        </div>
                        <div class="payment-option" onclick="selectPayment('bank_transfer')">
                            <input type="radio" name="payment_method" value="bank_transfer" id="payment_bank">
                            <div class="payment-icon">🏦</div>
                            <div class="payment-label">Transfer Bank</div>
                            <small class="text-muted">Manual Transfer</small>
                        </div>
                        <div class="payment-option" onclick="selectPayment('cod')">
                            <input type="radio" name="payment_method" value="cod" id="payment_cod">
                            <div class="payment-icon">💵</div>
                            <div class="payment-label">COD</div>
                            <small class="text-muted">Cash on Delivery</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Pesanan -->
            <div class="col-lg-4">
                <div class="summary-card">
                    <h5 class="section-title">📦 Ringkasan Pesanan</h5>
                    
                    <!-- Products List -->
                    <div class="mb-3">
                        @foreach($checkoutItems as $item)
                        <div class="product-item">
                            <img src="{{ $item['product']->images->first()->image_path ?? 'https://via.placeholder.com/80' }}" 
                                 alt="{{ $item['product']->name }}" class="product-image">
                            <div class="product-info">
                                <div class="product-name">{{ $item['product']->name }}</div>
                                <div class="product-specs">
                                    Ukuran: {{ $item['size'] }} | Qty: {{ $item['quantity'] }}
                                </div>
                            </div>
                            <div class="product-price">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Summary -->
                    <div class="summary-row">
                        <span>Subtotal ({{ count($checkoutItems) }} item)</span>
                        <span id="subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Berat Total</span>
                        <span>{{ number_format($totalWeight, 0, ',', '.') }} gram</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        <span id="shipping-cost">Rp 0</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total Pembayaran</span>
                        <span id="grand-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="button" class="btn-checkout mt-3" id="checkoutBtn" disabled>
                        Pilih Alamat & Kurir Terlebih Dahulu
                    </button>

                    <div class="alert alert-info mt-3">
                        <small>
                            <strong>ℹ️ Info:</strong><br>
                            Pastikan alamat pengiriman sudah benar sebelum melakukan pembayaran.
                        </small>
                    </div>
                </div>
            </div>
</form>
        </div>
    </div>
</div>

<script>
let provinces = [];
let cities = [];
let districts = [];
let selectedDistrictId = null;
let selectedShippingCost = 0;
let selectedCourierName = '';
let selectedCourierService = '';
const subtotal = {{ $total }};
const totalWeight = {{ $totalWeight }};

document.addEventListener('DOMContentLoaded', function() {
    loadProvinces();
    initializePaymentSelection();
});

// Load Provinces
async function loadProvinces() {
    console.log('Loading provinces...'); // Debug
    try {
        const response = await fetch('/rajaongkir/provinces');
        console.log('Province response:', response); // Debug
        const data = await response.json();
        console.log('Province data:', data); // Debug
        
        if (data.success) {
            provinces = data.data;
            const provinceSelect = document.getElementById('province');
            
            provinces.forEach(province => {
                const option = document.createElement('option');
                option.value = province.id;
                option.textContent = province.name;
                option.setAttribute('data-name', province.name);
                provinceSelect.appendChild(option);
            });
            console.log('Provinces loaded:', provinces.length); // Debug
        } else {
            console.error('Failed to load provinces:', data);
        }
    } catch (error) {
        console.error('Error loading provinces:', error);
        alert('Gagal memuat data provinsi. Silakan refresh halaman.');
    }
}

// Province Change
document.getElementById('province').addEventListener('change', async function() {
    const provinceId = this.value;
    const selectedOption = this.options[this.selectedIndex];
    const provinceName = selectedOption.getAttribute('data-name') || selectedOption.textContent;
    const citySelect = document.getElementById('city');
    const districtSelect = document.getElementById('district');
    
    console.log('Province changed:', provinceId, provinceName); // Debug
    
    // Store province name
    document.getElementById('province_name').value = provinceName || '';
    
    // Reset subsequent selects
    citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
    citySelect.disabled = true;
    districtSelect.disabled = true;
    document.getElementById('courierSection').style.display = 'none';
    
    if (!provinceId) return;
    
    try {
        console.log('Fetching cities for province:', provinceId); // Debug
        const response = await fetch(`/rajaongkir/cities/${provinceId}`);
        console.log('Cities response:', response); // Debug
        const data = await response.json();
        console.log('Cities data:', data); // Debug
        
        if (data.success) {
            cities = data.data;
            data.data.forEach(city => {
                const option = document.createElement('option');
                option.value = city.id;
                option.textContent = city.name;
                option.setAttribute('data-name', city.name);
                citySelect.appendChild(option);
            });
            citySelect.disabled = false;
            console.log('Cities loaded:', cities.length); // Debug
        } else {
            console.error('Failed to load cities:', data);
            alert('Gagal memuat data kota. Silakan coba lagi.');
        }
    } catch (error) {
        console.error('Error loading cities:', error);
        alert('Gagal memuat data kota. Silakan coba lagi.');
    }
});

// City Change
document.getElementById('city').addEventListener('change', async function() {
    const cityId = this.value;
    const selectedOption = this.options[this.selectedIndex];
    const cityName = selectedOption.getAttribute('data-name') || selectedOption.textContent;
    const districtSelect = document.getElementById('district');
    
    console.log('City changed:', cityId, cityName); // Debug
    
    // Store city name
    document.getElementById('city_name').value = cityName || '';
    
    // Reset district
    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
    districtSelect.disabled = true;
    document.getElementById('courierSection').style.display = 'none';
    
    if (!cityId) return;
    
    try {
        console.log('Fetching districts for city:', cityId); // Debug
        const response = await fetch(`/rajaongkir/districts/${cityId}`);
        console.log('Districts response:', response); // Debug
        const data = await response.json();
        console.log('Districts data:', data); // Debug
        
        if (data.success) {
            districts = data.data;
            data.data.forEach(district => {
                const option = document.createElement('option');
                option.value = district.id;
                option.textContent = district.name;
                option.setAttribute('data-name', district.name);
                districtSelect.appendChild(option);
            });
            districtSelect.disabled = false;
            console.log('Districts loaded:', districts.length); // Debug
        } else {
            console.error('Failed to load districts:', data);
            alert('Gagal memuat data kecamatan. Silakan coba lagi.');
        }
    } catch (error) {
        console.error('Error loading districts:', error);
        alert('Gagal memuat data kecamatan. Silakan coba lagi.');
    }
});

// District Change
document.getElementById('district').addEventListener('change', function() {
    selectedDistrictId = this.value;
    const selectedOption = this.options[this.selectedIndex];
    const districtName = selectedOption.getAttribute('data-name') || selectedOption.textContent;
    
    console.log('District changed:', selectedDistrictId, districtName); // Debug
    
    document.getElementById('district_id').value = selectedDistrictId;
    document.getElementById('district_name').value = districtName || '';
    
    if (selectedDistrictId && selectedDistrictId !== '') {
        console.log('Showing courier section'); // Debug
        const courierSection = document.getElementById('courierSection');
        courierSection.style.display = 'block';
        
        // Scroll to courier section
        setTimeout(() => {
            courierSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 100);
        
        document.getElementById('courierSelect').value = '';
        document.getElementById('shippingOptions').style.display = 'none';
        document.getElementById('calculateShippingBtn').disabled = true;
        
        // Reset shipping selection
        selectedShippingCost = 0;
        selectedCourierName = '';
        selectedCourierService = '';
        document.getElementById('shipping_cost_input').value = 0;
        document.getElementById('courier_name_input').value = '';
        document.getElementById('courier_service_input').value = '';
        document.getElementById('shipping-cost').textContent = 'Rp 0';
        document.getElementById('grand-total').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
        
        updateCheckoutButton();
    } else {
        console.log('Hiding courier section - no district selected'); // Debug
        document.getElementById('courierSection').style.display = 'none';
    }
});

// Courier Select - Enable calculate button
document.getElementById('courierSelect').addEventListener('change', function() {
    const courier = this.value;
    const calculateBtn = document.getElementById('calculateShippingBtn');
    
    if (courier && selectedDistrictId) {
        calculateBtn.disabled = false;
    } else {
        calculateBtn.disabled = true;
    }
    
    // Reset shipping options when courier changed
    document.getElementById('shippingOptions').style.display = 'none';
    document.getElementById('courierError').style.display = 'none';
});

// Calculate Shipping Button
document.getElementById('calculateShippingBtn').addEventListener('click', async function() {
    const courier = document.getElementById('courierSelect').value;
    const btn = this;
    const originalText = btn.innerHTML;
    
    if (!courier || !selectedDistrictId) {
        alert('Silakan pilih kurir terlebih dahulu');
        return;
    }
    
    // Show loading
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Mengecek...';
    document.getElementById('courierLoading').style.display = 'block';
    document.getElementById('shippingOptions').style.display = 'none';
    document.getElementById('courierError').style.display = 'none';
    
    try {
        console.log('Checking ongkir with params:', {
            destination_district_id: selectedDistrictId,
            weight: totalWeight,
            courier: courier
        });
        
        const response = await fetch('/rajaongkir/check-ongkir', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                destination_district_id: selectedDistrictId,
                weight: totalWeight,
                courier: courier
            })
        });
        
        console.log('Ongkir response status:', response.status);
        const data = await response.json();
        console.log('Ongkir response data:', data);
        
        if (data.success && data.data) {
            // Check if data is array and has items
            if (Array.isArray(data.data) && data.data.length > 0) {
                displayShippingOptions(data.data, courier);
            } else {
                throw new Error('Tidak ada layanan pengiriman tersedia untuk kurir ini');
            }
        } else {
            throw new Error(data.message || 'Tidak ada layanan tersedia');
        }
    } catch (error) {
        console.error('Error checking ongkir:', error);
        document.getElementById('courierError').textContent = error.message || 'Gagal mengambil data ongkir. Silakan coba lagi.';
        document.getElementById('courierError').style.display = 'block';
    } finally {
        document.getElementById('courierLoading').style.display = 'none';
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
});

// Display Shipping Options
function displayShippingOptions(courierData, courierName) {
    console.log('=== DISPLAY SHIPPING OPTIONS ===');
    console.log('Courier Name:', courierName);
    console.log('Courier Data:', JSON.stringify(courierData, null, 2));
    
    const optionsList = document.getElementById('shippingOptionsList');
    optionsList.innerHTML = '';
    
    // Validate data structure
    if (!courierData) {
        console.error('Courier data is null or undefined');
        document.getElementById('courierError').textContent = 'Data pengiriman tidak tersedia';
        document.getElementById('courierError').style.display = 'block';
        return;
    }
    
    // Ensure data is array
    let dataArray = Array.isArray(courierData) ? courierData : [courierData];
    
    console.log('Processing', dataArray.length, 'courier(s)');
    
    let hasOptions = false;
    
    dataArray.forEach((item, index) => {
        console.log(`\nProcessing item ${index}:`, item);
        
        let costValue = null;
        let costService = null;
        let costDescription = null;
        let costEtd = null;
        
        // Check if this is a direct cost object (flat structure)
        if (item.cost && typeof item.cost === 'number') {
            costValue = item.cost;
            costService = item.service || 'Standard';
            costDescription = item.description || item.service;
            costEtd = item.etd || 'N/A';
        }
        // Check if there's a nested costs array
        else if (item.costs && Array.isArray(item.costs)) {
            // Process each cost in the costs array
            item.costs.forEach((cost, costIndex) => {
                console.log(`  Cost ${costIndex}:`, cost);
                
                let itemCostValue = null;
                let itemCostService = null;
                let itemCostDescription = null;
                let itemCostEtd = null;
                
                // Pattern 1: Direct cost value
                if (cost.cost && typeof cost.cost === 'number') {
                    itemCostValue = cost.cost;
                    itemCostService = cost.service || 'Standard';
                    itemCostDescription = cost.description || cost.service;
                    itemCostEtd = cost.etd || 'N/A';
                }
                // Pattern 2: Nested cost array
                else if (cost.cost && Array.isArray(cost.cost) && cost.cost.length > 0) {
                    itemCostValue = cost.cost[0].value;
                    itemCostService = cost.service || 'Standard';
                    itemCostDescription = cost.description || cost.service;
                    itemCostEtd = cost.cost[0].etd || 'N/A';
                }
                
                if (itemCostValue) {
                    createShippingOption(
                        optionsList,
                        courierName,
                        itemCostService,
                        itemCostDescription,
                        itemCostValue,
                        itemCostEtd
                    );
                    hasOptions = true;
                }
            });
            
            return; // Skip the rest since we processed costs array
        }
        // Check if there's a nested cost array (old structure)
        else if (item.cost && Array.isArray(item.cost) && item.cost.length > 0) {
            costValue = item.cost[0].value;
            costService = item.service || 'Standard';
            costDescription = item.description || item.service;
            costEtd = item.cost[0].etd || 'N/A';
        }
        
        if (!costValue) {
            console.warn('Cannot find cost value in item:', item);
            return;
        }
        
        console.log('✓ Valid cost:', {
            value: costValue,
            service: costService,
            description: costDescription,
            etd: costEtd
        });
        
        createShippingOption(
            optionsList,
            courierName,
            costService,
            costDescription,
            costValue,
            costEtd
        );
        
        hasOptions = true;
    });
    
    console.log('\n=== RESULT ===');
    console.log('Has Options:', hasOptions);
    
    if (hasOptions) {
        document.getElementById('shippingOptions').style.display = 'block';
        console.log('✓ Shipping options displayed successfully');
    } else {
        document.getElementById('courierError').textContent = 'Tidak ada layanan pengiriman tersedia untuk kurir ini.';
        document.getElementById('courierError').style.display = 'block';
        console.error('✗ No shipping options available');
    }
}

// Helper function to create shipping option element
function createShippingOption(container, courierName, service, description, value, etd) {
    const option = document.createElement('div');
    option.className = 'shipping-option';
    option.onclick = () => selectShipping(
        parseInt(value), 
        courierName.toUpperCase(), 
        service, 
        description, 
        option
    );
    
    option.innerHTML = `
        <input type="radio" name="shipping_option" value="${service}">
        <div class="courier-info">
            <div>
                <div class="courier-name">${courierName.toUpperCase()} - ${service}</div>
                <div class="courier-service">${description}</div>
                <div class="courier-etd">Estimasi: ${etd} hari</div>
            </div>
            <div>
                <div class="courier-cost">Rp ${parseInt(value).toLocaleString('id-ID')}</div>
            </div>
        </div>
    `;
    
    container.appendChild(option);
}

// Select Shipping
function selectShipping(cost, courierName, service, description, element) {
    // Remove previous selection
    document.querySelectorAll('.shipping-option').forEach(opt => {
        opt.classList.remove('selected');
    });
    
    // Add selection to clicked element
    element.classList.add('selected');
    element.querySelector('input[type="radio"]').checked = true;
    
    // Update values
    selectedShippingCost = cost;
    selectedCourierName = courierName;
    selectedCourierService = `${service} - ${description}`;
    
    // Update hidden inputs
    document.getElementById('shipping_cost_input').value = cost;
    document.getElementById('courier_name_input').value = courierName;
    document.getElementById('courier_service_input').value = selectedCourierService;
    
    // Update summary
    document.getElementById('shipping-cost').textContent = `Rp ${cost.toLocaleString('id-ID')}`;
    const grandTotal = subtotal + cost;
    document.getElementById('grand-total').textContent = `Rp ${grandTotal.toLocaleString('id-ID')}`;
    
    updateCheckoutButton();
}

// Payment Selection
function selectPayment(method) {
    document.querySelectorAll('.payment-option').forEach(opt => {
        opt.classList.remove('selected');
    });
    
    event.currentTarget.classList.add('selected');
    document.getElementById('payment_' + method).checked = true;
    document.getElementById('payment_method_input').value = method;
    
    updateCheckoutButton();
}

function initializePaymentSelection() {
    // Set default to midtrans
    document.querySelector('.payment-option').classList.add('selected');
    document.getElementById('payment_midtrans').checked = true;
    document.getElementById('payment_method_input').value = 'midtrans';
}

// Update Checkout Button
function updateCheckoutButton() {
    const btn = document.getElementById('checkoutBtn');
    const hasAddress = document.getElementById('district').value !== '';
    const hasShipping = selectedShippingCost > 0;
    const hasPayment = document.querySelector('input[name="payment_method"]:checked') !== null;
    
    if (hasAddress && hasShipping && hasPayment) {
        btn.disabled = false;
        btn.textContent = 'Lanjutkan ke Pembayaran';
    } else {
        btn.disabled = true;
        if (!hasAddress) {
            btn.textContent = 'Pilih Alamat Terlebih Dahulu';
        } else if (!hasShipping) {
            btn.textContent = 'Pilih Kurir Terlebih Dahulu';
        } else if (!hasPayment) {
            btn.textContent = 'Pilih Metode Pembayaran';
        }
    }
}

// Checkout Button Click - INI YANG DIPERBAIKI
document.getElementById('checkoutBtn').addEventListener('click', async function() {
    const btn = this;
    const originalText = btn.textContent;
    
    // PERBAIKAN: Ubah dari 'checkoutForm' menjadi 'checkout-form'
    const form = document.getElementById('checkout-form');
    
    if (!form) {
        console.error('Form tidak ditemukan!');
        alert('Terjadi kesalahan: Form tidak ditemukan. Silakan refresh halaman.');
        return;
    }
    
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Validate shipping selection
    if (!selectedShippingCost || selectedShippingCost <= 0) {
        alert('Silakan pilih layanan pengiriman terlebih dahulu');
        return;
    }
    
    // Validate payment method
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    if (!paymentMethod) {
        alert('Silakan pilih metode pembayaran');
        return;
    }
    
    // Update hidden inputs to ensure they're set
    document.getElementById('total_amount_input').value = subtotal;
    document.getElementById('shipping_cost_input').value = selectedShippingCost;
    document.getElementById('courier_name_input').value = selectedCourierName;
    document.getElementById('courier_service_input').value = selectedCourierService;
    document.getElementById('payment_method_input').value = paymentMethod.value;
    document.getElementById('province_name').value = document.getElementById('province').options[document.getElementById('province').selectedIndex].text;
    document.getElementById('city_name').value = document.getElementById('city').options[document.getElementById('city').selectedIndex].text;
    document.getElementById('district_name').value = document.getElementById('district').options[document.getElementById('district').selectedIndex].text;
    
    // Disable button and show loading
    btn.disabled = true;
    btn.innerHTML = '<span class="loading-spinner"></span>Memproses...';
    
    try {
        // Create FormData from form
        const formData = new FormData(form);
        
        // Double check critical fields are set
        if (!formData.get('total_amount')) {
            formData.set('total_amount', subtotal);
        }
        if (!formData.get('shipping_cost')) {
            formData.set('shipping_cost', selectedShippingCost);
        }
        if (!formData.get('courier_name')) {
            formData.set('courier_name', selectedCourierName);
        }
        if (!formData.get('courier_service')) {
            formData.set('courier_service', selectedCourierService);
        }
        if (!formData.get('payment_method')) {
            formData.set('payment_method', paymentMethod.value);
        }
        
        // Ensure province, city, district names (not IDs)
        if (!formData.get('shipping_province') || formData.get('shipping_province') === '') {
            const provinceSelect = document.getElementById('province');
            formData.set('shipping_province', provinceSelect.options[provinceSelect.selectedIndex].text);
        }
        if (!formData.get('shipping_city') || formData.get('shipping_city') === '') {
            const citySelect = document.getElementById('city');
            formData.set('shipping_city', citySelect.options[citySelect.selectedIndex].text);
        }
        if (!formData.get('shipping_district') || formData.get('shipping_district') === '') {
            const districtSelect = document.getElementById('district');
            formData.set('shipping_district', districtSelect.options[districtSelect.selectedIndex].text);
        }
        
        console.log('=== CHECKOUT DATA ===');
        console.log('Subtotal:', subtotal);
        console.log('Shipping Cost:', selectedShippingCost);
        console.log('Grand Total:', subtotal + selectedShippingCost);
        console.log('Payment Method:', paymentMethod.value);
        console.log('Courier:', selectedCourierName, '-', selectedCourierService);
        
        // Log all form data
        console.log('\nForm Data being sent:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        // Submit to server
        const response = await fetch('{{ route('checkout.process') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        });
        
        console.log('Response status:', response.status);
        const data = await response.json();
        console.log('Response data:', data);
        
        if (data.success) {
            console.log('✓ Checkout successful, redirecting to:', data.redirect_url);
            // Redirect to order page
            window.location.href = data.redirect_url;
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
        
    } catch (error) {
        console.error('Checkout error:', error);
        
        let errorMessage = 'Terjadi kesalahan: ' + error.message;
        
        // Try to parse more detailed error
        if (error.message.includes('required')) {
            errorMessage = 'Data tidak lengkap. ' + error.message + '\n\nSilakan periksa semua field sudah terisi dengan benar.';
        }
        
        alert(errorMessage);
        
        // Restore button
        btn.disabled = false;
        btn.textContent = originalText;
    }
});
</script>
@endsection