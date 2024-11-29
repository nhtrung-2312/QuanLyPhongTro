@extends('Layout.admin')                    
@section('title', 'Thêm phòng trọ')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm phòng trọ mới</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.rooms.store') }}">
            @csrf <!-- CSRF token for security -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="TenPhong">Tên phòng</label>
                        <input type="text" name="TenPhong" class="form-control" value="{{ old('TenPhong') }}" id="TenPhong" required>
                        @error('TenPhong')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
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
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="MaLoaiPhong">Loại phòng</label>
                        <select name="MaLoaiPhong" class="form-control" id="MaLoaiPhong" required>
                            <option value="">Chọn loại phòng</option>
                            @foreach($loaiphongs as $loaiphong)
                                <option value="{{ $loaiphong->MaLoaiPhong }}">{{ $loaiphong->LoaiPhong }}</option>
                            @endforeach 
                        </select>
                        @error('MaLoaiPhong')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="GiaThue">Giá thuê (VNĐ)</label>
                        <input type="number" name="GiaThue" class="form-control" value="{{ old('GiaThue') }}" id="GiaThue" required>
                        @error('GiaThue')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="TrangThai">Trạng thái</label>
                        <select name="TrangThai" class="form-control" id="TrangThai" disabled>
                            <option value="Đang thuê">Đang thuê</option>
                            <option value="Đang xử lý">Đang xử lý</option>
                            <option value="Phòng trống" selected>Phòng trống</option>
                        </select>
                        <input type="hidden" name="TrangThai" value="Phòng trống">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="MoTa">Mô tả</label>
                        <textarea name="MoTa" class="form-control" value="{{ old('MoTa') }}" id="MoTa" rows="3"></textarea>
                        @error('MoTa')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Thêm phòng</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection