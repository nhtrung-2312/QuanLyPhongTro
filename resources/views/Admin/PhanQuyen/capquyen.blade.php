@extends('Layout.admin')
@section('title', 'Phân quyền tài khoản')
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.phanquyen.index') }}" class="btn btn-secondary card-title">
            <i class="fas fa-arrow-left"></i> Quay về
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
                    <th>Tên tài khoản</th>
                    <th>Vai trò</th>
                    <th>Số quyền</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="accountTable">
                @foreach($taiKhoans as $taiKhoan)
                <tr class="text-center account-row">
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

@push('scripts')
<script>
function togglePermissions(maTaiKhoan) {
    $('#permissions-' + maTaiKhoan).toggle();
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

            // var permissionsRow = $(this).next('tr[id^="permissions-"]');
            // if(permissionsRow.length && match) {
            //     var hasPermissionMatch = false;
            //     permissionsRow.find('.searchable').each(function() {
            //         if($(this).text().toLowerCase().indexOf(value) > -1) {
            //             hasPermissionMatch = true;
            //             return false;
            //         }
            //     });
            //     if(hasPermissionMatch) {
            //         permissionsRow.show();
            //     }
            // } else {
            //     permissionsRow.hide();
            // }
        });
    });
});
</script>
@endpush
@endsection
