{{-- resources/views/Admin/ChiTietPhong/editDetail.blade.php --}}
@extends('Layout.admin')
@section('title', 'Chỉnh sửa tiện nghi phòng')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Chỉnh sửa thông tin tiện nghi phòng</h3>
        <div class="card-tools">
            <a href="{{ route('admin.rooms.details', $chiTietPhong->MaPhong) }}" class="btn btn-default">
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

        <form action="{{ route('admin.rooms.details.update', ['id' => $chiTietPhong->MaPhong, 'maTienNghi' => $chiTietPhong->MaTienNghi]) }}" method="POST">
            @csrf
            @method('PUT')

            <p>{{$chiTietPhong->MaTienNghi}}</p>
            <input type="hidden" name="MaPhong" value="{{ $chiTietPhong->MaPhong }}">
            <input type="hidden" name="MaTienNghi" value="{{ $chiTietPhong->MaTienNghi }}">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="SoLuong">Số lượng <span class="text-danger">*</span></label>
                        <input type="number" name="SoLuong" class="form-control" 
                            value="{{ old('SoLuong', $chiTietPhong->SoLuong) }}" required>
                        @error('SoLuong')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="TinhTrang">Tình trạng <span class="text-danger">*</span></label>
                        <input type="text" name="TinhTrang" class="form-control"
                            value="{{ old('TinhTrang', $chiTietPhong->TinhTrang) }}" required>
                        @error('TinhTrang')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="GhiChu">Ghi chú</label>
                        <textarea name="GhiChu" class="form-control" rows="3">{{ old('GhiChu', $chiTietPhong->GhiChu) }}</textarea>
                        @error('GhiChu')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>
@endsection