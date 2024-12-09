@extends('Layout.admin')
@section('title', 'Phân quyền tài khoản')
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.phanquyen.index') }}" class="btn btn-secondary card-title">
            <i class="fas fa-arrow-left"></i> Quay về
        </a>
        <a href="{{ route('admin.phanquyen.createaccount') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tạo tài khoản mới
        </a>
        <div class="card-tools">
            <div class="d-flex">
                <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm...">
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr class="text-center">
                    <th>STT</th>
                    <th>Tên tài khoản</th>
                    <th>Vai trò</th>
                    <th>Số quyền</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="accountTable">
                @foreach($taiKhoans as $taiKhoan)
                <tr class="text-center account-row">
                    <td class="searchable">{{ $loop->iteration }}</td>
                    <td class="searchable">{{ $taiKhoan->TenDangNhap }}</td>
                    <td class="searchable">{{ $taiKhoan->VaiTro }}</td>
                    <td>{{ count($taiKhoan->phanQuyen) }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" onclick="togglePermissions('{{ $taiKhoan->MaTaiKhoan }}')">
                            <i class="fas fa-eye"></i> Xem chi tiết
                        </button>
                        <a href="{{ route('admin.phanquyen.chitietquyen', $taiKhoan->MaTaiKhoan) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i> Chỉnh sửa quyền
                        </a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $taiKhoan->MaTaiKhoan }}', '{{ $taiKhoan->TenDangNhap }}')">
                            <i class="fas fa-trash"></i> Xóa tài khoản
                        </button>
                    </td>
                </tr>
                <tr id="permissions-{{ $taiKhoan->MaTaiKhoan }}" style="display: none;">
                    <td colspan="4">
                        <div class="ml-4">
                            @if(count($taiKhoan->phanQuyen) > 0)
                            <h5>Danh sách quyền:</h5>
                            <ul class="list-group">
                                @foreach($taiKhoan->phanQuyen as $phanQuyen)
                                <li class="list-group-item searchable">
                                    {{ $phanQuyen->quyen->TenQuyen }} - {{ $phanQuyen->quyen->MoTa }}
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <h5 class="text-danger text-left">Không có quyền</h5>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal xác nhận xóa -->
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
                Bạn có chắc chắn muốn xóa tài khoản <span id="accountName" class="font-weight-bold"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Xóa</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePermissions(maTaiKhoan) {
    $('#permissions-' + maTaiKhoan).toggle();
}

function confirmDelete(maTaiKhoan, tenTaiKhoan) {
    $('#accountName').text(tenTaiKhoan);
    $('#confirmDeleteBtn').attr('onclick', `deleteAccount('${maTaiKhoan}')`);
    $('#deleteModal').modal('show');
}

function deleteAccount(maTaiKhoan) {
    $.ajax({
        url: `/admin/phanquyen/deleteaccount/${maTaiKhoan}`,
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.success) {
                toastr.success('Xóa tài khoản thành công');
                location.reload();
            } else {
                toastr.error(response.message);
            }
            $('#deleteModal').modal('hide');
        },
        error: function(xhr) {
            toastr.error('Có lỗi xảy ra khi xóa tài khoản');
            $('#deleteModal').modal('hide');
        }
    });
}

$(document).ready(function(){
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#accountTable tr.account-row").filter(function() {
            var match = false;
            $(this).find('.searchable').each(function() {
                if($(this).text().toLowerCase().indexOf(value) > -1) {
                    match = true;
                    return false;
                }
            });
            $(this).toggle(match);
        });
    });
});
</script>
@endpush
@endsection
