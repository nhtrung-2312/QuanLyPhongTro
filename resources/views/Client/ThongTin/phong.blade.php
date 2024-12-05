@extends('Layout.client')
@section('title', 'Thông tin phòng')
@section('content')
<div class="breadcrumb-section" style="padding-bottom: 5px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Thông tin phòng</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="payment-section spad-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-3" style="border-right: 1px solid #e5e5e5;">
                <nav class="mainmenu">
                    <ul style="display: block; padding: 0;">
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/thong-tin-ca-nhan') }}" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-user"></i> Thông tin cá nhân</a></li>
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/cap-nhat-tai-khoan') }}" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-key"></i> Chỉnh sửa tài khoản</a></li>
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/lich-su-hoa-don') }}" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-history"></i> Lịch sử hoá đơn</a></li>
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/thong-tin-phong') }}" class="active" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-home"></i> Thông tin phòng</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-9">
                @if(count($phongs) > 0)
                    @foreach($phongs as $phong)
                    @php
                        echo "<script>console.log(" . json_encode($phong) . ");</script>";
                    @endphp
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5><a style="color: inherit; text-decoration: none;">{{ $phong['phong']->TenPhong }} - {{ $phong['coso']->TenCoSo }}</a></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-3">Thông tin phòng:</h6>
                                    <p><strong>Loại phòng:</strong> {{ $phong['loaiphong']->LoaiPhong }}</p>
                                    <p><strong>Diện tích:</strong> {{ $phong['phong']->loaiPhong->DienTich }}m²</p>
                                    <p><strong>Giá thuê:</strong> {{ number_format($phong['phong']->GiaThue, 0, ',', '.') }}đ</p>
                                    <p><strong>Trạng thái:</strong> <span class="badge badge-lg {{ $phong['hopdongthue']->TrangThai == 'Chờ thanh toán cọc' ? 'badge-warning' : ($phong['hopdongthue']->TrangThai == 'Đã thanh toán cọc' ? 'badge-success' : 'badge-secondary') }}" style="font-size: 14px; padding: 8px 12px;">{{ $phong['hopdongthue']->TrangThai }}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-3">Thời hạn hợp đồng:</h6>
                                    @php
                                        $hopDong = $phong['hopdongthue'];
                                        if($hopDong) {
                                            $ngayHienTai = \Carbon\Carbon::parse($hopDong->NgayBatDau);
                                            $ngayKetThuc = \Carbon\Carbon::parse($hopDong->NgayKetThuc);
                                            if($ngayHienTai->lte($ngayKetThuc)) {
                                                $ngayConLai = $ngayHienTai->diffInDays($ngayKetThuc) . ' ngày';
                                            } else {
                                                $ngayConLai = 'Đã hết hợp đồng';
                                            }
                                        }
                                    @endphp
                                    @if($hopDong)
                                        <p><strong>Ngày bắt đầu:</strong> {{ date('d/m/Y', strtotime($hopDong->NgayBatDau)) }}</p>
                                        <p><strong>Ngày kết thúc:</strong> {{ date('d/m/Y', strtotime($hopDong->NgayKetThuc)) }}</p>
                                        <p><strong>Thời gian còn lại:</strong> {{ $ngayConLai }} </p>
                                        @if($phong['hopdongthue']->TrangThai == 'Chờ thanh toán cọc')
                                            <a href="{{ route('thanhToan.datphong', $phong['phong']->MaPhong) }}" class="btn btn-primary">Thanh toán tiền cọc</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#danhSachNguoiO{{ $loop->index }}" aria-expanded="false">
                                    <h6 class="mb-3"><i class="fa fa-chevron-down"></i> Danh sách người ở</h6>
                                </button>
                                @if($hopDong && $hopDong->chitiethopdong->count() > 0)
                                    <div class="collapse" id="danhSachNguoiO{{ $loop->index }}">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Họ tên</th>
                                                        <th>CCCD</th>
                                                        <th>Số điện thoại</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($hopDong->chitiethopdong as $chitiet)
                                                    <tr>
                                                        <td>{{ $chitiet->khachthue->HoTen }}</td>
                                                        <td>{{ $chitiet->khachthue->CCCD }}</td>
                                                        <td>{{ $chitiet->khachthue->SDT }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="alert alert-info">
                        Bạn chưa thuê phòng nào.
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
