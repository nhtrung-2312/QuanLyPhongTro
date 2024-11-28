@extends('Layout.client')
@section('title', 'Thanh toán')
@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Thanh toán</h2>
                    <div class="bt-option">
                        <a href="{{ route('home.index') }}">Trang chủ</a>
                        <span>Thanh toán</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="payment-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="payment-info">
                    <h3>Thông tin thanh toán</h3>
                    <div class="payment-details">
                        <p>Phòng: {{ $phong->TenPhong }}</p>
                        <p>Giá thuê: {{ number_format($phong->GiaThue) }} VNĐ/tháng</p>
                        <!-- Thêm các thông tin thanh toán khác -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
