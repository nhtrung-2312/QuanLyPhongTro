@extends('Layout.admin')
@section('title', 'Thêm hóa đơn')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="">
            <a href="{{ route('admin.hoadon.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay về
            </a>
        </div>
    </div>
    <div class="card-body">
        <form id="createForm" method="POST">
            @csrf
            <!-- Phần 0: Thông tin cá nhân -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin khách hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="SoDienThoai">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="SoDienThoai" name="SoDienThoai" required>
                                <span class="text-danger" id="SoDienThoaiError"></span>
                            </div>
                            <div class="form-group">
                                <label for="CCCD">Số CCCD <span class="text-danger">*</span></label>
                                <input type="text" disabled class="form-control" id="CCCD" name="CCCD" required>
                                <span class="text-danger" id="CCCDError"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="HoTen">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" disabled class="form-control" id="HoTen" name="HoTen" required>
                                <span class="text-danger" id="HoTenError"></span>
                            </div>
                            <div class="form-group">
                                <label for="GioiTinh">Giới tính <span class="text-danger">*</span></label>
                                <select class="form-control" disabled id="GioiTinh" name="GioiTinh" required>
                                    <option value="" selected disabled>-- Chọn giới tính --</option>
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                                <span class="text-danger" id="GioiTinhError"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Phần 1: Thông tin khách hàng -->

            <!-- Phần 2: Thông tin phòng -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin phòng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="MaPhong">Chọn phòng <span class="text-danger">*</span></label>
                                <select class="form-control" id="MaPhong" name="MaPhong" required>
                                    <option value="">-- Chọn phòng --</option>
                                </select>
                                <span class="text-danger" id="MaPhongError"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="thongTinPhong">
                                <div class="form-group">
                                    <label>Ngày thuê</label>
                                    <input type="text" class="form-control" id="NgayBatDau" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Ngày hết hạn</label>
                                    <input type="text" class="form-control" id="NgayKetThuc" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin hoá đơn</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="TienDien">Tiền điện trước</label>
                                <input type="number" class="form-control" id="TienDien" name="TienDien" required>
                                <span class="text-danger" id="TienDienError"></span>
                            </div>
                            <div class="form-group">
                                <label for="TienDien">Tiền điện hiện tại</label>
                                <input type="number" class="form-control" id="TienDien" name="TienDien" required>
                                <span class="text-danger" id="TienDienError"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="TienNuoc">Tiền nước trước</label>
                                <input type="number" class="form-control" id="TienNuoc" name="TienNuoc" required>
                                <span class="text-danger" id="TienNuocError"></span>
                            </div>
                            <div class="form-group">
                                <label for="TienNuoc">Tiền nước hiện tại</label>
                                <input type="number" class="form-control" id="TienNuoc" name="TienNuoc" required>
                                <span class="text-danger" id="TienNuocError"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Tạo hợp đồng
                </button>
                <a href="{{ route('admin.hopdongthue.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#SoDienThoai').change(function() {
        let sdt = $(this).val();
        if(sdt) {
            $.ajax({
                url: '{{ route('api.khachhang.getKhachHang') }}',
                type: 'GET',
                data: {
                    sdt: sdt
                },
                success: function(response) {
                    if(response.success) {
                        $('#HoTen').val(response.data.HoTen);
                        $('#CCCD').val(response.data.CCCD);
                        $('#GioiTinh').val(response.data.GioiTinh);
                        $('#SoDienThoaiError').text('');
                    }
                },
                error: function(xhr, status, error) {
                    if(xhr.status == 422) {
                        $('#HoTen').val('');
                        $('#CCCD').val('');
                        $('#GioiTinh').val('');
                        $('#SoDienThoaiError').text('Không tìm thấy thông tin khách hàng!');
                    } else {
                        toastr.error('Có lỗi xảy ra khi lấy thông tin khách hàng!');
                    }
                }
            });
        } else {
            $('#HoTen').val('');
            $('#CCCD').val('');
            $('#GioiTinh').val('');
            $('#MaPhong').html('<option value="" selected disabled>-- Chọn phòng --</option>');
        }
    });
});
</script>
@endpush
