@extends('Layout.admin')
@section('title', 'Danh sách hợp đồng thuê')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách hợp đồng thuê</h3>
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
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Trạng thái</th>
                    <th>Tiền cọc</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hopdongthues as $hopdongthue)
                <tr class="text-center align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $hopdongthue->phong->coSo->TenCoSo }}</td> 
                    <td>{{ $hopdongthue->phong->TenPhong }}</td>
                    <td>{{ $hopdongthue->NgayBatDau }}</td>
                    <td>{{ $hopdongthue->NgayKetThuc }}</td>
                    <td>{{ $hopdongthue->TrangThai }}</td>
                    <td>{{ $hopdongthue->TienCoc }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" onclick="updateHopDongThue({{ json_encode($hopdongthue) }})">Chỉnh sửa</a>
                        <a class="btn btn-sm btn-danger" onclick="deleteHopDongThue({{ $hopdongthue->MaHopDong }})">Xóa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $hopdongthues->links() }}
    </div>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Chỉnh sửa hợp đồng thuê</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                   
                    <div class="form-group">
                        <label for="NgayBatDau">Ngày bắt đầu</label>
                        <input type="text" class="form-control" id="NgayBatDau" name="NgayBatDau" placeholder="Nhập ngày bắt đầu">
                    </div>
                    <div class="form-group">
                        <label for="NgayKetThuc">Ngày kết thúc</label>
                        <input type="text" class="form-control" id="NgayKetThuc" name="NgayKetThuc" value="" placeholder="Nhập ngày kết thúc">
                    </div>
                    <div class="form-group">
                        <label for="TrangThai">Trạng thái</label>
                        <input type="text" class="form-control" id="TrangThai" name="TrangThai" value="" placeholder="Nhập trạng thái">
                    </div>
                    <div class="form-group">
                        <label for="TienCoc">Tiền cọc</label>
                        <input type="text" class="form-control" id="TienCoc" name="TienCoc" value="" placeholder="Nhập tiền cọc">
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
    function updateHopDongThue(hopdongthue) {
        console.log('HopDongThue data:', hopdongthue);
        $('#NgayBatDau').val(hopdongthue.NgayBatDau);
        $('#NgayKetThuc').val(hopdongthue.NgayKetThuc);
        $('#TrangThai').val(hopdongthue.TrangThai);
        $('#TienCoc').val(hopdongthue.TienCoc);
        window.updateId = hopdongthue.MaHopDong;
        $('#updateModal').modal('show');
    }
</script>
@endpush