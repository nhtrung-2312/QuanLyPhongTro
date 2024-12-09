@extends('layout.admin')
@section('title', 'Danh sách tiện nghi')
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.tiennghi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm tiện nghi
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên tiện nghi</th>
                    <th>Mô tả</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tiennghi as $tn)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tn->TenTienNghi }}</td>
                    <td>{{ $tn->MoTa }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm btn-edit" onclick="editTienNghi('{{$tn->MaTienNghi}}')">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <button type="button" class="btn btn-danger btn-sm btn-delete" onclick="deleteTienNghi('{{$tn->MaTienNghi}}')">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Sửa -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Sửa tiện nghi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" action="{{ route('admin.tiennghi.update') }}" method="PUT">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="MaTienNghi" id="edit_matiennghi">
                    <div class="form-group">
                        <label>Tên tiện nghi</label>
                        <input type="text" class="form-control" name="TenTienNghi" id="edit_tentiennghi">
                        <span class="text-danger" id="error_tentiennghi"></span>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" name="MoTa" id="edit_mota"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteForm" action="{{ route('admin.tiennghi.delete') }}" method="DELETE">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="MaTienNghi" id="delete_matiennghi">
                    <span>Bạn có chắc chắn muốn xóa tiện nghi này?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function editTienNghi(id) {
        $('#editModal').modal('show');
        $.ajax({
            url: `/admin/tiennghi/edit/${id}`,
            type: 'GET',
            success: function(response) {
                $('#edit_matiennghi').val(response.data.MaTienNghi);
                $('#edit_tentiennghi').val(response.data.TenTienNghi);
                $('#edit_mota').val(response.data.MoTa);
            }
        });
    }
    function deleteTienNghi(id) {
        $('#deleteModal').modal('show');
        $('#delete_matiennghi').val(id);
    }

    $(document).ready(function() {
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            $('.text-danger').text('');
            $.ajax({
                url: $(this).attr('action'),
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success(response.message);
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    const errors = xhr.responseJSON.errors;
                    $('#error_tentiennghi').text(errors.TenTienNghi);
                }
            });
        });
        $('#deleteForm').on('submit', function(e) {
            e.preventDefault();
            $('.text-danger').text('');
            $.ajax({
                url: $(this).attr('action'),
                type: 'DELETE',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        window.location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Có lỗi xảy ra, vui lòng thử lại!');
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endpush
@endsection
