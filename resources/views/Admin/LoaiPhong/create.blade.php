@extends('Layout.admin')
@section('title', 'Thêm mới loại phòng')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm mới loại phòng</h3>
        <div class="card-tools">
            <a href="{{ route('admin.room-types.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.room-types.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Loại phòng <span class="text-danger">*</span></label>
                        <input type="text" name="LoaiPhong" class="form-control" 
                            value="{{ old('LoaiPhong') }}" placeholder="Nhập loại phòng">
                        @error('LoaiPhong')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Diện tích (m²) <span class="text-danger">*</span></label>
                        <input type="number" name="DienTich" class="form-control" 
                            value="{{ old('DienTich') }}" placeholder="Nhập diện tích">
                        @error('DienTich')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Số người <span class="text-danger">*</span></label>
                        <input type="number" name="SoNguoi" class="form-control" 
                            value="{{ old('SoNguoi') }}" placeholder="Nhập số người">
                        @error('SoNguoi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Thêm mới
                    </button>
                    <a href="{{ route('admin.room-types.index') }}" class="btn btn-default">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
