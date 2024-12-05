@extends('Layout.admin')
@section('title', 'Danh sách loại phí')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách loại phí</h3>
        <div class="card-tools">
            <a href="{{ route('admin.loaiphi.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Thêm mới
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead>
                <tr class="text-center">
                    <th>STT</th>
                    <th>Tên loại phí</th>
                    <th>Đơn giá</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loaiPhis as $loaiphi)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $loaiphi->TenLoaiPhi }}</td>
                    <td>{{ number_format($loaiphi->DonGia, 0, ',', '.') }} đ</td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="editLoaiPhi('{{ $loaiphi->MaLoaiPhi }}')">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteLoaiPhi('{{ $loaiphi->MaLoaiPhi }}', '{{ $loaiphi->TenLoaiPhi }}')">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa loại phí <strong id="deleteLoaiPhiName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Xóa</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sửa -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa loại phí</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_MaLoaiPhi">
                    <div class="form-group">
                        <label for="edit_TenLoaiPhi">Tên loại phí</label>
                        <input type="text" class="form-control" id="edit_TenLoaiPhi" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_DonGia">Đơn giá</label>
                        <input type="number" class="form-control" id="edit_DonGia" min="0" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="updateLoaiPhi()">Cập nhật</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let deleteId = null;

// Hàm chuyển đến trang chỉnh sửa
function editLoaiPhi(maLoaiPhi) {
    // Gọi API để lấy thông tin loại phí
    $.ajax({
        url: `/admin/loaiphi/edit/${maLoaiPhi}`,
        type: 'GET',
        success: function(response) {
            // Điền dữ liệu vào form
            $('#edit_MaLoaiPhi').val(response.MaLoaiPhi);
            $('#edit_TenLoaiPhi').val(response.TenLoaiPhi);
            $('#edit_DonGia').val(response.DonGia);
            // Hiển thị modal
            $('#editModal').modal('show');
        },
        error: function(xhr) {
            toastr.error('Có lỗi xảy ra khi lấy thông tin!');
        }
    });
}

// Hàm mở modal xác nhận xóa
function deleteLoaiPhi(maLoaiPhi, tenLoaiPhi) {
    deleteId = maLoaiPhi;
    $('#deleteLoaiPhiName').text(tenLoaiPhi);
    $('#deleteModal').modal('show');
}

// Hàm xác nhận xóa
function confirmDelete() {
    if (!deleteId) return;

    $.ajax({
        url: `/admin/loaiphi/delete/${deleteId}`,
        type: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            $('#deleteModal').modal('hide');
            if(response.success) {
                toastr.success('Xóa thành công!');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                toastr.error(response.message || 'Có lỗi xảy ra!');
            }
        },
        error: function(xhr) {
            $('#deleteModal').modal('hide');
            toastr.error('Có lỗi xảy ra khi xóa!');
        }
    });
}

// Thêm hàm updateLoaiPhi để xử lý cập nhật
function updateLoaiPhi() {
    const maLoaiPhi = $('#edit_MaLoaiPhi').val();
    const data = {
        _token: '{{ csrf_token() }}',
        _method: 'PUT',
        TenLoaiPhi: $('#edit_TenLoaiPhi').val(),
        DonGia: $('#edit_DonGia').val()
    };

    $.ajax({
        url: `/admin/loaiphi/update/${maLoaiPhi}`,
        type: 'POST',
        data: data,
        success: function(response) {
            $('#editModal').modal('hide');
            if(response.success) {
                toastr.success('Cập nhật thành công!');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                toastr.error(response.message || 'Có lỗi xảy ra!');
            }
        },
        error: function(xhr) {
            toastr.error('Có lỗi xảy ra khi cập nhật!');
        }
    });
}

// Tự động ẩn thông báo
$(document).ready(function() {
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
});
</script>
@endpush
@endsection

