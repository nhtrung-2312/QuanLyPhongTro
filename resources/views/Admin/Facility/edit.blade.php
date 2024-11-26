@extends('Layout.admin')
@section('title', 'Chỉnh sửa cơ sở')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Chỉnh sửa thông tin cơ sở</h3>
        <div class="card-tools">
            <a href="{{ route('admin.facilities.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.facilities.update', $facility->MaCoSo) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>ID</label>
                        <input type="text" class="form-control" value="{{ $facility->MaCoSo }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="TenCoSo" class="form-control" 
                            value="{{ old('TenCoSo', $facility->TenCoSo) }}">
                        @error('TenCoSo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="SDT" class="form-control" 
                            value="{{ old('SDT', $facility->SDT) }}">
                        @error('SDT')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Address <span class="text-danger">*</span></label>
                        <textarea name="DiaChi" class="form-control" rows="3">{{ old('DiaChi', $facility->DiaChi) }}</textarea>
                        @error('DiaChi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                    <a href="{{ route('admin.facilities.index') }}" class="btn btn-default">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
<style>
    .form-group label {
        font-weight: 600;
    }
    .text-danger {
        font-weight: 400;
    }
    textarea {
        resize: none;
    }
</style>
@endpush