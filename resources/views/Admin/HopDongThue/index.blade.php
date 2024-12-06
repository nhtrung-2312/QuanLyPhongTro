@extends('Layout.admin')
@section('title', 'Danh sách hợp đồng thuê')
@section('content')
<div class="card">
    <div class="card-header">
        <div class="">
            <a href="{{ route('admin.hopdongthue.create') }}" class="btn btn-primary">Tạo hợp đồng mới</a>
        </div>
    </div>
    <div class="card-body">
        @if($hopdongthues->isEmpty())
            <p class="text-center">Không có hợp đồng thuê nào</p>
        @else
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center align-middle">
                        <th>STT</th>
                        <th>Tên cơ sở</th>
                        <th>Tên phòng</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Tiền cọc</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hopdongthues as $hopdongthue)
                    <tr class="text-center align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $hopdongthue->phong->coSo->TenCoSo }}</td>
                        <td>{{ $hopdongthue->phong->TenPhong }}</td>
                        <td>{{ date('d/m/Y', strtotime($hopdongthue->NgayBatDau)) }}</td>
                        <td>{{ date('d/m/Y', strtotime($hopdongthue->NgayKetThuc)) }}</td>
                        <td>
                            @if($hopdongthue->TrangThai === 'Chờ thanh toán cọc')
                                <span style="padding: 8px 12px" class="badge badge-lg badge-warning">Chờ thanh toán cọc</span>
                            @elseif($hopdongthue->TrangThai === 'Còn hiệu lực')
                                <span style="padding: 8px 12px" class="badge badge-lg badge-success">Còn hiệu lực</span>
                            @elseif($hopdongthue->TrangThai === 'Hết hiệu lực')
                                <span style="padding: 8px 12px" class="badge badge-lg badge-danger">Hết hiệu lực</span>
                            @elseif($hopdongthue->TrangThai === 'Đã huỷ')
                                <span style="padding: 8px 12px" class="badge badge-lg badge-secondary">Đã huỷ</span>
                            @endif
                        </td>
                        <td>{{ number_format($hopdongthue->TienCoc, 0, ',', '.') }} VNĐ</td>
                        <td>
                            <a class="btn btn-sm btn-info" onclick="editHopDongThue('{{ $hopdongthue->MaHopDong }}')">
                                <i class="fas fa-edit"></i>Cập nhật
                            </a>
                            <a class="btn btn-sm btn-danger" onclick="deleteHopDongThue('{{ $hopdongthue->MaHopDong }}')">
                                <i class="fas fa-trash"></i>Xoá
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $hopdongthues->links() }}
            </div>
        @endif
    </div>
</div>

@if(!$hopdongthues->isEmpty())
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Chỉnh sửa hợp đồng thuê</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="update_MaHopDong">
                    <div class="form-group">
                        <label for="NgayBatDau">Ngày bắt đầu</label>
                        <input type="date" class="form-control" id="NgayBatDau" name="NgayBatDau" disabled>
                    </div>
                    <div class="form-group">
                        <label for="NgayKetThuc">Ngày kết thúc</label>
                        <input type="date" class="form-control" id="NgayKetThuc" name="NgayKetThuc" disabled>
                    </div>
                    <div class="form-group">
                        <label for="TienCoc">Tiền cọc</label>
                        <input type="number" class="form-control" id="TienCoc" name="TienCoc" min="0" disabled>
                    </div>
                    <div class="form-group">
                        <label for="TrangThai">Trạng thái</label>
                        <select class="form-control" id="TrangThai" name="TrangThai">
                            <option value="Chờ thanh toán cọc">Chờ thanh toán cọc</option>
                            <option value="Còn hiệu lực">Còn hiệu lực</option>
                            <option value="Hết hiệu lực">Hết hiệu lực</option>
                            <option value="Đã huỷ">Đã huỷ</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Hủy
                </button>
                <button type="button" class="btn btn-primary" onclick="updateHopDongThue('{{ $hopdongthue->MaHopDong }}')">
                    <i class="fas fa-save"></i> Lưu
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    function editHopDongThue(hopdongthue) {
        $.ajax({
            url: `/admin/hopdongthue/edit/${hopdongthue}`,
            type: 'GET',
            success: function(response) {
                $('#NgayBatDau').val(response.data.NgayBatDau);
                $('#NgayKetThuc').val(response.data.NgayKetThuc);
                $('#TrangThai').val(response.data.TrangThai);
                $('#TienCoc').val(response.data.TienCoc);
                $('#updateModal').modal('show');
            },
            error: function(xhr) {
                toastr.error('Có lỗi xảy ra khi lấy thông tin!');
            }
        });
    }

    function updateHopDongThue(hopdongthue) {
        $.ajax({
            url: `/admin/hopdongthue/update/${hopdongthue}`,
            type: 'PUT',
            data: $('#updateModal form').serialize(),
            success: function(response) {
                toastr.success('Cập nhật hợp đồng thuê thành công!');
                setTimeout(function() {
                    window.location.reload();
                }, 500);
            },
            error: function(xhr) {
                const error = xhr.responseJSON;
                console.log(error);
            }
        })
    }
</script>
@endpush
