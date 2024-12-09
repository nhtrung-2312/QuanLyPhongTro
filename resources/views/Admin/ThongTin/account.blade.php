@extends('Layout.admin')
@section('title', 'Chỉnh sửa tài khoản')
@section('content')
@php
    $permissions = \App\Models\PhanQuyen::where('MaTaiKhoan', session('admin_id'))
        ->where('MaCoSo', session('selected_facility'))
        ->pluck('MaQuyen')
        ->toArray();
@endphp
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="nav flex-column nav-pills">
                    <a class="nav-link" href="{{ route('admin.thongtin.index') }}">
                        <i class="fas fa-user mr-2"></i> Thông tin cá nhân
                    </a>
                    <a class="nav-link active" href="{{ route('admin.thongtin.account') }}">
                        <i class="fas fa-key mr-2"></i> Chỉnh sửa tài khoản
                    </a>
                    @if(in_array("Q010", $permissions))
                        <a class="nav-link" href="{{ route('admin.thongtin.backup') }}">
                            <i class="fas fa-database mr-2"></i> Sao lưu dữ liệu
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Chỉnh sửa tài khoản</h3>
            </div>
            <div class="card-body">
                <form id="accountForm" method="PUT">
                    @csrf
                    <div class="form-group">
                        <label>Tên đăng nhập</label>
                        <input type="text" class="form-control" name="username" value="{{ $taikhoan->TenDangNhap }}">
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu cũ</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="old_password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="old_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <small class="text-danger" id="old_passwordError"></small>
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu mới</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="new_password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <small class="text-danger" id="new_passwordError"></small>
                    </div>
                    <div class="form-group">
                        <label>Xác nhận mật khẩu mới</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirm_password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <small class="text-danger" id="confirm_passwordError"></small>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Cập nhật mật khẩu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$('.toggle-password').on('click', function() {
    const button = $(this);
    const targetName = button.data('target');
    const input = $(`input[name="${targetName}"]`);
    const icon = button.find('i');

    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
});
$(document).ready(function() {
    $('#accountForm').on('submit', function(e) {
        e.preventDefault();
        $('.text-danger').text('');

        $.ajax({
            url: '{{ route("admin.thongtin.updateaccount") }}',
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    window.location.reload();
                } else {
                    $('#old_passwordError').text(response.message);
                }
            },
            error: function(xhr, status, error) {
                const errors = xhr.responseJSON.errors;
                $('#old_passwordError').text(errors.old_password);
                $('#new_passwordError').text(errors.new_password);
                $('#confirm_passwordError').text(errors.confirm_password);
            }
        });
    });
});
</script>
@endpush
@endsection
