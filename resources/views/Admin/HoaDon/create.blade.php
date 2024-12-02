@extends('Layout.admin')                    
@section('title', 'Thêm hóa đơn')

@push('styles')
<!-- Thêm các style cụ thể nếu cần -->
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.hoadon.store') }}">
            @csrf
            <div class="row">
                <!-- Thông tin cơ bản -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thông tin hóa đơn</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Thông tin cơ bản bên trái -->
                                    <div class="form-group">
                                        <label for="MaCoSo">Cơ sở</label>
                                        <select name="MaCoSo" class="form-control" id="MaCoSo" required>
                                            <option value="" selected hidden>Chọn cơ sở</option>
                                            @foreach($cosos as $coso)
                                                <option value="{{ $coso->MaCoSo }}">{{ $coso->TenCoSo }}</option>
                                            @endforeach
                                        </select>
                                        @error('MaCoSo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="MaPhong">Phòng</label>
                                        <select name="MaPhong" class="form-control" id="MaPhong" required>
                                            <option value="" selected hidden>Chọn phòng</option>
                                        </select>
                                        @error('MaPhong')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="NgayLap">Ngày lập</label>
                                        <input type="date" name="NgayLap" class="form-control" value="{{ old('NgayLap', date('Y-m-d')) }}" required>
                                        @error('NgayLap')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="TrangThai">Trạng thái</label>
                                        <select name="TrangThai" class="form-control" required>
                                            <option value="Đang xử lý" selected>Đang xử lý</option>
                                            <option value="Đã thanh toán">Đã thanh toán</option>
                                            <option value="Hủy">Hủy</option>
                                        </select>
                                        @error('TrangThai')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- Thông tin chỉ số bên phải -->
                                    <div class="form-group">
                                        <label for="ChiSoDienCu">Chỉ số điện cũ</label>
                                        <input type="number" name="ChiSoDienCu" class="form-control" required>
                                        @error('ChiSoDienCu')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="ChiSoDienMoi">Chỉ số điện mới</label>
                                        <input type="number" name="ChiSoDienMoi" class="form-control" required>
                                        @error('ChiSoDienMoi')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="ChiSoNuocCu">Chỉ số nước cũ</label>
                                        <input type="number" name="ChiSoNuocCu" class="form-control" required>
                                        @error('ChiSoNuocCu')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="ChiSoNuocMoi">Chỉ số nước mới</label>
                                        <input type="number" name="ChiSoNuocMoi" class="form-control" required>
                                        @error('ChiSoNuocMoi')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="TongTien">Tổng tiền</label>
                                        <input type="number" name="TongTien" id="TongTien" class="form-control" readonly>
                                        @error('TongTien')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">Tạo hóa đơn</button>
                                <a href="{{ route('admin.hoadon.index') }}" class="btn btn-secondary">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#MaCoSo').change(function() {
        var maCoSo = $(this).val();
        if(maCoSo) {
            // Xóa tất cả option cũ trừ option mặc định
            $('#MaPhong').find('option').not(':first').remove();
            
            // Lọc phòng theo cơ sở được chọn
            @foreach($cosos as $coso)
                if('{{ $coso->MaCoSo }}' === maCoSo) {
                    @foreach($coso->phongTro as $phong)
                        $('#MaPhong').append(new Option('{{ $phong->TenPhong }}', '{{ $phong->MaPhong }}'));
                    @endforeach
                }
            @endforeach
        } else {
            $('#MaPhong').find('option').not(':first').remove();
        }
    });
});
</script>
@endpush