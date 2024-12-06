@extends('Layout.admin')
@section('title', 'Danh sách phòng trọ')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách Phòng trọ</h3>
        <div class="card-tools">
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Thêm mới</a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.rooms.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <select name="MaLoaiPhong" class="form-control">
                        <option value="">Chọn loại phòng</option>
                        @foreach($loaiphongs as $loaiphong)
                            <option value="{{ $loaiphong->MaLoaiPhong }}" {{ request('MaLoaiPhong') == $loaiphong->MaLoaiPhong ? 'selected' : '' }}>
                                {{ $loaiphong->LoaiPhong }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="TrangThai" class="form-control">
                        <option value="">Chọn trạng thái</option>
                        <option value="Đang thuê" {{ request('TrangThai') == 'Đang thuê' ? 'selected' : '' }}>Đang thuê</option>
                        <option value="Đang xử lý" {{ request('TrangThai') == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="Phòng trống" {{ request('TrangThai') == 'Phòng trống' ? 'selected' : '' }}>Phòng trống</option>
                    </select>
                </div>
                <div class="col-md-3 ml-auto">
                    <button type="submit" class="btn btn-primary btn-block">Lọc</button>
                </div>
            </div>
        </form>
            <div>
                <span class="p-5">
            </div>
        <table class="table table-bordered">
            <thead>
                <tr class="text-center align-center" style="vertical-align: middle;">
                    <th>STT</th>
                    <th>Tên cơ sở</th>
                    <th>Loại phòng</th>
                    <th>Tên phòng</th>
                    <th>Giá thuê (VNĐ)</th>
                    <th>Trạng thái</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($phongs as $index => $phong)
                <tr class="text-center align-center vertical-middle">
                    <td >{{ $index + 1 }}</td>
                    <td>{{ $phong->coSo->TenCoSo ?? 'Không xác định'}}</td>
                    <td>{{ $phong->loaiPhong->LoaiPhong ?? 'Không xác định'}}</td>
                    <td>{{ $phong->TenPhong }}</td>
                    <td>{{number_format($phong->GiaThue, 0, ',', '.') }}</td>
                    <td>{{ $phong->TrangThai }}</td>
                    <td>{{ $phong->MoTa }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('admin.rooms.edit', $phong->MaPhong) }}" class="btn btn-sm btn-info">Chỉnh sửa</a>
                            <button onclick="deleteRoom('{{ $phong->MaPhong }}', '{{$phong->TenPhong}}')" class="btn btn-sm btn-danger m-2 p-3">
                                Xóa
                            </button>
                            <a href="{{ route('admin.rooms.details', $phong->MaPhong) }}" class="btn btn-sm btn-success">Chi tiết</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $phongs->appends(request()->query())->links() }}
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa phòng <span id="deleteRoomName" class="font-weight-bold"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Xóa</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
let deleteId = null;

function deleteRoom(id, name) {
    console.log(id, name);
    deleteId = id;
    $('#deleteRoomName').text(name);
    $('#deleteModal').modal('show');
}

function confirmDelete() {
    if (!deleteId) return;

    $.ajax({
        url: `/admin/rooms/delete/${deleteId}`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'DELETE'
        },
        success: function(response) {
            $('#deleteModal').modal('hide');
            if (response.success) {
                toastr.success('Xoá thành công!');
                setTimeout(function() {
                    window.location.reload();
                }, 1500);
            } else {
                toastr.error('Delete Error!');
            }
        },
        error: function(xhr) {
            $('#deleteModal').modal('hide');
            toastr.error('Delete Error!');
        }
    });
}

toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000"
};
</script>
@endpush

@push('style')
<style>
    th, td {
        padding: 15px; /* Adjust padding as needed */
        text-align: center; /* Center text horizontally */
        vertical-align: middle; /* Center text vertically */
    }
</style>
@endpush
