@extends('Layout.admin')
@section('title', 'Danh sách khách hàng')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <a href="{{ route('admin.khachhang.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm khách hàng
            </a>
        </div>
        @if($khachhangs->isEmpty())
            <div class="text-center">
                <p>Không có khách đang thuê</p>
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center align-left">
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($khachhangs as $khachhang)
                    <tr class="text-center align-left">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $khachhang->HoTen }}</td>
                        <td>{{ $khachhang->SDT }}</td>
                        <td>{{ $khachhang->DiaChi }}</td>
                        <td>{{ $khachhang->NgaySinh }}</td>
                        <td>{{ $khachhang->GioiTinh }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editKhachHang('{{ $khachhang->MaKhachThue }}')">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <span class="p-5">
            </div>
            <div class="d-flex justify-content-center">
                {{ $khachhangs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa khách hàng</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_MaKhachThue">
                    <div class="form-group mb-3">
                        <label for="edit_HoTen">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_HoTen" name="HoTen">
                        <span class="text-danger" id="edit_HoTenError"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_SDT">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="edit_SDT" name="SDT">
                        <span class="text-danger" id="edit_SDTError"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_DiaChi">Địa chỉ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_DiaChi" name="DiaChi">
                        <span class="text-danger" id="edit_DiaChiError"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_CCCD">CCCD <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_CCCD" name="CCCD">
                        <span class="text-danger" id="edit_CCCDError"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_NgaySinh">Ngày sinh <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="edit_NgaySinh" name="NgaySinh">
                        <span class="text-danger" id="edit_NgaySinhError"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_GioiTinh">Giới tính <span class="text-danger">*</span></label>
                        <select class="form-control" id="edit_GioiTinh" name="GioiTinh">
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                        <span class="text-danger" id="edit_GioiTinhError"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="updateKhachHang()">Cập nhật</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function editKhachHang(maKhachThue) {
        $.ajax({
            url: `/admin/khachhang/edit/${maKhachThue}`,
            type: 'GET',
            success: function(response) {
                $('#edit_MaKhachThue').val(response.MaKhachThue);
                $('#edit_HoTen').val(response.HoTen);
                $('#edit_SDT').val(response.SDT);
                $('#edit_DiaChi').val(response.DiaChi);
                $('#edit_CCCD').val(response.CCCD);
                $('#edit_NgaySinh').val(response.NgaySinh);
                $('#edit_GioiTinh').val(response.GioiTinh);
                $('#editModal').modal('show');
            },
            error: function(xhr) {
                toastr.error('Có lỗi xảy ra khi lấy thông tin!');
            }
        });
    }
    function updateKhachHang() {
        $.ajax({
            url: `/admin/khachhang/update/${$('#edit_MaKhachThue').val()}`,
            type: 'PUT',
            data: $('#editForm').serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success('Cập nhật khách hàng thành công!');
                    window.location.reload();
                } else {
                    console.log(response.data);
                }
            },
            error: function(xhr) {
                console.log(xhr.responseJSON);
                $('#edit_HoTenError').text(xhr.responseJSON.errors.HoTen);
                $('#edit_SDTError').text(xhr.responseJSON.errors.SDT);
                $('#edit_DiaChiError').text(xhr.responseJSON.errors.DiaChi);
                $('#edit_CCCDError').text(xhr.responseJSON.errors.CCCD);
                $('#edit_NgaySinhError').text(xhr.responseJSON.errors.NgaySinh);
                $('#edit_GioiTinhError').text(xhr.responseJSON.errors.GioiTinh);
            }
        });
    }
</script>
@endpush
@endsection
