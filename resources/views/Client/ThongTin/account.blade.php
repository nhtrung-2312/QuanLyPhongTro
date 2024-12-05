@extends('Layout.client')
@section('title', 'Thông tin cá nhân')
@section('content')
<div class="breadcrumb-section" style="padding-bottom: 5px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Chỉnh sửa tài khoản</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="payment-section spad-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-3" style="border-right: 1px solid #e5e5e5;">
                <nav class="mainmenu">
                    <ul style="display: block; padding: 0;">
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/thong-tin-ca-nhan') }}" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-user"></i> Thông tin cá nhân</a></li>
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/cap-nhat-tai-khoan') }}" class="active" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-key"></i> Chỉnh sửa tài khoản</a></li>
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/lich-su-hoa-don') }}" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-history"></i> Lịch sử hoá đơn</a></li>
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/thong-tin-phong') }}" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-home"></i> Thông tin phòng</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-9">
                <div class="payment-info">
                    <form id="accountForm" method="POST" action="{{ route('thongtin.tkupdate') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Tên tài khoản</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $taikhoan->TenDangNhap }}" readonly>
                                    <small class="text-danger" id="phoneError"></small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Mật khẩu mới</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="password" id="password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="text-danger" id="passwordError"></small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Nhập lại mật khẩu</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="repassword" id="repassword">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="toggleRepassword" tabindex="-1">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="text-danger" id="repasswordError"></small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Cập nhật tài khoản</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    $('#togglePassword, #toggleRepassword').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $('#togglePassword').on('click', function() {
        let input = $('#password');
        togglePasswordVisibility(input, $(this));
    });

    $('#toggleRepassword').on('click', function() {
        let input = $('#repassword');
        togglePasswordVisibility(input, $(this));
    });

    function togglePasswordVisibility(input, button) {
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            button.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            button.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    }

    $('#accountForm').on('submit', function(e) {
        e.preventDefault();
        $('.text-danger').text('');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status) {
                    toastr.success("Cập nhật tài khoản thành công!");
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.phone) {
                        $('#phoneError').text(errors.phone);
                    }
                    if (errors.password) {
                        $('#passwordError').text(errors.password);
                    }
                    if (errors.repassword) {
                        $('#repasswordError').text(errors.repassword);
                    }
                }
            }
        });
    });
});
</script>
@endpush
