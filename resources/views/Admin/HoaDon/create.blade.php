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
        <form id="createForm" method="POST" action="{{ route('admin.hoadon.store') }}">
            @csrf
            <!-- Phần 1: Thông tin khách hàng -->
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
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="TenKhachHang">Tên khách hàng</label>
                                <input type="text" class="form-control" id="TenKhachHang" name="TenKhachHang" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="CCCD">CCCD</label>
                                <input type="text" class="form-control" id="CCCD" name="CCCD" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="GioiTinh">Giới tính</label>
                                <input type="text" class="form-control" id="GioiTinh" name="GioiTinh" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Phần 2: Danh sách phòng đã thuê, thời gian thuê -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Danh sách phòng đã thuê, thời gian thuê</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="phongDaThue">Phòng đã thuê</label>
                                <select class="form-control" id="phongDaThue" name="phongDaThue" onchange="showHoaDonTruocDo(this.value)">
                                    <option value="">Chọn phòng</option>
                                    <!-- Danh sách phòng sẽ được hiển thị động -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Phần 3: Chỉ số điện nước -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Chỉ số điện nước</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Chỉ số điện cũ</label>
                                <input type="number" class="form-control" id="DienCu" name="DienCu" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Chỉ số điện mới <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="DienMoi" name="DienMoi" required min="0" onkeydown="return event.keyCode !== 69" style="-webkit-appearance: none; -moz-appearance: textfield;">
                                <span class="text-danger" id="DienMoiError"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Chỉ số nước cũ</label>
                                <input type="number" class="form-control" id="NuocCu" name="NuocCu" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Chỉ số nước mới <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="NuocMoi" name="NuocMoi" required min="0" onkeydown="return event.keyCode !== 69" style="-webkit-appearance: none; -moz-appearance: textfield;">
                                <span class="text-danger" id="NuocMoiError"></span>
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
    function showHoaDonTruocDo(maPhong) {
    $.ajax({
        url: '{{ route('api.hoadon.getHoaDonByPhong') }}',
        type: 'GET',
        data: {
            maPhong: maPhong
        },
        success: function(response) {
            if(response.success) {
                $('#DienCu').val(response.data.DienMoi);
                $('#NuocCu').val(response.data.NuocMoi);

                // Reset validation errors
                $('#DienMoiError').text('');
                $('#NuocMoiError').text('');

                // Set min values for new readings
                $('#DienMoi').attr('min', response.data.DienMoi);
                $('#NuocMoi').attr('min', response.data.NuocMoi);
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseJSON);
            console.error('Có lỗi xảy ra khi lấy hoá đơn trước đó của phòng!');
        }
    });
}

$(document).ready(function() {
    // Validate form before submit
    $('#createForm').on('submit', function(e) {
        let isValid = true;
        const dienCu = parseInt($('#DienCu').val()) || 0;
        const dienMoi = parseInt($('#DienMoi').val()) || 0;
        const nuocCu = parseInt($('#NuocCu').val()) || 0;
        const nuocMoi = parseInt($('#NuocMoi').val()) || 0;

        if (dienMoi < dienCu) {
            $('#DienMoiError').text('Chỉ số điện mới không được nhỏ hơn chỉ số cũ');
            isValid = false;
        } else {
            $('#DienMoiError').text('');
        }

        if (nuocMoi < nuocCu) {
            $('#NuocMoiError').text('Chỉ số nước mới không được nhỏ hơn chỉ số cũ');
            isValid = false;
        } else {
            $('#NuocMoiError').text('');
        }

        if (!isValid) {
            e.preventDefault();
            return false;
        }
    });

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
                        console.log(response.data);
                        $('#TenKhachHang').val(response.data.HoTen);
                        $('#CCCD').val(response.data.CCCD);
                        $('#GioiTinh').val(response.data.GioiTinh);
                        $('#SoDienThoaiError').text('');
                        // Cập nhật danh sách phòng đã thuê và các dịch vụ đã đăng ký
                        $.ajax({
                            url: '{{ route('api.phong.getPhongDaThue') }}',
                            type: 'GET',
                            data: {
                                maKhachThue: response.data.MaKhachThue
                            },
                            success: function(response) {
                                if(response.success) {
                                    console.log(response.data);
                                    $('#phongDaThue').html('');
                                    $('#phongDaThue').append(`<option value="" selected disabled>Chọn phòng</option>`);
                                    response.data.forEach(phong => {
                                        $('#phongDaThue').append(`<option value="${phong.MaPhong}">Phòng: ${phong.TenPhong}, Thời gian thuê: ${phong.hopdongthue[0].NgayBatDau} - ${phong.hopdongthue[0].NgayKetThuc}</option>`);
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Có lỗi xảy ra khi lấy danh sách phòng đã thuê!');
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    if(xhr.status == 422) {
                        $('#TenKhachHang').val('');
                        $('#CCCD').val('');
                        $('#GioiTinh').val('');
                        $('#SoDienThoaiError').text('Không tìm thấy thông tin khách hàng!');
                    } else {
                        console.error('Có lỗi xảy ra khi lấy thông tin khách hàng!');
                    }
                }
            });
        } else {
            $('#TenKhachHang').val('');
            $('#CCCD').val('');
            $('#GioiTinh').val('');
        }
    });

    $('#createForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Tạo hóa đơn thành công!');
                    setTimeout(function() {
                        window.location.href = '{{ route('admin.hoadon.index') }}';
                    }, 500);
                } else {
                    console.log(response.data);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseJSON);
                toastr.error('Có lỗi xảy ra khi tạo hóa đơn!');
            }
        });
    });
});


</script>
@endpush
