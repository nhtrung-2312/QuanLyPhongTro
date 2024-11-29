@extends('Layout.admin')
@section('title', 'Chỉnh sửa phòng')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Chỉnh sửa thông tin phòng</h3>
        <div class="card-tools">
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.rooms.update', $phongs->MaPhong) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="TenPhong">Tên Phòng <span class="text-danger">*</span></label>
                        <input type="text" name="TenPhong" class="form-control" 
                            value="{{ old('TenPhong', $phongs->TenPhong) }}" 
                            placeholder="Nhập tên phòng" required>
                        @error('TenPhong')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="GiaThue">Giá Thuê <span class="text-danger">*</span></label>
                        <input type="number" name="GiaThue" class="form-control" 
                            value="{{ old('GiaThue', $phongs->GiaThue) }}" 
                            placeholder="Nhập giá thuê" required>
                        @error('GiaThue')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="TrangThai">Trạng Thái <span class="text-danger">*</span></label>
                        <select name="TrangThai" class="form-control" required>
                            <option value="Đang thuê" {{ $phongs->TrangThai == 'Đang thuê' ? 'selected' : '' }}>Đang thuê</option>
                            <option value="Đang xử lý" {{ $phongs->TrangThai == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="Phòng trống" {{ $phongs->TrangThai == 'Phòng trống' ? 'selected' : '' }}>Phòng trống</option>
                        </select>
                        @error('TrangThai')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="MoTa">Mô Tả</label>
                <textarea name="MoTa" class="form-control" rows="3" placeholder="Nhập mô tả">{{ old('MoTa', $phongs->MoTa) }}</textarea>
                @error('MoTa')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="text-right mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật
                </button>
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-default">
                    <i class="fas fa-times"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection