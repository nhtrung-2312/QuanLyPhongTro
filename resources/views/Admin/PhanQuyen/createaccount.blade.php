@extends('Layout.admin')
@section('title', 'Tạo tài khoản')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tạo tài khoản mới</h3>
        <div class="card-tools">
            <a href="{{ route('admin.phanquyen.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
    <div class="card-body">
        <form id="createAccountForm" method="POST" action="{{ route('admin.phanquyen.storeaccount') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="TenDangNhap">Tên đăng nhập <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="TenDangNhap" name="TenDangNhap" required>
                        <span class="text-danger" id="TenDangNhapError"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="MatKhau">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="MatKhau" name="MatKhau" required>
                        <span class="text-danger" id="MatKhauError"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="VaiTro">Vai trò <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="VaiTro" name="VaiTro" required>
                        <span class="text-danger" id="VaiTroError"></span>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Tạo tài khoản
                </button>
                <a href="{{ route('admin.phanquyen.index') }}" class="btn btn-danger">
                    <i class="fas fa-times"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#createAccountForm').submit(function(e) {
        e.preventDefault();
        $('#TenDangNhapError').text('');
        $('#MatKhauError').text('');
        $('#VaiTroError').text('');
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Tạo tài khoản thành công');
                    window.location.href = "{{ route('admin.phanquyen.capquyen') }}";
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON;
                console.log(errors);
            }
        });
    });
});
</script>
@endpush
@endsection
