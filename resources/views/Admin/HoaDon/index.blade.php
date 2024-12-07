@extends('Layout.admin')
@section('title', 'Danh sách hóa đơn')
@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <a href="{{ route('admin.hoadon.create') }}" class="btn btn-primary">Thêm mới</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center align-middle">
                        <th>STT</th>
                        <th>Tên cơ sở</th>
                        <th>Tên phòng</th>
                        <th>Ngày lập</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @if($hoadons->count() > 0)
                        @foreach($hoadons as $hoadon)
                        <tr class="text-center align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $hoadon->hopdongthue->phong->coSo->TenCoSo }}</td>
                            <td>{{ $hoadon->hopdongthue->phong->TenPhong }}</td>
                            <td>{{ date('d/m/Y', strtotime($hoadon->NgayLap)) }}</td>
                            <td>{{ number_format($hoadon->TongTien, 0, ',', '.') }} đ</td>
                            <td>
                                @if($hoadon->TrangThai == 'Chưa thanh toán')
                                    <span style="padding: 8px 12px;" class="badge badge-warning">{{ $hoadon->TrangThai }}</span>
                                @elseif($hoadon->TrangThai == 'Đã thanh toán')
                                    <span style="padding: 8px 12px;" class="badge badge-success">{{ $hoadon->TrangThai }}</span>
                                @else
                                    <span style="padding: 8px 12px;" class="badge badge-danger">{{ $hoadon->TrangThai }}</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick='editHoaDon("{{ $hoadon->MaHoaDon }}")'>
                                    <i class="fas fa-edit"></i> Cập nhật
                                </button>
                                <a class="btn btn-sm btn-success" href="{{ route('admin.hoadon.details', $hoadon->MaHoaDon) }}">
                                    <i class="fas fa-info-circle"></i> Chi tiết
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">Không có dữ liệu</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $hoadons->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Cập nhật hóa đơn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editHoaDonForm" action="{{ route('admin.hoadon.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="MaHoaDon" id="MaHoaDon">
                    <div class="form-group">
                        <label for="TrangThai">Trạng thái</label>
                        <select class="form-control" id="TrangThai" name="TrangThai">
                            <option value="Chưa thanh toán">Chưa thanh toán</option>
                            <option value="Đã thanh toán">Đã thanh toán</option>
                            <option value="Đã hủy">Đã hủy</option>
                        </select>
                        <span class="text-danger" id="TrangThaiError"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#editHoaDonForm').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success('Cập nhật hóa đơn thành công');
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                }, error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error('Cập nhật hóa đơn thất bại');
                }
            });
        });
    });
    function editHoaDon(MaHoaDon) {
        $('#editModal').modal('show');
        $('#MaHoaDon').val(MaHoaDon);
        $.ajax({
            url: `/admin/hoadon/edit/${MaHoaDon}`,
            type: 'GET',
            success: function(response) {
                $('#TrangThai').val(response.TrangThai);
            }
        });
    }
</script>
@endpush
