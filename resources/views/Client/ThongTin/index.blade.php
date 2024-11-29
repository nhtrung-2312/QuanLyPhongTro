@extends('Layout.client')
@section('title', 'Thông tin cá nhân')
@section('content')
<div class="breadcrumb-section" style="padding-bottom: 5px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Thông tin cá nhân</h2>
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
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/thong-tin-ca-nhan') }}" class="active" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-user"></i> Thông tin cá nhân</a></li>
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/cap-nhat-tai-khoan') }}" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-key"></i> Chỉnh sửa tài khoản</a></li>
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/lich-su-hoa-don') }}" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-history"></i> Lịch sử hoá đơn</a></li>
                        <li style="display: block; margin-bottom: 10px;"><a href="{{ url('/thong-tin/thong-tin-phong') }}" style="display: block; padding: 10px; color: #19191a; text-decoration: none;"><i class="fa fa-home"></i> Thông tin phòng</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-9">
                <div class="payment-info">
                    <form id="infoForm" action="{{ route('thongtin.ttupdate') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Họ và tên</label>
                                    <input type="text" class="form-control" name="hoten" value="{{ $khachthue->HoTen }}">
                                    <small class="text-danger" id="hotenError"></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Số điện thoại</label>
                                    <input type="text" class="form-control" name="sdt" value="{{ $khachthue->SDT }}">
                                    <small class="text-danger" id="sdtError"></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>CMND/CCCD</label>
                                    <input type="text" class="form-control" name="cccd" value="{{ $khachthue->CCCD }}">
                                    <small class="text-danger" id="cccdError"></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Ngày sinh</label>
                                    <input type="date" class="form-control" name="ngaysinh" value="{{ $khachthue->NgaySinh }}">
                                    <small class="text-danger" id="ngaysinhError"></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="gioitinh" style="display: block;">Giới tính</label>
                                    <select class="w-100" style="height:20px;" name="gioitinh">
                                        <option value="Nam" {{ $khachthue->GioiTinh == 'Nam' ? 'selected' : '' }}>Nam</option>
                                        <option value="Nữ" {{ $khachthue->GioiTinh == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                    </select>
                                    <small class="text-danger" id="gioitinhError"></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Địa chỉ</label>
                                    <input type="text" class="form-control" name="diachi" value="{{ $khachthue->DiaChi }}">
                                    <small class="text-danger" id="diachiError"></small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
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
        $('#infoForm').on('submit', function(e) {
            e.preventDefault();
            $('.text-danger').text('');

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status) {
                        toastr.options = {
                            "positionClass": "toast-bottom-right"
                        };
                        toastr.success("Cập nhật thành công!");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        console.log(errors);
                        if (errors.hoten) {
                            $('#hotenError').text(errors.hoten);
                        }
                        if (errors.sdt) {
                            $('#sdtError').text(errors.sdt);
                        }
                        if (errors.cmnd) {
                            $('#cmndError').text(errors.cmnd);
                        }
                        if (errors.ngaysinh) {
                            $('#ngaysinhError').text(errors.ngaysinh);
                        }
                        if (errors.gioitinh) {
                            $('#gioitinhError').text(errors.gioitinh);
                        }
                        if (errors.diachi) {
                            $('#diachiError').text(errors.diachi);
                        }
                    }
                }
            });
        });
    });
</script>
@endpush
