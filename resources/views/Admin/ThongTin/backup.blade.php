@extends('Layout.admin')
@section('title', 'Sao lưu dữ liệu')
@section('content')
@php
    $permissions = \App\Models\PhanQuyen::where('MaTaiKhoan', session('admin_id'))
        ->where('MaCoSo', session('selected_facility'))
        ->pluck('MaQuyen')
        ->toArray();
@endphp
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="nav flex-column nav-pills">
                    <a class="nav-link" href="{{ route('admin.thongtin.index') }}">
                        <i class="fas fa-user mr-2"></i> Thông tin cá nhân
                    </a>
                    <a class="nav-link" href="{{ route('admin.thongtin.account') }}">
                        <i class="fas fa-key mr-2"></i> Chỉnh sửa tài khoản
                    </a>
                    @if(in_array("Q010", $permissions))
                        <a class="nav-link active" href="{{ route('admin.thongtin.backup') }}">
                            <i class="fas fa-database mr-2"></i> Sao lưu dữ liệu
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sao lưu và phục hồi dữ liệu</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-text">Sao lưu dữ liệu</h5>
                                <button class="btn btn-primary">
                                    <i class="fas fa-download mr-2"></i>Tạo bản sao lưu
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-text">Phục hồi dữ liệu</h5>
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="backupFile">
                                    <label class="custom-file-label" for="backupFile">Chọn file</label>
                                </div>
                                <button class="btn btn-success">
                                    <i class="fas fa-upload mr-2"></i>Phục hồi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
