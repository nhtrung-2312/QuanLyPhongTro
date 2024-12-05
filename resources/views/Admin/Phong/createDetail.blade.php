@extends('Layout.admin')
@section('title', 'Thêm tiện nghi cho phòng')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm tiện nghi cho phòng: {{$phong->TenPhong}}</h3>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    
                        <li>{{ $error }}</li>
                    
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card-body">
        <form action="{{ route('admin.rooms.details.store') }}" method="POST">
            @csrf
            <input type="hidden" name="MaPhong" value="{{ $phong->MaPhong }}">

            <div class="form-group">
                <label for="MaTienNghi">Tiện nghi</label>
                <select name="MaTienNghi" id="MaTienNghi" class="form-control">
                    <option value="">Chọn tiện nghi</option>
                    @foreach($tienNghis as $tienNghi)
                        <option value="{{ $tienNghi->MaTienNghi }}">{{ $tienNghi->TenTienNghi }}</option>
                    @endforeach
                </select>
                @error('MaTienNghi')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="SoLuong">Số lượng</label>
                <input type="number" name="SoLuong" id="SoLuong" class="form-control" value="{{ old('SoLuong') }}">
                @error('SoLuong')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="TinhTrang">Tình trạng</label>
                <input type="text" name="TinhTrang" id="TinhTrang" class="form-control" value="{{ old('TinhTrang') }}">
                @error('TinhTrang')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="GhiChu">Ghi chú</label>
                <textarea name="GhiChu" id="GhiChu" class="form-control">{{ old('GhiChu') }}</textarea>
                @error('GhiChu')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <a href="{{ route('admin.rooms.details', $phong->MaPhong) }}" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>
@endsection