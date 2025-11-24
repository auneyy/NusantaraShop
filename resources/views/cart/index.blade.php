@extends('layout.app')

@section('content')
<style>
    /* ===== VARIABLES & RESET ===== */
    :root {
        --primary-brown: #8B4513;
        --dark-brown: #422D1C;
        --light-brown: #A0522D;
        --success: #28a745;
        --danger: #dc3545;
        --warning: #ffc107;
        --info: #17a2b8;
        --light: #f8f9fa;
        --dark: #343a40;
        --gray: #6c757d;
        --border: #e9ecef;
        --shadow: 0 1px 3px rgba(0,0,0,0.1);
        --radius: 8px;
    }
    body {
    background-color: #f8f9fa;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

    /* ===== MAIN CONTAINER ===== */
    .cart-container {
        padding: 2rem 0;
        min-height: 80vh;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
    }

    .col-lg-8 {
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
        padding: 0 15px;
    }

    .col-lg-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
        padding: 0 15px;
    }

    /* ===== CART MAIN SECTION ===== */
    .cart-main-section {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 0;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .cart-header-simple {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border);
        background: white;
    }

    .cart-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 0.25rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .cart-title i {
        color: var(--primary-brown);
    }

    .cart-item-count {
        color: var(--gray);
        font-size: 0.9rem;
        margin: 0;
        font-weight: 500;
    }

    /* ===== CART TABLE ===== */
    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .cart-table-header {
        background-color: var(--light);
        border-bottom: 2px solid var(--border);
    }

    .cart-table-header th {
        padding: 1rem 1.5rem;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.85rem;
        text-align: left;
        border: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cart-table-header th:first-child {
        width: 40%;
    }

    .cart-table-header th:nth-child(2) {
        width: 15%;
        text-align: center;
    }

    .cart-table-header th:nth-child(3) {
        width: 15%;
        text-align: right;
    }

    .cart-table-header th:nth-child(4) {
        width: 20%;
        text-align: right;
    }

    .cart-table-header th:last-child {
        width: 10%;
        text-align: center;
    }

    .cart-item-row {
        border-bottom: 1px solid var(--border);
        transition: all 0.3s ease;
        background: white;
    }

    .cart-item-row:hover {
        background-color: #fafafa;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .cart-item-row:last-child {
        border-bottom: none;
    }

    .cart-item-row td {
        padding: 1.5rem;
        vertical-align: middle;
        border: none;
    }

    /* ===== PRODUCT DETAIL ===== */
    .product-detail {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .product-image-container {
        position: relative;
        flex-shrink: 0;
    }

    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border);
        transition: transform 0.3s ease;
    }

    .product-detail:hover .product-image {
        transform: scale(1.05);
    }

    .product-info {
        flex: 1;
        min-width: 0;
    }

    .product-name {
        font-weight: 600;
        color: var(--dark);
        margin: 0 0 0.5rem 0;
        font-size: 1rem;
        line-height: 1.3;
    }

    .product-name a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .product-name a:hover {
        color: var(--primary-brown);
    }

    .item-details {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .product-meta {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .product-size {
        color: var(--gray);
        font-size: 0.85rem;
        font-weight: 500;
        background: var(--light);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        border: 1px solid var(--border);
    }

    .product-category {
        background: var(--primary-brown);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .discount-badge {
        background: linear-gradient(135deg, var(--success), #20c997);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(40, 167, 69, 0.2);
    }

    .stock-info {
        font-size: 0.8rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stock-ok {
        color: var(--success);
    }

    .stock-warning {
        color: var(--danger);
        font-weight: 600;
    }

    .savings-amount {
        color: var(--success);
        font-size: 0.8rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* ===== QUANTITY SELECTOR ===== */
    .quantity-cell {
        text-align: center;
    }

    .quantity-selector-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border);
        border-radius: 6px;
        overflow: hidden;
        width: fit-content;
        background: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .qty-btn-new {
        background: var(--light);
        border: none;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--dark);
        font-weight: 600;
        transition: all 0.2s ease;
        font-size: 1rem;
    }

    .qty-btn-new:hover:not(:disabled) {
        background: var(--primary-brown);
        color: white;
    }

    .qty-btn-new:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        background: var(--light);
    }

    .qty-display {
        background: white;
        border: none;
        width: 60px;
        height: 36px;
        text-align: center;
        font-weight: 600;
        color: var(--dark);
        border-left: 1px solid var(--border);
        border-right: 1px solid var(--border);
        font-size: 0.9rem;
    }

    .stock-max {
        font-size: 0.75rem;
        color: var(--gray);
        font-weight: 500;
    }

    /* ===== PRICE DISPLAY ===== */
    .price-cell {
        text-align: right;
    }

    .price-detail {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.25rem;
    }

    .original-price {
        text-decoration: line-through;
        color: var(--gray);
        font-size: 0.8rem;
        font-weight: 400;
    }

    .discounted-price {
        color: var(--dark);
        font-weight: 700;
        font-size: 1rem;
    }

    .price-per-item {
        font-size: 0.75rem;
        color: var(--gray);
        font-weight: 500;
    }

    /* ===== TOTAL DISPLAY ===== */
    .total-cell {
        text-align: right;
    }

    .total-detail {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.25rem;
    }

    .item-savings {
        color: var(--success);
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* ===== ACTION BUTTONS ===== */
    .action-cell {
        text-align: center;
    }

    .delete-btn {
        background: none;
        border: none;
        color: var(--danger);
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 6px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        font-weight: 500;
        margin: 0 auto;
    }

    .delete-btn:hover {
        background: #f8d7da;
        transform: scale(1.05);
    }

    /* ===== CONTINUE SHOPPING ===== */
    .cart-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--border);
        background: var(--light);
    }

    .continue-shopping-link {
        color: var(--primary-brown);
        text-decoration: none;
        font-weight: 600;
        padding: 0.75rem 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: 1px solid var(--primary-brown);
        border-radius: 6px;
        background: white;
    }

    .continue-shopping-link:hover {
        background: var(--primary-brown);
        color: white;
        text-decoration: none;
        transform: translateX(-5px);
    }

    /* ===== EMPTY CART ===== */
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--gray);
    }

    .empty-cart-icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
    }

    .empty-cart h4 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: var(--dark);
        font-weight: 600;
    }

    .empty-cart p {
        font-size: 1rem;
        margin-bottom: 2rem;
        color: var(--gray);
    }

    .btn-brown {
        background: linear-gradient(135deg, var(--dark-brown), var(--primary-brown));
        color: white;
        border: none;
        padding: 0.875rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(139, 69, 19, 0.2);
    }

    .btn-brown:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(139, 69, 19, 0.3);
        color: white;
        text-decoration: none;
    }

    /* ===== SUMMARY SECTION ===== */
    .summary-section {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 1.5rem;
        height: fit-content;
        position: sticky;
        top: 2rem;
    }

    .summary-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border);
    }

    .summary-title i {
        color: var(--primary-brown);
    }

    .summary-detail {
        background: var(--light);
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border);
    }

    .summary-detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
    }

    .summary-detail-row:last-child {
        margin-bottom: 0;
    }

    .summary-detail-label {
        color: var(--gray);
        font-weight: 500;
    }

    .summary-detail-value {
        font-weight: 600;
        color: var(--dark);
    }

    .total-savings {
        color: var(--success);
        font-weight: 700;
    }

    .total-section {
        border-top: 2px solid var(--border);
        padding-top: 1.25rem;
        margin-top: 1.25rem;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark);
    }

    .checkout-btn {
        background: linear-gradient(135deg, var(--dark-brown), var(--primary-brown));
        color: white;
        border: none;
        width: 100%;
        padding: 1rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 1.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        box-shadow: 0 4px 12px rgba(139, 69, 19, 0.2);
    }

    .checkout-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(139, 69, 19, 0.3);
        color: white;
        text-decoration: none;
    }

    .checkout-btn:disabled {
        background: var(--gray);
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* ===== ALERTS & NOTIFICATIONS ===== */
    .alert {
        padding: 1rem;
        border-radius: 6px;
        margin: 1rem 0;
        font-size: 0.9rem;
        border: 1px solid transparent;
    }

    .alert-warning {
        background: #fff3cd;
        border-color: #ffeaa7;
        color: #856404;
    }

    .alert-success {
        background: #d1edff;
        border-color: #b3d7ff;
        color: var(--success);
    }

    .alert i {
        margin-right: 0.5rem;
    }

    /* ===== MODERN ALERT STYLES ===== */
    .modern-alert-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .modern-alert-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .modern-alert-box {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transform: scale(0.9) translateY(20px);
        transition: all 0.3s ease;
        text-align: center;
    }

    .modern-alert-overlay.show .modern-alert-box {
        transform: scale(1) translateY(0);
    }

    .alert-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .alert-icon.warning {
        background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
        color: white;
    }

    .alert-icon.success {
        background: linear-gradient(135deg, #51cf66, #69db7c);
        color: white;
    }

    .alert-icon.error {
        background: linear-gradient(135deg, #ff6b6b, #ff5252);
        color: white;
    }

    .alert-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
    }

    .alert-message {
        color: #6c757d;
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }

    .alert-buttons {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }

    .alert-btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.9rem;
        min-width: 100px;
    }

    .alert-btn.primary {
        background: var(--danger);
        color: white;
    }

    .alert-btn.primary:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .alert-btn.secondary {
        background: var(--light);
        color: var(--dark);
        border: 1px solid var(--border);
    }

    .alert-btn.secondary:hover {
        background: var(--border);
        transform: translateY(-2px);
    }

    /* ===== TOAST NOTIFICATION ===== */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
    }

    .toast-notification {
        background: white;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 0.75rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-left: 4px solid var(--success);
        display: flex;
        align-items: center;
        gap: 1rem;
        transform: translateX(400px);
        opacity: 0;
        transition: all 0.3s ease;
        max-width: 350px;
    }

    .toast-notification.show {
        transform: translateX(0);
        opacity: 1;
    }

    .toast-notification.success {
        border-left-color: var(--success);
    }

    .toast-notification.error {
        border-left-color: var(--danger);
    }

    .toast-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        color: white;
        flex-shrink: 0;
    }

    .toast-icon.success {
        background: var(--success);
    }

    .toast-icon.error {
        background: var(--danger);
    }

    .toast-content {
        flex: 1;
    }

    .toast-title {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }

    .toast-message {
        color: var(--gray);
        font-size: 0.8rem;
        line-height: 1.4;
    }

    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 992px) {
        .col-lg-8,
        .col-lg-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        .summary-section {
            position: static;
            margin-top: 2rem;
        }
    }

    @media (max-width: 768px) {
        .cart-container {
            padding: 1rem 0;
        }
        
        .cart-table-header {
            display: none;
        }
        
        .cart-item-row {
            display: block;
            border-bottom: 1px solid var(--border);
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }
        
        .cart-item-row td {
            display: block;
            padding: 0.75rem 0;
            border: none;
            text-align: left !important;
        }
        
        .cart-item-row td::before {
            content: attr(data-label);
            font-weight: 600;
            margin-right: 1rem;
            color: var(--dark);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            min-width: 80px;
        }
        
        .product-detail {
            margin-bottom: 1rem;
        }
        
        .quantity-selector-container {
            align-items: flex-start;
        }
        
        .quantity-selector {
            margin: 0;
        }
        
        .price-detail,
        .total-detail {
            align-items: flex-start;
        }
        
        .delete-btn {
            justify-content: center;
            width: 100%;
            margin-top: 1rem;
        }

        .cart-title {
            font-size: 1.25rem;
        }

        .product-image {
            width: 60px;
            height: 60px;
        }

        .modern-alert-box {
            padding: 1.5rem;
        }

        .toast-container {
            top: 10px;
            right: 10px;
            left: 10px;
        }

        .toast-notification {
            max-width: none;
        }
    }

    @media (max-width: 576px) {
        .product-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .product-detail {
            flex-direction: column;
            text-align: center;
        }
        
        .product-info {
            text-align: center;
        }
        
        .price-detail,
        .total-detail {
            align-items: center;
        }
        
        .alert-buttons {
            flex-direction: column;
        }
        
        .alert-btn {
            width: 100%;
        }
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .cart-item-row {
        animation: fadeIn 0.5s ease;
    }

    .summary-section {
        animation: fadeIn 0.5s ease 0.2s both;
    }

    /* ===== UTILITY CLASSES ===== */
    .text-success {
        color: var(--success) !important;
    }

    .text-danger {
        color: var(--danger) !important;
    }

    .text-warning {
        color: var(--warning) !important;
    }

    .text-muted {
        color: var(--gray) !important;
    }

    .fw-bold {
        font-weight: 700 !important;
    }

    .fw-semibold {
        font-weight: 600 !important;
    }

    .mt-3 {
        margin-top: 1rem !important;
    }

    .mb-2 {
        margin-bottom: 0.5rem !important;
    }

    .d-flex {
        display: flex !important;
    }

    .align-items-center {
        align-items: center !important;
    }

    .justify-content-between {
        justify-content: space-between !important;
    }
</style>

<!-- HTML structure tetap sama seperti sebelumnya -->
<!-- Modern Alert HTML -->
<div class="modern-alert-overlay" id="modernAlert">
    <div class="modern-alert-box">
        <div class="alert-icon warning" id="alertIcon">⚠️</div>
        <h3 class="alert-title" id="alertTitle">Konfirmasi</h3>
        <p class="alert-message" id="alertMessage">Apakah Anda yakin ingin melanjutkan?</p>
        <div class="alert-buttons">
            <button class="alert-btn secondary" id="alertCancel">Batal</button>
            <button class="alert-btn primary" id="alertConfirm">Ya, Hapus</button>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<div class="cart-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-main-section">
                    <div class="cart-header-simple">
                        <h2 class="cart-title">
                            <i class="fas fa-shopping-cart"></i>
                            Keranjang Belanja
                        </h2>
                        <p class="cart-item-count">{{ count($cartItems) }} Item{{ count($cartItems) > 1 ? 's' : '' }}</p>
                    </div>
                    
                    @if(count($cartItems) > 0)
                        <table class="cart-table">
                            <thead class="cart-table-header">
                                <tr>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr class="cart-item-row" id="cart-item-{{ $item['cart_id'] }}">
                                    <td data-label="Produk">
                                        <div class="product-detail">
                                            <div class="product-image-container">
                                                <img src="{{ $item['product']->images->first()->image_path ?? '/images/placeholder.jpg' }}" 
                                                     alt="{{ $item['product']->name }}" class="product-image"
                                                     onerror="this.src='/images/placeholder.jpg'">
                                            </div>
                                            <div class="product-info">
                                                <h4 class="product-name">
                                                    <a href="{{ route('products.show', $item['product']->id) }}">
                                                        {{ $item['product']->name }}
                                                    </a>
                                                </h4>
                                                <div class="item-details">
                                                    <div class="product-meta">
                                                        <span class="product-size">Ukuran: {{ $item['size'] }}</span>
                                                        <span class="product-category">{{ $item['product']->category->name ?? 'Uncategorized' }}</span>
                                                        @if($item['has_discount'])
                                                        <span class="discount-badge">{{ $item['discount_percentage'] }}% OFF</span>
                                                        @endif
                                                    </div>
                                                    <p class="stock-info {{ $item['available_stock'] < $item['quantity'] ? 'stock-warning' : 'stock-ok' }}">
                                                        <i class="fas fa-box"></i>
                                                        Stok: {{ $item['available_stock'] }}
                                                        @if($item['available_stock'] < $item['quantity'])
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                        @endif
                                                    </p>
                                                    @if($item['has_discount'])
                                                    <p class="savings-amount">
                                                        <i class="fas fa-tag"></i>
                                                        Hemat: Rp {{ number_format($item['savings_amount'], 0, ',', '.') }} per item
                                                    </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="quantity-cell" data-label="Jumlah">
                                        <div class="quantity-selector-container">
                                            <div class="quantity-selector">
                                                <button class="qty-btn-new" 
                                                        onclick="updateQuantity('{{ $item['cart_id'] }}', -1)"
                                                        {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="text" class="qty-display" id="qty-{{ $item['cart_id'] }}" 
                                                       value="{{ $item['quantity'] }}" readonly>
                                                <button class="qty-btn-new" 
                                                        onclick="updateQuantity('{{ $item['cart_id'] }}', 1)"
                                                        {{ $item['quantity'] >= $item['available_stock'] ? 'disabled' : '' }}>
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <span class="stock-max">Maks: {{ $item['available_stock'] }}</span>
                                        </div>
                                    </td>
                                    <td class="price-cell" data-label="Harga">
                                        <div class="price-detail">
                                            @if($item['has_discount'])
                                                <span class="original-price">
                                                    Rp {{ number_format($item['original_price'], 0, ',', '.') }}
                                                </span>
                                                <span class="discounted-price">
                                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                </span>
                                            @else
                                                <span class="discounted-price">
                                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                </span>
                                            @endif
                                            <span class="price-per-item">per item</span>
                                        </div>
                                    </td>
                                    <td class="total-cell" data-label="Subtotal">
                                        <div class="total-detail">
                                            @if($item['has_discount'])
                                                <span class="original-price">
                                                    Rp {{ number_format($item['original_subtotal'], 0, ',', '.') }}
                                                </span>
                                                <span class="discounted-price">
                                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                                </span>
                                                <span class="item-savings">
                                                    <i class="fas fa-piggy-bank"></i>
                                                    Hemat: Rp {{ number_format($item['item_savings'], 0, ',', '.') }}
                                                </span>
                                            @else
                                                <span class="discounted-price">
                                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="action-cell" data-label="Aksi">
                                        <button class="delete-btn" onclick="confirmRemoveItem('{{ $item['cart_id'] }}', '{{ $item['product']->name }}')">
                                            <i class="fas fa-trash"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div class="cart-footer">
                            <a href="{{ route('products.index') }}" class="continue-shopping-link">
                                <i class="fas fa-arrow-left"></i>
                                Lanjutkan Belanja
                            </a>
                        </div>
                    @else
                        <div class="empty-cart">
                            <h4>Keranjang Belanja Kosong</h4>
                            <p>Belum ada produk dalam keranjang belanja Anda</p>
                            <a href="{{ route('products.index') }}" class="btn-brown">
                                <i class="fas fa-shopping-bag"></i>
                                Mulai Berbelanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            @if(count($cartItems) > 0)
            <div class="col-lg-4">
                <div class="summary-section">
                    <h3 class="summary-title">
                        <i class="fas fa-receipt"></i>
                        Ringkasan Belanja
                    </h3>
                    
                    <div class="summary-detail">
                        <div class="summary-detail-row">
                            <span class="summary-detail-label">Total Harga Asli:</span>
                            <span class="summary-detail-value">Rp {{ number_format($originalTotal, 0, ',', '.') }}</span>
                        </div>
                        @if($totalSavings > 0)
                        <div class="summary-detail-row">
                            <span class="summary-detail-label">Total Diskon:</span>
                            <span class="summary-detail-value total-savings">- Rp {{ number_format($totalSavings, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="summary-detail-row">
                            <span class="summary-detail-label">Total Item:</span>
                            <span class="summary-detail-value">{{ count($cartItems) }} item</span>
                        </div>
                    </div>
                    
                    <div class="total-section">
                        <div class="total-row">
                            <span>Total Pembayaran:</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    @php
                        $hasInsufficientStock = false;
                        foreach($cartItems as $item) {
                            if($item['available_stock'] < $item['quantity']) {
                                $hasInsufficientStock = true;
                                break;
                            }
                        }
                    @endphp
                    
                    @if($hasInsufficientStock)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <small>Beberapa produk melebihi stok yang tersedia. Silakan perbarui jumlah produk.</small>
                        </div>
                        <button class="checkout-btn" disabled>
                            Periksa Stok Terlebih Dahulu
                        </button>
                    @else
                        <a href="{{ route('checkout.index') }}" class="checkout-btn">
                            <i class="fas fa-credit-card"></i>
                            Lanjut ke Pembayaran
                        </a>
                    @endif
                    
                    @if($totalSavings > 0)
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-tag"></i>
                            <small>Anda hemat Rp {{ number_format($totalSavings, 0, ',', '.') }} dari diskon!</small>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
// Modern Alert Functions
let currentCartId = null;

function showModernAlert(title, message, type = 'warning', onConfirm = null) {
    const overlay = document.getElementById('modernAlert');
    const alertIcon = document.getElementById('alertIcon');
    const alertTitle = document.getElementById('alertTitle');
    const alertMessage = document.getElementById('alertMessage');
    const confirmBtn = document.getElementById('alertConfirm');
    const cancelBtn = document.getElementById('alertCancel');

    const icons = {
        warning: '⚠️',
        success: '✅',
        error: '❌',
        info: 'ℹ️'
    };

    alertIcon.textContent = icons[type] || icons.warning;
    alertIcon.className = `alert-icon ${type}`;
    alertTitle.textContent = title;
    alertMessage.textContent = message;

    overlay.classList.add('show');

    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    
    if (onConfirm) {
        newConfirmBtn.onclick = () => {
            hideModernAlert();
            onConfirm();
        };
    }

    const newCancelBtn = cancelBtn.cloneNode(true);
    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
    newCancelBtn.onclick = hideModernAlert;

    overlay.onclick = (e) => {
        if (e.target === overlay) {
            hideModernAlert();
        }
    };
}

function hideModernAlert() {
    const overlay = document.getElementById('modernAlert');
    overlay.classList.remove('show');
}

function showToast(title, message, type = 'success', duration = 4000) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    
    const icon = type === 'success' ? '✓' : '✗';
    
    toast.innerHTML = `
        <div class="toast-icon ${type}">${icon}</div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
        </div>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('show');
    }, 100);

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if (container.contains(toast)) {
                container.removeChild(toast);
            }
        }, 300);
    }, duration);
}

function confirmRemoveItem(cartId, productName) {
    currentCartId = cartId;
    showModernAlert(
        'Hapus Produk',
        `Apakah Anda yakin ingin menghapus "${productName}" dari keranjang?`,
        'warning',
        () => removeItem(cartId)
    );
}

function updateQuantity(cartId, change) {
    const qtyInput = document.getElementById('qty-' + cartId);
    const currentQty = parseInt(qtyInput.value);
    const newQty = currentQty + change;
    
    if (newQty < 1) return;
    
    const cartItem = document.getElementById('cart-item-' + cartId);
    cartItem.style.opacity = '0.6';
    
    fetch('/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            cart_id: cartId,
            quantity: newQty
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            qtyInput.value = newQty;
            
            // Update item total display
            const itemTotal = document.getElementById('item-total-' + cartId);
            if (itemTotal) {
                itemTotal.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.item_subtotal);
            }
            
            showToast('Berhasil!', 'Jumlah produk berhasil diupdate', 'success', 3000);
            
            // Reload to update all prices and stock info
            setTimeout(() => {
                location.reload();
            }, 500);
        } else {
            showToast('Error!', data.message, 'error');
            cartItem.style.opacity = '1';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error!', 'Terjadi kesalahan saat mengupdate keranjang', 'error');
        cartItem.style.opacity = '1';
    });
}

function removeItem(cartId) {
    fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            cart_id: cartId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const cartItem = document.getElementById('cart-item-' + cartId);
            cartItem.style.transform = 'translateX(-100%)';
            cartItem.style.opacity = '0';
            
            setTimeout(() => {
                cartItem.remove();
                
                if (data.cart_count === 0) {
                    location.reload();
                }
                
                showToast('Berhasil!', 'Produk berhasil dihapus dari keranjang', 'success');
            }, 300);
        } else {
            showToast('Error!', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error!', 'Terjadi kesalahan saat menghapus item', 'error');
    });
}

// Close alert with Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        hideModernAlert();
    }
});
</script>

<!-- Tambahkan Font Awesome untuk icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection