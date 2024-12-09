@extends('Layout.admin')
@section('title', 'Danh sách hóa đơn')
@section('content')
<div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center align-middle">
                        <th>STT</th>
                        <th>Tên phòng</th>
                        <th>Ngày lập</th>
                        <th>Ngày thanh toán</th>
                        <th>Tổng tiền</th>
                        <th>Phương thức</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    @if($thanhtoans->count() > 0)
                        @foreach($thanhtoans as $thanhtoan)
                        <tr class="text-center align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $thanhtoan->hoadon->hopdongthue->phong->TenPhong }}</td>
                            <td>{{ date('d/m/Y', strtotime($thanhtoan->hoadon->NgayLap)) }}</td>
                            <td>{{ date('d/m/Y', strtotime($thanhtoan->NgayThanhToan)) }}</td>
                            <td>{{ number_format($thanhtoan->SoTien, 0, ',', '.') }} đ</td>
                            <td>{{ $thanhtoan->PhuongThucThanhToan }}</td>
                            <td>{{ $thanhtoan->GhiChu }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">Không có dữ liệu</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
