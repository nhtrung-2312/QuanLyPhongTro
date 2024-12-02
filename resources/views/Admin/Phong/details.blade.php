@extends('Layout.admin')                    
@section('title', 'Chi tiết phòng trọ')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Chi Tiết phòng: {{$phong->TenPhong}}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.rooms.details.create', ['id' => $phong->MaPhong]) }}" class="btn btn-primary">Thêm tiện nghi</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr class="text-center align-center" style="vertical-align: middle;">
                    <th>STT</th>
                    <th>Tên tiện nghi</th>
                    <th>Số lượng</th>
                    <th>Tình trạng</th>
                    <th>Ghi chú</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chiTietPhongs as $index => $phong)               
                <tr class="text-center align-center vertical-middle">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $phong->tienNghi->TenTienNghi}}</td>
                    <td>{{ $phong->SoLuong}}</td>
                    <td>{{ $phong->TinhTrang }}</td>
                    <td>{{ $phong->GhiChu }}</td>
                    <td class="align-middle">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('admin.rooms.details.edit', ['id' => $phong->MaPhong, 'maTienNghi' => $phong->MaTienNghi]) }}" 
                                    class="btn btn-sm btn-info mx-1">
                                     Chỉnh sửa
                                 </a>
                                <button onclick="deleteChiTiet('{{ $phong->MaPhong }}', '{{ $phong->MaTienNghi }}', '{{ $phong->tienNghi->TenTienNghi }}')" class="btn btn-sm btn-danger mx-1">
                                    Xóa
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $chiTietPhongs->appends(request()->query())->links() }}
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
                <p>Bạn có chắc chắn muốn xóa tiện nghi <span id="deleteDetailName" class="font-weight-bold"></span>?</p>
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
let TienNghiId = null;

function deleteChiTiet(id, tienNghiId, name) {
    console.log(id, tienNghiId, name);
    deleteId = id;
    TienNghiId = tienNghiId;
    $('#deleteDetailName').text(name);
    $('#deleteModal').modal('show');
}

function confirmDelete() {
    if (!deleteId || !TienNghiId) return;
    $.ajax({
        url: `/admin/rooms/details/delete/${deleteId}/${TienNghiId}`,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
            toastr.error(response.message || 'Có lỗi xảy ra!');
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
