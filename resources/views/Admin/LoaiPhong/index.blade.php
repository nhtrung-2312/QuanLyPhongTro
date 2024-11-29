@extends('Layout.admin')
@section('title', 'Danh sách loại phòng')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách loại phòng</h3>
        <div class="card-tools">
            <a href="{{ route('admin.loaiphong.create') }}" class="btn btn-primary">Thêm mới</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr class="text-center align-middle">
                    <th>STT</th>
                    <th>Diện tích (m²)</th>
                    <th>Loại phòng</th>
                    <th>Số người</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loaiPhongs as $index => $loaiPhong)
                <tr class="text-center align-middle">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $loaiPhong->DienTich }}</td>
                    <td>{{ $loaiPhong->LoaiPhong }}</td>
                    <td>{{ $loaiPhong->SoNguoi }}</td>
                    <td>
                        <a href="{{ route('admin.loaiphong.edit', $loaiPhong->MaLoaiPhong) }}" class="btn btn-sm btn-info">Chỉnh sửa</a>
                        <button onclick="deleteRoomType('{{ $loaiPhong->MaLoaiPhong }}', '{{$loaiPhong->LoaiPhong}}')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>  </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $loaiPhongs->links() }}
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
                <p>Bạn có chắc chắn muốn xóa loại phòng <span id="deleteRoomTypeName" class="font-weight-bold"></span>?</p>
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

function deleteRoomType(id, name) {
    console.log(id, name);
    deleteId = id;
    $('#deleteRoomTypeName').text(name);
    $('#deleteModal').modal('show');
}

function confirmDelete() {
    if (!deleteId) return;

    $.ajax({
        url: `/admin/loaiphong/delete/${deleteId}`,
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
