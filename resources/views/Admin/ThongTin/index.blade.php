@extends('Layout.admin')
@section('title', 'Thông tin cá nhân')
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
                    <a class="nav-link active" href="{{ route('admin.thongtin.index') }}">
                        <i class="fas fa-user mr-2"></i> Thông tin cá nhân
                    </a>
                    <a class="nav-link" href="{{ route('admin.thongtin.account') }}">
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
                <h3 class="card-title">Thông tin cá nhân</h3>
            </div>
            <div class="card-body">
                @if(!$nhanvien)
                    <div class="alert alert-warning">
                        Chưa có thông tin nhân viên. Vui lòng điền thông tin bên dưới.
                    </div>
                @endif
                <form id="infoForm" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" class="form-control" name="hoten" value="{{ $nhanvien ? $nhanvien->HoTen : '' }}">
                                <small class="text-danger" id="hotenError"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control" name="sdt" value="{{ $nhanvien ? $nhanvien->SDT : '' }}">
                                <small class="text-danger" id="sdtError"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CMND/CCCD</label>
                                <input type="text" class="form-control" name="cccd" value="{{ $nhanvien ? $nhanvien->CCCD : '' }}">
                                <small class="text-danger" id="cccdError"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ngày sinh</label>
                                <input type="date" class="form-control" name="ngaysinh" value="{{ $nhanvien ? $nhanvien->NgaySinh : '' }}">
                                <small class="text-danger" id="ngaysinhError"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Giới tính</label>
                                <select class="form-control" name="gioitinh">
                                    <option value="" selected disabled hidden>Chọn giới tính</option>
                                    <option value="Nam" {{ $nhanvien && $nhanvien->GioiTinh == 'Nam' ? 'selected' : '' }}>Nam</option>
                                    <option value="Nữ" {{ $nhanvien && $nhanvien->GioiTinh == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                </select>
                                <small class="text-danger" id="gioitinhError"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="text" class="form-control" name="diachi" value="{{ $nhanvien ? $nhanvien->DiaChi : '' }}">
                                <small class="text-danger" id="diachiError"></small>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>{{ $nhanvien ? 'Cập nhật thông tin' : 'Lưu thông tin' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#infoForm').on('submit', function(e) {
        e.preventDefault();
        $('.text-danger').text('');

        $.ajax({
            url: '{{ route("admin.thongtin.update") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status) {
                    toastr.success("Cập nhật thông tin thành công!");
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(key => {
                        $(`#${key}Error`).text(errors[key][0]);
                    });
                }
            }
        });
    });
});
</script>
@endpush
@endsection
