@extends('Layout.admin')
@section('title', 'Danh sách khách hàng')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách khách hàng</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr class="text-center align-left">
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                </tr>
            </thead>
            <tbody>
                @foreach($khachhangs as $khachhang)
                <tr class="text-center align-left">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $khachhang->HoTen }}</td>
                    <td>{{ $khachhang->SDT }}</td>
                    <td>{{ $khachhang->DiaChi }}</td>
                    <td>{{ $khachhang->NgaySinh }}</td>
                    <td>{{ $khachhang->GioiTinh }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <span class="p-5">
        </div>
        <div class="d-flex justify-content-center">
            {{ $khachhangs->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
