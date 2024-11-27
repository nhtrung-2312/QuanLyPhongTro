@extends('Layout.admin')
@section('title', 'Danh sách khách hàng')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách khách hàng</h3>
        <div class="card-tools">
            <a href="" class="btn btn-primary">Thêm mới</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr class="text-center align-middle">
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr class="text-center align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $customer->HoTen }}</td> 
                    <td>{{ $customer->SDT }}</td>
                    <td>{{ $customer->DiaChi }}</td>
                    <td>{{ $customer->NgaySinh }}</td>
                    <td>{{ $customer->GioiTinh }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" onclick="updateCustomer({{ json_encode($customer) }})">Chỉnh sửa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $customers->links() }}
    </div>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Chỉnh sửa khách hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Họ tên</label>
                        <input type="text" class="form-control" id="name" name="name" value="" placeholder="Nhập họ tên">
                    </div>
                    <div class="form-group">
                        <label for="cccd">CCCD</label>
                        <input type="text" class="form-control" id="cccd" name="cccd" placeholder="Nhập CCCD">
                    </div>
                    <div class="form-group">
                        <label for="birthday">Ngày sinh</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Nhập ngày sinh">
                    </div>
                    <div class="form-group">
                        <label for="gender">Giới tính</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="1">Nam</option>
                            <option value="0">Nữ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" onclick="confirmUpdate()">Chỉnh sửa</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function updateCustomer(customer) {
        console.log('Customer data:', customer);
        $('#name').val(customer.HoTen);
        $('#cccd').val(customer.CCCD);
        $('#birthday').val(customer.NgaySinh);
        $('#gender').val(customer.GioiTinh === 'Nam' ? '1' : '0');
        $('#phone').val(customer.SDT);
        $('#address').val(customer.DiaChi);

        window.updateId = customer.MaKhachThue;
        $('#updateModal').modal('show');
    }
</script>
@endpush