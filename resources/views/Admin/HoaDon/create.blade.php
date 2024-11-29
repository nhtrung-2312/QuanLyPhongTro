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
                <!-- Cột trái - Thông tin hóa đơn -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thông tin hóa đơn</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="MaCoSo">Cơ sở</label>
                                <select name="MaCoSo" class="form-control" id="MaCoSo" required>
                                    <option value="">Chọn cơ sở</option>
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
                                    <option value="">Chọn phòng</option>
                                    @foreach($phongs as $phong)
                                        <option value="{{ $phong->MaPhong }}">{{ $phong->TenPhong }}</option>
                                    @endforeach
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
                                </select>
                                @error('TrangThai')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột phải - Chi tiết các khoản phí -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Chi tiết các khoản phí</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="chiPhiTable">
                                    <thead>
                                        <tr>
                                            <th>Loại phí</th>
                                            <th>Số lượng</th>
                                            <th>Đơn giá</th>
                                            <th>Thành tiền</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="chitiet[0][MaLoaiPhi]" class="form-control loaiphi-select" required>
                                                    <option value="">Chọn loại phí</option>
                                                    @foreach($loaiphis as $loaiphi)
                                                        <option value="{{ $loaiphi->MaLoaiPhi }}" data-dongia="{{ $loaiphi->DonGia }}">
                                                            {{ $loaiphi->TenLoaiPhi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="chitiet[0][SoLuong]" class="form-control soluong" min="1" value="1">
                                            </td>
                                            <td>
                                                <input type="number" name="chitiet[0][DonGia]" class="form-control dongia" readonly>
                                            </td>
                                            <td>
                                                <input type="number" name="chitiet[0][ThanhTien]" class="form-control thanhtien" readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm delete-row">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success" id="addRow">
                                    <i class="fas fa-plus"></i> Thêm khoản phí
                                </button>
                            </div>
                            <div class="form-group mt-3">
                                <label for="TongTien">Tổng tiền</label>
                                <input type="number" name="TongTien" id="TongTien" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Tạo hóa đơn</button>
                <a href="{{ route('admin.hoadon.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Log để kiểm tra khi trang được load
    console.log('Page loaded');

    // Xử lý khi thay đổi cơ sở
    $('#MaCoSo').change(function() {
        var maCoSo = $(this).val();
        console.log('Selected MaCoSo:', maCoSo);

        if(maCoSo) {
            $.ajax({
                url: '/admin/get-phong-by-coso/' + maCoSo,
                type: 'GET',
                success: function(data) {
                    console.log('Received data:', data);
                    $('#MaPhong').empty();
                    $('#MaPhong').append('<option value="">Chọn phòng</option>');
                    
                    if(data.length > 0) {
                        $.each(data, function(key, value) {
                            $('#MaPhong').append(
                                '<option value="' + value.MaPhong + '">' + 
                                    'Phòng ' + value.TenPhong + ' - ' + value.TenKhachHang +
                                '</option>'
                            );
                        });
                    } else {
                        $('#MaPhong').append('<option value="" disabled>Không có phòng đang thuê</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Ajax error:', error);
                    console.error('Response:', xhr.responseText);
                }
            });
        }
    });

    // Xử lý khi thay đổi loại phí
    $(document).on('change', '.loaiphi-select', function() {
        var donGia = $(this).find(':selected').data('dongia');
        var row = $(this).closest('tr');
        row.find('.dongia').val(donGia);
        tinhThanhTien(row);
    });

    // Xử lý khi thay đổi số lượng
    $(document).on('change', '.soluong', function() {
        var row = $(this).closest('tr');
        tinhThanhTien(row);
    });

    // Thêm dòng mới
    let rowIndex = 1;
    $('#addRow').click(function() {
        let newRow = $('#chiPhiTable tbody tr:first').clone();
        newRow.find('input').val('');
        newRow.find('select').val('');
        // Cập nhật name attributes
        newRow.find('[name^="chitiet[0]"]').each(function() {
            $(this).attr('name', $(this).attr('name').replace('[0]', '[' + rowIndex + ']'));
        });
        $('#chiPhiTable tbody').append(newRow);
        rowIndex++;
    });

    // Xóa dòng
    $(document).on('click', '.delete-row', function() {
        if($('#chiPhiTable tbody tr').length > 1) {
            $(this).closest('tr').remove();
            tinhTongTien();
        }
    });

    // Hàm tính thành tiền
    function tinhThanhTien(row) {
        var soLuong = parseFloat(row.find('.soluong').val()) || 0;
        var donGia = parseFloat(row.find('.dongia').val()) || 0;
        var thanhTien = soLuong * donGia;
        row.find('.thanhtien').val(thanhTien);
        tinhTongTien();
    }

    // Hàm tính tổng tiền
    function tinhTongTien() {
        var tongTien = 0;
        $('.thanhtien').each(function() {
            tongTien += parseFloat($(this).val()) || 0;
        });
        $('#TongTien').val(tongTien);
    }

    // Xử lý submit form
    $('form').on('submit', function(e) {
        e.preventDefault();
        console.log('Form submitted');
        console.log('Form data:', $(this).serialize());

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log('Response:', response);
                if (response.status) {
                    toastr.success(response.message);
                    setTimeout(function() {
                        window.location.href = "{{ route('admin.hoadon.index') }}";
                    }, 1500);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Ajax error:', error);
                console.error('Response:', xhr.responseText);
                toastr.error('Có lỗi xảy ra khi tạo hóa đơn');
            }
        });
    });
});
</script>
@endpush