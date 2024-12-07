@extends('Layout.admin')
@section('title', 'Phân quyền tài khoản')
@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <a href="{{ route('admin.nhanvien.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
        </div>
    </div>
    <div class="card-body">
        @if($taikhoans->isEmpty())
            <div class="text-center">
                <p>Không có tài khoản nào</p>
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center align-left">
                        <th>STT</th>
                        <th>Mã tài khoản</th>
                        <th>Tên đăng nhập</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($taikhoans as $taikhoan)
                    <tr class="text-center align-left">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $taikhoan->MaTaiKhoan }}</td>
                        <td>{{ $taikhoan->TenDangNhap }}</td>
                        <td>{{ $taikhoan->VaiTro }}</td>
                        <td>
                            @if($taikhoan->TrangThai == 1)
                                <span class="badge badge-success">Hoạt động</span>
                            @else
                                <span class="badge badge-danger">Khóa</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editQuyen('{{ $taikhoan->MaTaiKhoan }}')">
                                <i class="fas fa-edit"></i> Phân quyền
                            </button>
                            @if($taikhoan->TrangThai == 1)
                                <button class="btn btn-sm btn-danger" onclick="khoaTaiKhoan('{{ $taikhoan->MaTaiKhoan }}')">
                                    <i class="fas fa-lock"></i> Khóa
                                </button>
                            @else
                                <button class="btn btn-sm btn-success" onclick="moKhoaTaiKhoan('{{ $taikhoan->MaTaiKhoan }}')">
                                    <i class="fas fa-unlock"></i> Mở khóa
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection
