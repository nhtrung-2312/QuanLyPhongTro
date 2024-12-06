@extends('Layout.admin')
@section('title', 'Danh sách nhân viên')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <a href="{{ route('admin.nhanvien.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm nhân viên
            </a>
        </div>
        @if($nhanviens->isEmpty())
            <div class="text-center">
                <p>Không có nhân viên nào</p>
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center align-left">
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Số điện thoại</th>
                        <th>CCCD</th>
                        <th>Địa chỉ</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Vai trò</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nhanviens as $nhanvien)
                    <tr class="text-center align-left">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $nhanvien->HoTen }}</td>
                        <td>{{ $nhanvien->SDT }}</td>
                        <td>{{ $nhanvien->CCCD }}</td>
                        <td>{{ $nhanvien->DiaChi }}</td>
                        <td>{{ $nhanvien->NgaySinh }}</td>
                        <td>{{ $nhanvien->GioiTinh }}</td>
                        <td> {{ $nhanvien->ChucVu }} </td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editNhanVien('{{ $nhanvien->MaNhanVien }}')">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteNhanVien('{{ $nhanvien->MaNhanVien }}')">
                                <i class="fas fa-trash"></i> Xóa
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
                {{ $nhanviens->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa nhân viên</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_MaNhanVien">
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
                <button type="button" class="btn btn-primary" onclick="updateNhanVien()">Cập nhật</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function editNhanVien(maNhanVien) {
        $('#editModal').modal('show');
    }
</script>
@endpush
@endsection
