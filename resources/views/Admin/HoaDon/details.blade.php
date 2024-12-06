@extends('Layout.admin')
@section('title', 'Chi tiết hóa đơn')
@section('content')
@php
    $maCoSoHienTai = session('selected_facility');
    $maCoSoHoaDon = $hoadon->hopdongthue->phong->MaCoSo;
    if($maCoSoHienTai != $maCoSoHoaDon) {
        header("Location: " . route('admin.hoadon.index'));
        exit();
    }
@endphp
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <a href="{{ route('admin.hoadon.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="card-tools">
            <a href="{{ route('admin.hoadon.print', $hoadon->MaHoaDon) }}" class="btn btn-sm btn-info">
                <i class="fas fa-print"></i> Xuất hoá đơn
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Thông tin hóa đơn</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>Mã hóa đơn:</th>
                        <td>{{ $chitiethoadons[0]->hoadon->MaHoaDon }}</td>
                    </tr>
                    <tr>
                        <th>Ngày lập:</th>
                        <td>{{ date('d/m/Y', strtotime($chitiethoadons[0]->hoadon->NgayLap)) }}</td>
                    </tr>
                    <tr>
                        <th>Trạng thái:</th>
                        <td>
                            @if($chitiethoadons[0]->hoadon->TrangThai == 'Chưa thanh toán')
                                <span class="badge badge-warning">{{ $chitiethoadons[0]->hoadon->TrangThai }}</span>
                            @elseif($chitiethoadons[0]->hoadon->TrangThai == 'Đã thanh toán')
                                <span class="badge badge-success">{{ $chitiethoadons[0]->hoadon->TrangThai }}</span>
                            @else
                                <span class="badge badge-danger">{{ $chitiethoadons[0]->hoadon->TrangThai }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Phòng:</th>
                        <td>{{ $chitiethoadons[0]->hoadon->hopdongthue->phong->TenPhong }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <h5>Chi tiết các khoản phí</h5>
        <table class="table table-bordered">
            <thead>
                <tr class="text-center align-middle">
                    <th>STT</th>
                    <th>Tên loại phí</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center align-middle">
                    <td>1</td>
                    <td>Tiền phòng</td>
                    <td>1</td>
                    <td>{{ number_format($chitiethoadons[0]->hoadon->hopdongthue->phong->GiaThue, 0, ',', '.') }} đ</td>
                    <td>{{ number_format($chitiethoadons[0]->hoadon->hopdongthue->phong->GiaThue, 0, ',', '.') }} đ</td>
                </tr>
                @foreach($chitiethoadons as $key => $chitiethoadon)
                <tr class="text-center align-middle">
                    <td>{{ $key + 2 }}</td>
                    <td>{{ $chitiethoadon->LoaiPhi->TenLoaiPhi }}</td>
                    <td>{{ $chitiethoadon->SoLuong }}</td>
                    <td>{{ number_format($chitiethoadon->LoaiPhi->DonGia, 0, ',', '.') }} đ</td>
                    <td>{{ number_format($chitiethoadon->ThanhTien, 0, ',', '.') }} đ</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="text-center align-middle">
                    <td colspan="4" class="text-right"><strong>Tổng tiền:</strong></td>
                    <td><strong>
                        @php
                            $tienPhong = $chitiethoadons[0]->hoadon->hopdongthue->phong->GiaThue;
                            $tongTienDichVu = $chitiethoadons->sum('ThanhTien');
                            $tongCong = $tienPhong + $tongTienDichVu;

                            $hoadon = $chitiethoadons[0]->hoadon;
                            $hoadon->TongTien = $tongCong;
                            $hoadon->save();
                        @endphp
                        {{ number_format($tongCong, 0, ',', '.') }} đ
                    </strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
