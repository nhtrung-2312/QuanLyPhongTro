@extends('Layout.client')
@section('title', 'Lịch sử hoá đơn')
@section('content')
<div class="breadcrumb-section" style="padding-bottom: 5px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Lịch sử hoá đơn</h2>
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
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/lich-su-hoa-don') }}" class="active" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-history"></i> Lịch sử hoá đơn</a></li>
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/thong-tin-phong') }}" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-home"></i> Thông tin phòng</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-9">
                @if(count($hoadons) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr style="text-align: center;">
                                <th>STT</th>
                                <th>Ngày lập</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hoadons as $hoadon)
                            <tr style="text-align: center;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d/m/Y', strtotime($hoadon->NgayLap)) }}</td>
                                <td>{{ number_format($hoadon->TongTien, 0, ',', '.') }}đ</td>
                                <td>
                                    @if($hoadon->TrangThai == "Đã thanh toán")
                                        <span style="font-size: 14px; padding: 8px 12px;" class="badge badge-lg badge-success">Đã thanh toán</span>
                                    @elseif($hoadon->TrangThai == "Chưa thanh toán")
                                        <span style="font-size: 14px; padding: 8px 12px;" class="badge badge-lg badge-warning">Chưa thanh toán</span>
                                    @elseif($hoadon->TrangThai == "Đang xử lý")
                                        <span style="font-size: 14px; padding: 8px 12px;" class="badge badge-lg badge-info">Đang xử lý</span>
                                    @elseif($hoadon->TrangThai == "Đã huỷ")
                                        <span style="font-size: 14px; padding: 8px 12px;" class="badge badge-lg badge-danger">Đã hủy</span>
                                    @endif
                                </td>
                                <td>
                                    @if($hoadon->TrangThai == "Chưa thanh toán")
                                    <button type="button" 
                                            class="btn btn-sm btn-success" 
                                            onclick="window.location.href='{{ route('thanhToan.hoaDon', ['id' => $hoadon->MaHoaDon]) }}'"> 
                                        Thanh toán
                                    </button>
                                    @elseif($hoadon->TrangThai == "Đang xử lý")

                                    @else
                                        <a href="" class="btn btn-sm btn-info">Chi tiết</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-info">
                    Bạn chưa có hoá đơn nào.
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

{{-- //{{ route('thanhToan.hoaDon', ['id' => $hoadon->MaHoaDon, 'type' => 'invoice']) }} --}}