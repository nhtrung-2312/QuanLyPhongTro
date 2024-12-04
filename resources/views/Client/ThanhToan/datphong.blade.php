@extends('Layout.client')
@section('title', 'Thanh toán đặt phòng')
@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Cột trái - Thông tin chi tiết -->
        <div class="col-lg-9">
            <!-- Thông tin phòng -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin phòng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ file_exists(public_path('template/client/dist/img/phong/' . $phong->MaPhong . '.png'))
                            ? '/template/client/dist/img/phong/' . $phong->MaPhong . '.png'
                            : '/template/client/dist/img/phong/noimage.png' }}"
                            alt="Hình ảnh"
                            class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $phong->TenPhong }}</h4>
                            <p><strong>Loại phòng:</strong> {{ $phong->loaiPhong->LoaiPhong }}</p>
                            <p><strong>Diện tích:</strong> {{ $phong->loaiPhong->DienTich }}m²</p>
                            <p><strong>Địa chỉ:</strong> {{ $phong->coSo->DiaChi }}</p>
                            <p><strong>Giá thuê:</strong> {{ number_format($phong->GiaThue, 0, ',', '.') }} VNĐ/tháng</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin khách hàng -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin khách hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" class="form-control" value="{{ $khachthue->HoTen }}" readonly>
                            </div>
                            <div class="form-group mt-3">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control" value="{{ $khachthue->SDT }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ngày bắt đầu thuê</label>
                                <input type="text" class="form-control" id="ngayBatDau" name="ngay_bat_dau" onchange="updateNgayKetThuc()" placeholder="dd/mm/yyyy">
                            </div>
                            <div class="form-group mt-3">
                                <label class="d-block mb-2">Thời hạn thuê</label>
                                <select class="form-control" id="thoiHanThue" name="thoi_han" onchange="updateNgayKetThuc()">
                                    <option value="3">3 tháng</option>
                                    <option value="6">6 tháng</option>
                                    <option value="12">12 tháng</option>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" id="ngayKetThuc" readonly hidden>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dịch vụ đăng ký -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Dịch vụ đăng ký</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $dichVu = DB::table('loaiphi')
                                ->whereNotIn('TenLoaiPhi', ['Tiền điện', 'Tiền nước', 'Phí khác'])
                                ->get();
                        @endphp
                        @foreach ($dichVu as $dv)
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    @if(str_contains(strtolower($dv->TenLoaiPhi), 'xe'))
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input service-checkbox" type="checkbox" id="{{ $dv->MaLoaiPhi }}" data-price="{{ $dv->DonGia }}">
                                            <label class="form-check-label mx-2" for="{{ $dv->MaLoaiPhi }}">
                                                {{ $dv->TenLoaiPhi }} - {{ number_format($dv->DonGia, 0, ',', '.') }}đ/xe
                                            </label>
                                            <input type="number"
                                                class="form-control form-control-sm w-25"
                                                id="soXe_{{ $dv->MaLoaiPhi }}"
                                                min="0"
                                                max="5"
                                                value="0"
                                                disabled
                                                oninput="this.value = this.value.replace(/[^0-5]/g, ''); if(this.value > 5) this.value = 5;">
                                        </div>
                                    @else
                                        <input class="form-check-input service-checkbox" type="checkbox" id="{{ $dv->MaLoaiPhi }}" data-price="{{ $dv->DonGia }}">
                                        <label class="form-check-label" for="{{ $dv->MaLoaiPhi }}">
                                            {{ $dv->TenLoaiPhi }} - {{ number_format($dv->DonGia, 0, ',', '.') }}đ/tháng
                                        </label>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Phương thức thanh toán -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Phương thức thanh toán</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment" id="cash" checked>
                        <label class="form-check-label" for="cash">Tiền mặt</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" id="momo">
                        <label class="form-check-label" for="momo">Ví điện tử MoMo</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột phải - Tổng tiền -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Chi tiết thanh toán</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tiền phòng:</span>
                        <span>{{ number_format($phong->GiaThue, 0, ',', '.') }} VNĐ</span>
                    </div>
                    <div id="serviceDetails">
                        <!-- Các dịch vụ sẽ được thêm vào đây bằng JavaScript -->
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Tổng tiền:</strong>
                        <strong id="totalAmount">{{ number_format($phong->GiaThue, 0, ',', '.') }} VNĐ</strong>
                    </div>
                    <button class="btn btn-primary w-100" onclick="showConfirmModal()">Đặt phòng</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận đặt phòng</h5>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <p class="text-black">Bạn có chắc chắn muốn đặt phòng với thông tin sau:</p>
                <div>
                    <p>Phòng: {{ $phong->TenPhong }}</p>
                    <p>Thời hạn: <span id="modalThoiHan"></span></p>
                    <p>Ngày bắt đầu: <span id="modalNgayBatDau"></span></p>
                    <p>Ngày kết thúc: <span id="modalNgayKetThuc"></span></p>
                    <p>Tổng tiền: <span id="modalTongTien"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="confirmBooking()">Xác nhận</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let selectedServices = [];
    const basePrice = {{ $phong->GiaThue }};

    $('.service-checkbox').change(function() {
        const id = $(this).attr('id');
        const soXeInput = $(`#soXe_${id}`);
        if (soXeInput.length) {
            soXeInput.prop('disabled', !$(this).is(':checked'));
            if (!$(this).is(':checked')) {
                soXeInput.val(0);
            }
        }
        calculateTotal();
    });

    $('input[id^="soXe_"]').change(function() {
        calculateTotal();
    });

    function calculateTotal() {
        let total = basePrice;
        selectedServices = [];

        $('.service-checkbox:checked').each(function() {
            const id = $(this).attr('id');
            const price = parseInt($(this).data('price'));
            const serviceName = $(this).next('label').text().split('-')[0].trim();
            const soXeInput = $(`#soXe_${id}`);

            if (soXeInput.length) {
                const soXe = parseInt(soXeInput.val()) || 0;
                const totalPrice = price * soXe;
                total += totalPrice;
                selectedServices.push({name: serviceName, price: totalPrice, quantity: soXe});
            } else {
                total += price;
                selectedServices.push({name: serviceName, price: price});
            }
        });

        let serviceHTML = '';
        selectedServices.forEach(service => {
            serviceHTML += `
                <div class="d-flex justify-content-between mb-2">
                    <span>${service.name}${service.quantity ? ` (${service.quantity} xe)` : ''}:</span>
                    <span>${number_format(service.price)} VNĐ</span>
                </div>
            `;
        });
        $('#serviceDetails').html(serviceHTML);

        $('#totalAmount').text(number_format(total) + ' VNĐ');
    }

    function updateNgayKetThuc() {
        const ngayBatDauStr = $('#ngayBatDau').val();
        const parts = ngayBatDauStr.split('/');
        const ngayBatDau = new Date(parts[2], parts[1] - 1, parts[0]);
        const thoiHan = parseInt($('#thoiHanThue').val());

        if (!isNaN(ngayBatDau.getTime())) {
            const ngayKetThuc = new Date(ngayBatDau);
            ngayKetThuc.setMonth(ngayKetThuc.getMonth() + thoiHan);

            const dd = String(ngayKetThuc.getDate()).padStart(2, '0');
            const mm = String(ngayKetThuc.getMonth() + 1).padStart(2, '0');
            const yyyy = ngayKetThuc.getFullYear();

            $('#ngayKetThuc').val(`${dd}/${mm}/${yyyy}`);
        }
    }

    function showConfirmModal() {
        const ngayBatDauStr = $('#ngayBatDau').val();
        if (!ngayBatDauStr) {
            toastr.error('Vui lòng chọn ngày bắt đầu thuê');
            return;
        }

        const parts = ngayBatDauStr.split('/');
        const ngayBatDau = new Date(parts[2], parts[1] - 1, parts[0]);
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        if (ngayBatDau < today) {
            toastr.error('Ngày bắt đầu thuê phải từ ngày hiện tại trở đi');
            return;
        }

        let hasInvalidVehicle = false;
        $('.service-checkbox:checked').each(function() {
            const id = $(this).attr('id');
            const soXeInput = $(`#soXe_${id}`);
            if (soXeInput.length) {
                const soXe = parseInt(soXeInput.val()) || 0;
                if (soXe === 0) {
                    hasInvalidVehicle = true;
                    return false;
                }
            }
        });

        if (hasInvalidVehicle) {
            toastr.error('Vui lòng nhập số lượng xe cho dịch vụ đã chọn');
            return;
        }

        const thoiHan = $('#thoiHanThue').val();
        const tongTien = $('#totalAmount').text();
        const ngayKetThuc = $('#ngayKetThuc').val();

        $('#modalThoiHan').text(thoiHan + ' tháng');
        $('#modalNgayBatDau').text(ngayBatDauStr);
        $('#modalNgayKetThuc').text(ngayKetThuc);
        $('#modalTongTien').text(tongTien);

        $('#confirmModal').modal('show');
    }

    function confirmBooking() {
        const ngayBatDauStr = $('#ngayBatDau').val();
        const parts = ngayBatDauStr.split('/');
        const ngayBatDauISO = `${parts[2]}-${parts[1]}-${parts[0]}`;

        $.ajax({
            url: '{{ route("thanhToan.bill", ["id" => $phong->MaPhong]) }}',
            type: 'POST',
            data: {
                ngay_bat_dau: ngayBatDauISO,
                thoi_han: $('#thoiHanThue').val(),
                services: selectedServices,
                payment_method: $('input[name="payment"]:checked').attr('id'),
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Đặt phòng thành công');
                    setTimeout(() => {
                        window.location.href = response.redirectUrl;
                    }, 1500);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Có lỗi xảy ra, vui lòng thử lại');
            }
        });
    }

    function number_format(number) {
        return new Intl.NumberFormat('vi-VN').format(number);
    }

    // Thêm datepicker cho input ngày
    $(document).ready(function() {
        $('#ngayBatDau').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date()
        });
    });
</script>
@endpush
