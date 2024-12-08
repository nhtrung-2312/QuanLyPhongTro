@extends('Layout.admin')
@section('title', 'Chi tiết quyền tài khoản')
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.phanquyen.capquyen') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay về
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Thông tin tài khoản</h5>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Tên đăng nhập:</th>
                        <td>{{ $taiKhoan->TenDangNhap }}</td>
                    </tr>
                    <tr>
                        <th>Vai trò:</th>
                        <td>{{ $taiKhoan->VaiTro }}</td>
                    </tr>
                    <tr>
                        <td>Nhân viên</td>
                        <td>{{ $taiKhoan->NhanVien->HoTen ?? 'Không có tên' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <h5>Phân quyền</h5>
            <form id="phanQuyenForm" method="POST" action="{{ route('admin.phanquyen.updateQuyen') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="MaTaiKhoan" value="{{ $taiKhoan->MaTaiKhoan }}">
                <input type="hidden" name="MaCoSo" value="{{ session('selected_facility') }}">

                <div class="row">
                    @foreach($quyens as $quyen)
                    <div class="col-md-6">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox"
                                name="quyens[]"
                                value="{{ $quyen->MaQuyen }}"
                                id="quyen_{{ $quyen->MaQuyen }}"
                                {{ $taiKhoan->phanQuyen->where('MaCoSo', session('selected_facility'))->contains('MaQuyen', $quyen->MaQuyen) ? 'checked' : '' }}>
                            <label class="form-check-label" for="quyen_{{ $quyen->MaQuyen }}">
                                {{ $quyen->TenQuyen }} - {{ $quyen->MoTa }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#phanQuyenForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(function() {
                        window.location.href = "{{ route('admin.phanquyen.capquyen') }}";
                    }, 1500);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON;
                if(errors) {
                    toastr.error(errors.message || 'Có lỗi xảy ra, vui lòng thử lại sau!');
                } else {
                    toastr.error('Có lỗi xảy ra, vui lòng thử lại sau!');
                }
            }
        });
    });
});
</script>
@endpush
@endsection
