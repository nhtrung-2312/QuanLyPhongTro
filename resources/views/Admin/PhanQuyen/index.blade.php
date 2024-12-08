@extends('Layout.admin')
@section('title', 'Danh sách quyền')
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.phanquyen.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm quyền
        </a>
    </div>
    <div class="card-body">
        @if($quyens->isEmpty())
            <div class="text-center">
                <p>Không có quyền nào</p>
            </div>
        @else
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên quyền</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quyens as $quyen)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $quyen->TenQuyen }}</td>
                    <td>{{ $quyen->MoTa }}</td>
                    <td>
                        <button class="btn btn-primary" onclick="showEditModal('{{ $quyen->MaQuyen }}', '{{ $quyen->TenQuyen }}', '{{ $quyen->MoTa }}')">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <button class="btn btn-danger" onclick="showDeleteModal('{{ $quyen->MaQuyen }}')">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<!-- Modal Xác nhận xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa quyền này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <form id="deleteForm" method="POST" action="{{ route('admin.phanquyen.delete') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="maQuyen" id="maQuyen">
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Chỉnh sửa -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Chỉnh sửa quyền</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" action="{{ route('admin.phanquyen.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="MaQuyen" id="MaQuyen">
                    <div class="form-group">
                        <label for="TenQuyen">Tên quyền</label>
                        <input type="text" class="form-control" id="TenQuyen" name="TenQuyen" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="moTa">Mô tả</label>
                        <textarea class="form-control" id="MoTa" name="MoTa" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function() {
    $('#editForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    window.location.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Có lỗi xảy ra, vui lòng thử lại sau!');
                console.log(xhr.responseText);
            }
        });
    });

    $('#deleteForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    window.location.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Có lỗi xảy ra, vui lòng thử lại sau!');
                console.log(xhr.responseText);
            }
        });
    });
});

function showDeleteModal(maQuyen) {
    $('#maQuyen').val(maQuyen);
    $('#deleteModal').modal('show');
}

function showEditModal(maQuyen, tenQuyen, moTa) {
    $('#TenQuyen').val(tenQuyen);
    $('#MoTa').val(moTa);
    $('#MaQuyen').val(maQuyen);
    $('#editModal').modal('show');
}
</script>
@endpush
@endsection

