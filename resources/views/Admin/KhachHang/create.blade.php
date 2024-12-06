@extends('Layout.admin')
@section('title', 'Thêm khách hàng')
@section('content')
<div class="card">
    <div class="card-body">
        <form id="createForm" method="POST" action="{{ route('admin.khachhang.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="HoTen">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="HoTen" name="HoTen">
                        <span class="text-danger" id="HoTenError"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="SDT">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="SDT" name="SDT" >
                        <span class="text-danger" id="SDTError"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="DiaChi">Địa chỉ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="DiaChi" name="DiaChi" >
                        <span class="text-danger" id="DiaChiError"></span>
                    </div>
                    <div id="accountFields" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="TenDangNhap">Tên đăng nhập <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="TenDangNhap" name="TenDangNhap">
                            <span class="text-danger" id="TenDangNhapError"></span>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="createAccount" name="createAccount">
                            <label class="custom-control-label" for="createAccount">Tạo tài khoản cho khách hàng</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="CCCD">CCCD <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="CCCD" name="CCCD" >
                        <span class="text-danger" id="CCCDError"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="NgaySinh">Ngày sinh <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" >
                        <span class="text-danger" id="NgaySinhError"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="GioiTinh">Giới tính <span class="text-danger">*</span></label>
                        <select class="form-control" id="GioiTinh" name="GioiTinh" >
                            <option value="" hidden selected>Chọn giới tính</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                        <span class="text-danger" id="GioiTinhError"></span>
                    </div>
                    <div id="accountFields" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="MatKhau">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="MatKhau" name="MatKhau">
                            <small class="text-danger" id="MatKhauError"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Lưu
                </button>
                <a href="{{ route('admin.khachhang.index') }}" class="btn btn-danger">
                    <i class="fas fa-times"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#createAccount').change(function() {
            const accountFields = document.querySelectorAll('#accountFields');
            if(this.checked) {
                accountFields.forEach(field => {
                    field.style.display = 'block';
                });
                $('#TenDangNhap, #MatKhau, #XacNhanMatKhau').prop('required', true);
            } else {
                accountFields.forEach(field => {
                    field.style.display = 'none';
                });
                $('#TenDangNhap, #MatKhau, #XacNhanMatKhau').prop('required', false);
            }
        });
        $('#createForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        console.log(response.data);
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 500
                        }
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.khachhang.index') }}";
                        }, 500);
                    }
                },
                error: function(xhr, status, error) {
                    const errors = xhr.responseJSON.errors;
                    console.log(xhr.responseJSON);
                    $('#HoTenError').text(errors.HoTen ? errors.HoTen[0] : '');
                    $('#SDTError').text(errors.SDT ? errors.SDT[0] : '');
                    $('#DiaChiError').text(errors.DiaChi ? errors.DiaChi[0] : '');
                    $('#CCCDError').text(errors.CCCD ? errors.CCCD[0] : '');
                    $('#NgaySinhError').text(errors.NgaySinh ? errors.NgaySinh[0] : '');
                    $('#GioiTinhError').text(errors.GioiTinh ? errors.GioiTinh[0] : '');
                    $('#TenDangNhapError').text(errors.TenDangNhap ? errors.TenDangNhap[0] : '');
                    $('#MatKhauError').text(errors.MatKhau ? errors.MatKhau[0] : '');
                }
            });
        });
    });
</script>
@endpush
@endsection
