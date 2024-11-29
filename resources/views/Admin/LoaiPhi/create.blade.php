@extends('Layout.admin')
@section('title', 'Thêm loại phí')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm loại phí mới</h3>
        <div class="card-tools">
            <a href="{{ route('admin.loaiphi.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.loaiphi.store') }}">
            @csrf
            <div class="form-group">
                <label for="TenLoaiPhi">Tên loại phí <span class="text-danger">*</span></label>
                <input type="text" 
                       name="TenLoaiPhi" 
                       class="form-control @error('TenLoaiPhi') is-invalid @enderror" 
                       value="{{ old('TenLoaiPhi') }}"
                       required>
                @error('TenLoaiPhi')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="DonGia">Đơn giá <span class="text-danger">*</span></label>
                <input type="number" 
                       name="DonGia" 
                       class="form-control @error('DonGia') is-invalid @enderror" 
                       value="{{ old('DonGia') }}"
                       min="0"
                       required>
                @error('DonGia')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Thêm mới
                </button>
                <a href="{{ route('admin.loaiphi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
