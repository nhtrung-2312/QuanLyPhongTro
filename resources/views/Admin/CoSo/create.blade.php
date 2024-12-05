@extends('Layout.admin')
@section('title', 'Thêm mới cơ sở')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm mới cơ sở</h3>
        <div class="card-tools">
            <a href="{{ route('admin.coso.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.coso.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tên cơ sở <span class="text-danger">*</span></label>
                        <input type="text" name="TenCoSo" class="form-control" 
                            value="{{ old('TenCoSo') }}" placeholder="Nhập tên cơ sở">
                        @error('TenCoSo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Địa chỉ <span class="text-danger">*</span></label>
                        <textarea name="DiaChi" class="form-control" rows="3" 
                            placeholder="Nhập địa chỉ">{{ old('DiaChi') }}</textarea>
                        @error('DiaChi')
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
                    <a href="{{ route('admin.coso.index') }}" class="btn btn-default">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
