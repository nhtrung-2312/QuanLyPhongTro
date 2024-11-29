@extends('Layout.admin')
@section('title', 'Chi tiết hóa đơn')
@section('content')
<div class="card">
    <p>Hóa đơn: {{ $chitiethoadons[0]->hoadon->MaHoaDon }}</p>
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
                @foreach($chitiethoadons as $chitiethoadon)
                <tr class="text-center align-middle">
                    @php
                        $thanhtien = $chitiethoadon->SoLuong * $chitiethoadon->LoaiPhi->DonGia;
                        $chitiethoadon->ThanhTien = $thanhtien;
                        $chitiethoadon->save();
                    @endphp
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $chitiethoadon->LoaiPhi->TenLoaiPhi }}</td> 
                    <td>{{ $chitiethoadon->SoLuong }}</td>
                    <td>{{ number_format($chitiethoadon->LoaiPhi->DonGia, 0, ',', '.') }} đ</td>
                    <td>{{ number_format($thanhtien, 0, ',', '.') }} đ</td>
                    <td>
                        <a class="btn btn-sm btn-info" onclick="updateChiTietHoaDon({{ json_encode($chitiethoadon) }})">Chỉnh sửa</a>
                        <a class="btn btn-sm btn-danger" onclick="deleteChiTietHoaDon({{ $chitiethoadon->MaHoaDon }})">Xóa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal cho tiền điện/nước -->
<div class="modal fade" id="utilityModal" tabindex="-1" aria-labelledby="utilityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="utilityModalLabel">Chỉnh sửa chỉ số</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="ChiSoCu">Chỉ số cũ</label>
                        <input type="number" class="form-control" id="ChiSoCu" name="ChiSoCu">
                    </div>
                    <div class="form-group">
                        <label for="ChiSoMoi">Chỉ số mới</label>
                        <input type="number" class="form-control" id="ChiSoMoi" name="ChiSoMoi">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="confirmUtilityUpdate()">Cập nhật</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal cho các loại phí khác -->
<div class="modal fade" id="otherModal" tabindex="-1" aria-labelledby="otherModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="otherModalLabel">Chỉnh sửa chi tiết</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="SoLuong">Số lượng</label>
                        <input type="number" class="form-control" id="SoLuong" name="SoLuong">
                    </div>
                    <div class="form-group">
                        <label for="GhiChu">Ghi chú</label>
                        <textarea class="form-control" id="GhiChu" name="GhiChu" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="confirmOtherUpdate()">Cập nhật</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    function updateChiTietHoaDon(chitiethoadon) {
        console.log('ChiTietHoaDon data:', chitiethoadon);
        window.currentChiTietHoaDon = chitiethoadon;

        // Kiểm tra loại phí
        if (chitiethoadon.LoaiPhi.TenLoaiPhi.toLowerCase().includes('điện') || 
            chitiethoadon.LoaiPhi.TenLoaiPhi.toLowerCase().includes('nước')) {
            // Hiển thị modal cho tiền điện/nước
            $('#ChiSoCu').val(chitiethoadon.ChiSoCu || 0);
            $('#ChiSoMoi').val(chitiethoadon.ChiSoMoi || 0);
            $('#utilityModal').modal('show');
        } else {
            // Hiển thị modal cho các loại phí khác
            $('#SoLuong').val(chitiethoadon.SoLuong);
            $('#GhiChu').val(chitiethoadon.GhiChu || '');
            $('#otherModal').modal('show');
        }
    }

    function confirmUtilityUpdate() {
        // Xử lý cập nhật chỉ số điện/nước
        // TODO: Implement update logic
        $('#utilityModal').modal('hide');
    }

    function confirmOtherUpdate() {
        // Xử lý cập nhật các loại phí khác
        // TODO: Implement update logic
        $('#otherModal').modal('hide');
    }
</script>
@endpush