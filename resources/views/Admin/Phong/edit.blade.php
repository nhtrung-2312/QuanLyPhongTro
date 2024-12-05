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

        <form action="{{ route('admin.rooms.update', $phong->MaPhong) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="TenPhong">Tên Phòng <span class="text-danger">*</span></label>
                        <input type="text" name="TenPhong" class="form-control" 
                            value="{{ old('TenPhong', $phong->TenPhong) }}" 
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
                            value="{{ old('GiaThue', $phong->GiaThue) }}" 
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
                            <option value="Đang thuê" {{ $phong->TrangThai == 'Đang thuê' ? 'selected' : '' }}>Đang thuê</option>
                            <option value="Đang xử lý" {{ $phong->TrangThai == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="Phòng trống" {{ $phong->TrangThai == 'Phòng trống' ? 'selected' : '' }}>Phòng trống</option>
                        </select>
                        @error('TrangThai')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="MoTa">Mô Tả</label>
                <textarea name="MoTa" class="form-control" rows="3" placeholder="Nhập mô tả">{{ old('MoTa', $phong->MoTa) }}</textarea>
                @error('MoTa')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="HinhAnh">Hình ảnh hiện tại</label>
                        @php
                            $imagePath = null;
                            foreach (['png', 'jpg', 'jpeg', 'gif'] as $ext) {
                                $path = public_path("template/client/dist/img/phong/{$phong->MaPhong}.{$ext}");
                                if (file_exists($path)) {
                                    $imagePath = asset("template/client/dist/img/phong/{$phong->MaPhong}.{$ext}");
                                    break;
                                }
                            }
                        @endphp

                        <div class="mb-3">
                            @if($imagePath)
                                <img src="{{ $imagePath }}"
                                    alt="Hình ảnh phòng hiện tại" 
                                    id="current-preview"
                                    class="img-thumbnail"
                                    style="max-height: 200px; display: block;">
                            @else
                                <img id="current-preview" 
                                    src="#" 
                                    alt="Hình ảnh phòng hiện tại" 
                                    class="img-thumbnail"
                                    style="max-height: 200px; display: none;">
                            @endif
                        </div>

                        <label for="HinhAnh">Hình ảnh mới</label>
                        <img id="new-preview" src="#" alt="Hình ảnh xem trước" class="img-thumbnail mb-2" style="max-height: 200px; display: none;">
                        <input type="file" name="HinhAnh" class="form-control" id="HinhAnh" accept="image/*" onchange="previewImage(this);">
                    </div>
                </div>
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
    <script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            const preview = document.getElementById('new-preview');
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
@endsection
