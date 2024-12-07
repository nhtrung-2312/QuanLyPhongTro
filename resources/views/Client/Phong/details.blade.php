@extends('Layout.client')
@section('title', 'Chi tiết phòng')
@section('content')
@if($phong->TrangThai != 'Phòng trống')
    <script>
        window.location.href = '{{ route("phong.show", $phong->MaLoaiPhong) }}';
    </script>
@endif

<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Thông tin phòng</h2>
                    <div class="bt-option">
                        <a href="{{ route('home.index') }}">Home</a>
                        <span>Rooms</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section End -->

<!-- Room Details Section Begin -->
<section class="room-details-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="room-details-item">
                    <img src="{{ file_exists(public_path('template/client/dist/img/phong/' . $phong->MaPhong . '.png'))
                            ? '/template/client/dist/img/phong/' . $phong->MaPhong . '.png'
                            : '/template/client/dist/img/phong/noimage.png' }}"
                    alt="Hình ảnh"
                    width="600"
                    height="300">
                    <hr>
                    <div class="rd-text">
                        <div class="rd-title">
                            <h3>{{ $phong->TenPhong }}</h3>
                            <div class="rdt-right">
                                @if(session()->has('logged_in'))
                                    <a href="#" onclick="handleBooking('{{ $phong->MaPhong }}')" class="primary-btn">Đặt phòng ngay</a>
                                @else
                                    <a href="#" onclick="showLogin()" class="primary-btn">Đặt phòng ngay</a>
                                @endif
                            </div>
                        </div>
                        <h2>{{ number_format($phong->GiaThue, 0, ',', '.') }} đ<span>/Tháng</span></h2>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="r-o">Địa chỉ:</td>
                                    <td>{{ $phong->coSo->DiaChi }}</td>
                                </tr>
                                <tr>
                                    <td class="r-o">Diện tích:</td>
                                    <td>{{ $phong->LoaiPhong->DienTich }} m<sup>2</sup></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="detail-info">
                            <div class="description">
                                <h5 style="margin-bottom:5px;font-weight: bold;">Thông tin phòng trọ</h5>
                                <p style="font-size: 18px;color: #333;">
                                    Phòng trọ: {{ $phong->LoaiPhong->LoaiPhong }}, {{ $phong->MoTa }}. <br>
                                    Sức chứa: Tối đa {{ $phong->LoaiPhong->SoNguoi }} người. <br>
                                    Giá thuê: {{ number_format($phong->GiaThue, 0, ',', '.') }} đ/tháng.
                                </p>
                            </div>
                            <div class="fee">
                                <h5 style="margin-bottom:5px;font-weight: bold;">Chi phí sinh hoạt</h5>
                                <p style="font-size: 18px;color: #333;">
                                    @php
                                        $tienDien = $loaiphi->where('TenLoaiPhi', 'Tiền điện')->first();
                                        $tienNuoc = $loaiphi->where('TenLoaiPhi', 'Tiền nước')->first();
                                        $phiDichVu = $loaiphi->where('TenLoaiPhi', '!=', 'Tiền điện')
                                                            ->where('TenLoaiPhi', '!=', 'Tiền nước')
                                                            ->where('TenLoaiPhi', '!=', 'Phí khác')
                                                            ->sum('DonGia');
                                    @endphp
                                    Tiền điện: {{ number_format($tienDien->DonGia, 0, ',', '.') }} đ/Kwh <br>
                                    Tiền nước: {{ number_format($tienNuoc->DonGia, 0, ',', '.') }} đ/m<sup>3</sup> <br>
                                    Phí dịch vụ (wifi, dọn vệ sinh, bảo vệ 24/7): {{ number_format($phiDichVu, 0, ',', '.') }} đ/tháng
                                </p>
                            </div>
                            <div class="fee">
                                <h5 style="margin-bottom:5px;font-weight: bold;">Nội thất</h5>
                                <p style="font-size: 18px;color: #333;">
                                    @php
                                        $tienNghi = $phong->chiTietPhong->map(function($item) {
                                            return $item->TienNghi->TenTienNghi;
                                        })->implode(', ') . '...';
                                    @endphp
                                    {{ $tienNghi }} Tất cả đã sẵn sàng cho bạn dọn vào ở ngay. <br>
                                    Hệ thống bảo mật cao với cửa khóa vân tay 2 lớp, đảm bảo an toàn tuyệt đối. <br>
                                    Có thang máy tiện lợi và dịch vụ vệ sinh 4 lần/tuần, giữ cho không gian luôn sạch sẽ.
                                </p>
                            </div>
                            <div class="contact">
                                <h5 style="margin-bottom:5px;font-weight: bold;">Liên hệ</h5>
                                <p style="font-size: 18px;color: #333;">
                                    @php
                                        //
                                        // $quanLy = $phong->coSo->nhanVien()
                                        //             ->whereHas('taikhoan', function($query) {
                                        //                 $query->where('VaiTro', 'Quản lý');
                                        //             })
                                        //             ->first();
                                    @endphp
                                    Liên hệ ngay để được tư vấn chi tiết và xem phòng miễn phí! <br>
                                    {{-- Liên hệ: {{ $quanLy->HoTen }} - {{ $quanLy->SDT }} --}}
                                </p>
                            </div>
                        </div>
                        <div class="map">
                            <iframe src="https://maps.google.com/maps?q={{ urlencode($phong->coSo->DiaChi) }}&t=&z=13&ie=UTF8&iwloc=&output=embed" height="470" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="room-sidebar">
                    <div class="room-title">
                        <h4 style="font-weight: bold;margin-bottom: 5px;" class="text-center">Có thể bạn quan tâm</h4>
                    </div>
                    @php
                        $phongKhacList = $phong->coSo->phongTro
                            ->where('MaPhong', '!=', $phong->MaPhong)
                            ->where('MaCoSo', $phong->MaCoSo)
                            ->random(3);
                    @endphp
                    @foreach($phongKhacList as $phongKhac)
                        <div class="room-item">
                            <a href="{{ route('phong.details', $phongKhac->MaPhong) }}">
                                <img src="{{ file_exists(public_path('template/client/dist/img/phong/' . $phongKhac->MaPhong . '.png'))
                                ? '/template/client/dist/img/phong/' . $phongKhac->MaPhong . '.png'
                                : '/template/client/dist/img/phong/noimage.png' }}"
                                alt="Hình ảnh"
                                width="200"
                                height="150">
                                <div class="ri-text">
                                    <h4>{{ $phongKhac->TenPhong }}</h4>
                                    <h3>{{ number_format($phongKhac->GiaThue, 0, ',', '.') }}<span>/Tháng</span></h3>
                                    <a href="{{ route('phong.details', $phongKhac->MaPhong ) }}" class="primary-btn">Xem chi tiết</a>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Room Details Section End -->
@endsection
@push('scripts')
<script>
function handleBooking(maPhong) {
    $.ajax({
        url: '{{ route("phong.book") }}',
        type: 'POST',
        data: {
            maPhong: maPhong,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                toastr.success("Đặt phòng thành công");
                window.location.href = response.redirectUrl;
            } else {
                toastr.error(response.message || "Đang có lỗi vui lòng chờ");
            }
        },
        error: function(xhr) {
            toastr.error("Có lỗi xảy ra, vui lòng thử lại");
        }
    });
}
</script>
@endpush
