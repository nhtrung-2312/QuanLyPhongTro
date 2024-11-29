@extends('Layout.admin')
@section('title', 'Danh sách hóa đơn')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách hóa đơn</h3>
        <div class="card-tools">
            <a href="" class="btn btn-primary">Thêm mới</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr class="text-center align-middle">
                    <th>STT</th>
                    <th>Tên cơ sở</th>
                    <th>Tên phòng</th>
                    <th>Ngày lập</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hoadons as $hoadon)
                <tr class="text-center align-middle">
                    
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $hoadon->hopdongthue->phong->coSo->TenCoSo }}</td> 
                    <td>{{ $hoadon->hopdongthue->phong->TenPhong }}</td>
                    <td>{{ $hoadon->NgayLap }}</td>
                    <td>{{ $hoadon->TongTien }}</td>
                    <td>{{ $hoadon->TrangThai }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" onclick="updateHoaDon({{ json_encode($hoadon) }})">Chỉnh sửa</a>
                        <a class="btn btn-sm btn-success" href="{{ route('admin.hoadon.details', ['MaHoaDon' => $hoadon->MaHoaDon]) }}">Chi tiết hóa đơn</a>
                       
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $hoadons->links() }}
    </div>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Chỉnh sửa hóa đơn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateHoaDonForm" action="{{ route('admin.hoadon.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="MaHoaDon" id="MaHoaDon">
                    <div class="form-group">
                        <label for="TrangThai">Trạng thái</label>
                        <select class="form-control" id="TrangThai" name="TrangThai">
                            <option value="Đang xử lý">Đang xử lý</option>
                            <option value="Đã thanh toán">Đã thanh toán</option>
                        </select>
                        <span class="text-danger" id="TrangThaiError"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Chỉnh sửa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function updateHoaDon(maHoaDon) {
        // Set mã hóa đơn vào input hidden
        $('#MaHoaDon').val(maHoaDon);
        
        // Lấy trạng thái hiện tại của hóa đơn này (nếu cần)
        $.ajax({
            url: '/admin/hoadon/' + maHoaDon + '/get-status',
            method: 'GET',
            success: function(response) {
                $('#TrangThai').val(response.TrangThai);
                $('#updateModal').modal('show');
            },
            error: function(xhr) {
                toastr.error('Có lỗi xảy ra!');
            }
        });
    }

    $(document).ready(function() {
        $('#updateHoaDonForm').on('submit', function(e) {
            e.preventDefault();
            $('.text-danger').text('');

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.TrangThai) {
                            $('#TrangThaiError').text(errors.TrangThai);
                        }
                    }
                }
            });
        });
    });
</script>
@endpush