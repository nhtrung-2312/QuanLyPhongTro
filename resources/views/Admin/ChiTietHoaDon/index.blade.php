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
                    
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $chitiethoadon->LoaiPhi->TenLoaiPhi }}</td> 
                    <td>{{ $chitiethoadon->SoLuong }}</td>
                    <td>{{ $chitiethoadon->LoaiPhi->DonGia }}</td>
                    <td>{{ $chitiethoadon->ThanhTien }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" onclick="updateChiTietHoaDon({{ json_encode($chitiethoadon) }})">Chỉnh sửa</a>
                        <a class="btn btn-sm btn-danger" onclick="deleteChiTietHoaDon({{ $chitiethoadon->MaHoaDon }})">Xóa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $chitiethoadons->links() }}
    </div>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Chỉnh sửa chi tiết hóa đơn</h5>
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
                        <input type="text" class="form-control" id="SoLuong" name="SoLuong" placeholder="Nhập số lượng">
                    </div>
                    <div class="form-group">
                        <label for="ThanhTien">Thành tiền</label>
                        <input type="text" class="form-control" id="ThanhTien" name="ThanhTien" value="" placeholder="Nhập thành tiền">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn    btn-danger" onclick="confirmUpdate()">Chỉnh sửa</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function updateChiTietHoaDon(chitiethoadon) {
        console.log('ChiTietHoaDon data:', chitiethoadon);
        $('#SoLuong').val(chitiethoadon.SoLuong);
        $('#ThanhTien').val(chitiethoadon.ThanhTien);
        window.updateId = chitiethoadon.MaHoaDon;
        $('#updateModal').modal('show');
    }
</script>
@endpush