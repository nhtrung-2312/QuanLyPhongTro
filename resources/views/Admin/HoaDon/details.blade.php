@extends('Layout.admin')
@section('title', 'Chi tiết hóa đơn')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Chi tiết hóa đơn: {{ $chitiethoadons[0]->hoadon->MaHoaDon }}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.hoadon.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
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
                    @php
                        $thanhtien = $chitiethoadon->SoLuong * $chitiethoadon->LoaiPhi->DonGia;
                        $chitiethoadon->ThanhTien = $thanhtien;
                        $chitiethoadon->save();
                    @endphp
                    <td>{{ $key + 2 }}</td>
                    <td>{{ $chitiethoadon->LoaiPhi->TenLoaiPhi }}</td> 
                    <td>{{ $chitiethoadon->SoLuong }}</td>
                    <td>{{ number_format($chitiethoadon->LoaiPhi->DonGia, 0, ',', '.') }} đ</td>
                    <td>{{ number_format($thanhtien, 0, ',', '.') }} đ</td>
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