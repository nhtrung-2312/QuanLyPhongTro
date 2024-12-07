@extends('Layout.admin')
@section('title', 'Tạo hợp đồng thuê mới')
@section('content')
<div class="card">
    <div class="card-header">
        <div class="">
            <a href="{{ route('admin.hopdongthue.index') }}" class="btn btn-secondary">
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
                                @php
                                    $coSo = \App\Models\CoSo::find(session('selected_facility'));
                                @endphp
                                <label>Cơ sở</label>
                                <input type="text" class="form-control" value=" {{ $coSo->MaCoSo }} - {{ $coSo->TenCoSo }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="MaPhong">Chọn phòng <span class="text-danger">*</span></label>
                                <select class="form-control" id="MaPhong" name="MaPhong" required>
                                    <option value="">-- Chọn phòng --</option>
                                </select>
                                <span class="text-danger" id="MaPhongError"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="thongTinPhong" style="display:none">
                                <div class="form-group">
                                    <label>Diện tích</label>
                                    <input type="text" class="form-control" id="DienTich" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Giá thuê</label>
                                    <input type="text" class="form-control" id="GiaThue" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Số người tối đa</label>
                                    <input type="text" class="form-control" id="SoNguoiToiDa" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin hợp đồng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="NgayBatDau">Ngày bắt đầu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control datepicker" id="NgayBatDau" name="NgayBatDau" required readonly>
                                <span class="text-danger" id="NgayBatDauError"></span>
                            </div>
                            <div class="form-group">
                                <label for="ThoiHan">Thời hạn hợp đồng <span class="text-danger">*</span></label>
                                <select class="form-control" id="ThoiHan" name="ThoiHan" required>
                                    <option value="" selected disabled>-- Chọn thời hạn --</option>
                                    <option value="3">3 tháng</option>
                                    <option value="6">6 tháng</option>
                                    <option value="9">9 tháng</option>
                                    <option value="12">12 tháng</option>
                                </select>
                                <span class="text-danger" id="ThoiHanError"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="NgayKetThuc">Ngày kết thúc</label>
                                <input type="text" class="form-control" id="NgayKetThuc" name="NgayKetThuc" readonly>
                            </div>
                            <div class="form-group">
                                <label for="TienCoc">Tiền cọc <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="TienCoc" name="TienCoc" min="0" required disabled>
                                <span class="text-danger" id="TienCocError"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Phần 3: Dịch vụ -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Dịch vụ sử dụng</h5>
                </div>
                <div class="card-body">
                    <div id="dsDichVu">
                        <!-- Danh sách dịch vụ sẽ được load động -->
                    </div>
                </div>
            </div>

            <!-- Phần 4: Tổng tiền -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin thanh toán</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tổng tiền dịch vụ</label>
                                <input type="text" class="form-control" id="TongTienDichVu" disabled>
                            </div>
                            <div class="form-group">
                                <label>Tiền phòng</label>
                                <input type="text" class="form-control" id="TienPhong" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tiền cọc</label>
                                <input type="text" class="form-control" id="TienCocHienThi" disabled>
                                <input type="hidden" name="TienCoc" id="TienCocInput">
                            </div>
                            <div class="form-group">
                                <label>Tổng tiền hoá đơn</label>
                                <input type="text" class="form-control" id="TongTienHoaDon" disabled>
                                <input type="hidden" name="TongTienHoaDon" id="TongTienHoaDonInput">
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
@push('scripts')
<script>
    $(document).ready(function() {
        let giaThuePhong = 0;
        let tienCoc = 0;
        let tongTienDichVu = 0;

        function tinhTongTien() {
            // Convert all values to integers before calculation
            let giaThuePhongInt = parseInt(giaThuePhong);
            let tongTienDichVuInt = parseInt(tongTienDichVu);
            let tienCocInt = parseInt(tienCoc);

            let tongTienHoaDon = giaThuePhongInt + tongTienDichVuInt;

            $('#TongTienHoaDon').val(tongTienHoaDon.toLocaleString('vi-VN') + ' VNĐ');
            $('#TongTienHoaDonInput').val(tongTienHoaDon);
            $('#TongTienDichVu').val(tongTienDichVuInt.toLocaleString('vi-VN') + ' VNĐ');
            $('#TienPhong').val(giaThuePhongInt.toLocaleString('vi-VN') + ' VNĐ');
            $('#TienCocHienThi').val(tienCocInt.toLocaleString('vi-VN') + ' VNĐ');
            $('#TienCocInput').val(tienCocInt);
        }

        $('.datepicker').datepicker({
            dateFormat: 'dd/mm/yy',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date(),
            minDate: 0,
            regional: 'vi',
            changeMonth: true,
            changeYear: true,
            onSelect: function(dateText, inst) {
                $(this).trigger('change');
            }
        });

        $('#NgayBatDau, #ThoiHan').change(function() {
            let ngayBatDau = $('#NgayBatDau').val();
            let thoiHan = $('#ThoiHan').val();

            if(ngayBatDau && thoiHan) {
                let parts = ngayBatDau.split('/');
                let date = new Date(parts[2], parts[1] - 1, parts[0]); // Đảm bảo thứ tự dd/mm/yyyy
                date.setMonth(date.getMonth() + parseInt(thoiHan));

                let dd = String(date.getDate()).padStart(2, '0');
                let mm = String(date.getMonth() + 1).padStart(2, '0');
                let yyyy = date.getFullYear();

                $('#NgayKetThuc').val(dd + '/' + mm + '/' + yyyy);
            }
        });

        $.ajax({
            url: '{{ route('api.hopdongthue.getPhong') }}',
            type: 'GET',
            success: function(response) {
                let html = '<option value="" selected disabled>-- Chọn phòng --</option>';
                response.data.forEach(function(phong) {
                    html += `<option value="${phong.MaPhong}">${phong.TenPhong}</option>`;
                });
                $('#MaPhong').html(html);
            }, error: function(xhr, status, error) {
                console.log(xhr.responseText);
                toastr.error('Có lỗi xảy ra khi lấy thông tin phòng!');
            }
        });

        $.ajax({
            url: '{{ route('api.loaiphi.getLoaiPhi') }}',
            type: 'GET',
            success: function(response) {
                let html = '';
                response.data.forEach(function(dichvu) {
                    if(dichvu.TenLoaiPhi.toLowerCase().includes('giữ xe')) {
                        html += `
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input dichvu-checkbox" id="dichvu_${dichvu.MaLoaiPhi}"
                                name="dichvu[]" value="${dichvu.MaLoaiPhi}" data-gia="${parseInt(dichvu.DonGia)}">
                            <label class="custom-control-label" for="dichvu_${dichvu.MaLoaiPhi}">
                                ${dichvu.TenLoaiPhi} - ${parseInt(dichvu.DonGia).toLocaleString('vi-VN')} VNĐ
                            </label>
                            <div class="ml-4 mt-2" id="soLuongXe_${dichvu.MaLoaiPhi}" style="display:none">
                                <label>Số lượng xe:</label>
                                <input type="number" class="form-control soluong-xe" name="quantity_${dichvu.MaLoaiPhi}"
                                    min="0" max="5" value="1" onkeydown="return false" data-gia="${parseInt(dichvu.DonGia)}">
                            </div>
                        </div>`;
                    } else {
                        html += `
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input dichvu-checkbox" id="dichvu_${dichvu.MaLoaiPhi}"
                                name="dichvu[]" value="${dichvu.MaLoaiPhi}" data-gia="${parseInt(dichvu.DonGia)}">
                            <input type="hidden" name="quantity_${dichvu.MaLoaiPhi}" value="1">
                            <label class="custom-control-label" for="dichvu_${dichvu.MaLoaiPhi}">
                                ${dichvu.TenLoaiPhi} - ${parseInt(dichvu.DonGia).toLocaleString('vi-VN')} VNĐ
                            </label>
                        </div>`;
                    }
                });
                $('#dsDichVu').html(html);

                // Thêm sự kiện cho checkbox giữ xe và tính tổng tiền
                $('.dichvu-checkbox').change(function() {
                    let gia = parseInt($(this).data('gia'));
                    if(this.checked) {
                        if($(this).parent().find('.soluong-xe').length) {
                            $(`#soLuongXe_${$(this).val()}`).show();
                            tongTienDichVu += gia;
                        } else {
                            tongTienDichVu += gia;
                        }
                    } else {
                        if($(this).parent().find('.soluong-xe').length) {
                            $(`#soLuongXe_${$(this).val()}`).hide();
                            tongTienDichVu -= gia * parseInt($(this).parent().find('.soluong-xe').val());
                        } else {
                            tongTienDichVu -= gia;
                        }
                    }
                    tinhTongTien();
                });

                // Sự kiện thay đổi số lượng xe
                $('.soluong-xe').change(function() {
                    let checkbox = $(this).closest('.custom-control').find('.dichvu-checkbox');
                    if(checkbox.is(':checked')) {
                        let giaXe = parseInt($(this).data('gia'));
                        let soLuongCu = parseInt($(this).data('soluong-cu') || 1);
                        let soLuongMoi = parseInt($(this).val());
                        tongTienDichVu = tongTienDichVu - (giaXe * soLuongCu) + (giaXe * soLuongMoi);
                        $(this).data('soluong-cu', soLuongMoi);
                        tinhTongTien();
                    }
                });
            }, error: function(xhr, status, error) {
                console.log(xhr.responseText);
                toastr.error('Có lỗi xảy ra khi lấy thông tin dịch vụ!');
            }
        });

        $('#MaPhong').change(function() {
            if($(this).val()) {
                $.ajax({
                    url: '{{ route('api.phongtro.getPhong') }}',
                    type: 'GET',
                    data: {
                        id: $(this).val()
                    },
                    success: function(response) {
                        console.log(response.data);
                        $('#DienTich').val(response.data.loaiphong.DienTich + ' m²');
                        giaThuePhong = parseInt(response.data.GiaThue);
                        $('#GiaThue').val(giaThuePhong.toLocaleString('vi-VN') + ' VNĐ');
                        $('#SoNguoiToiDa').val(response.data.loaiphong.SoNguoi + ' người');
                        tienCoc = parseInt(giaThuePhong / 2);
                        $('#TienCoc').val(tienCoc.toLocaleString('vi-VN') + ' VNĐ');
                        $('#thongTinPhong').show();
                        tinhTongTien();
                    }, error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        toastr.error('Có lỗi xảy ra khi lấy thông tin phòng!');
                    }
                });
            } else {
                $('#thongTinPhong').hide();
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
            }
        });

        $('#createForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('admin.hopdongthue.store') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        toastr.success('Tạo hợp đồng thuê thành công!');
                        setTimeout(function() {
                            window.location.href = '{{ route('admin.hopdongthue.index') }}';
                        }, 500);
                    }
                },
                error: function(xhr, status, error) {
                    if(xhr.status == 422) {
                        let errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            $('#' + key + 'Error').text(errors[key][0]);
                        });
                    } else {
                        console.log(xhr.responseText);
                        toastr.error('Có lỗi xảy ra khi tạo hợp đồng thuê!');
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection
