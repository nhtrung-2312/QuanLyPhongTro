@extends('Layout.admin')
@section('title', 'Danh sách hóa đơn')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách hóa đơn</h3>
        <div class="card-tools">
            <a href="" class="btn btn-primary">Thêm mới</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr class="text-center align-middle">
                    <th>STT</th>
                    <th>Tên cơ sở</th>
                    <th>Tên phòng</th>
                    <th>Ngày lập</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hoadons as $hoadon)
                <tr class="text-center align-middle">
                    
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $hoadon->hopdongthue->phong->coSo->TenCoSo }}</td> 
                    <td>{{ $hoadon->hopdongthue->phong->TenPhong }}</td>
                    <td>{{ $hoadon->NgayLap }}</td>
                    <td>{{ $hoadon->TongTien }}</td>
                    <td>{{ $hoadon->TrangThai }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" onclick="updateHoaDon({{ json_encode($hoadon) }})">Chỉnh sửa</a>
                        <a class="btn btn-sm btn-danger" onclick="deleteHoaDon({{ $hoadon->MaHoaDon }})">Xóa</a>
                        <a class="btn btn-sm btn-success" href="{{ route('admin.chitiethoadon.index', ['MaHoaDon' => $hoadon->MaHoaDon]) }}">Chi tiết hóa đơn</a>
                       
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $hoadons->links() }}
    </div>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Chỉnh sửa hóa đơn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                   
                    <div class="form-group">
                        <label for="NgayLap">Ngày lập</label>
                        <input type="text" class="form-control" id="NgayLap" name="NgayLap" placeholder="Nhập ngày lập">
                    </div>
                    <div class="form-group">
                        <label for="TongTien">Tổng tiền</label>
                        <input type="text" class="form-control" id="TongTien" name="TongTien" value="" placeholder="Nhập tổng tiền">
                    </div>
                    <div class="form-group">
                        <label for="TrangThai">Trạng thái</label>
                        <input type="text" class="form-control" id="TrangThai" name="TrangThai" value="" placeholder="Nhập trạng thái">
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
    function updateHoaDon(hoadon) {
        console.log('HoaDon data:', hoadon);
        $('#NgayLap').val(hoadon.NgayLap);
        $('#TongTien').val(hoadon.TongTien);
        $('#TrangThai').val(hoadon.TrangThai);
        window.updateId = hoadon.MaHoaDon;
        $('#updateModal').modal('show');
    }
</script>
@endpush