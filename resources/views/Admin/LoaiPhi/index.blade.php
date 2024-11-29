@extends('Layout.admin')
@section('title', 'Danh sách loại phí')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách loại phí</h3>
        <div class="card-tools">
            <a href="" class="btn btn-primary">Thêm mới</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr class="text-center align-middle">
                    <th>STT</th>
                    <th>Tên loại phí</th>
                    <th>Đơn giá</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loaiphis as $loaiphi)
                <tr class="text-center align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $loaiphi->TenLoaiPhi }}</td> 
                    <td>{{ $loaiphi->DonGia }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" onclick="updateLoaiPhi({{ json_encode($loaiphi) }})">Chỉnh sửa</a>
                        <a class="btn btn-sm btn-danger" onclick="deleteLoaiPhi({{ $loaiphi->MaLoaiPhi }})">Xóa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $loaiphis->links() }}
    </div>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Chỉnh sửa loại phí</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Tên loại phí</label>
                        <input type="text" class="form-control" id="name" name="name" value="" placeholder="Nhập tên loại phí">
                    </div>
                    <div class="form-group">
                        <label for="donGia">Đơn giá</label>
                        <input type="text" class="form-control" id="donGia" name="donGia" placeholder="Nhập đơn giá">
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
    function updateLoaiPhi(loaiphi) {
        console.log('LoaiPhi data:', loaiphi);
        $('#name').val(loaiphi.TenLoaiPhi);
        $('#donGia').val(loaiphi.DonGia);

        window.updateId = loaiphi.MaLoaiPhi;
        $('#updateModal').modal('show');
    }
</script>
@endpush