@extends('Layout.admin')
@section('title', 'Thêm loại phí')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm loại phí mới</h3>
        <div class="card-tools">
            <a href="{{ route('admin.loaiphi.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
    <div class="card-body">
        <form id="createForm" method="POST" action="{{ route('admin.loaiphi.store') }}">
            @csrf
            <div class="form-group">
                <label for="TenLoaiPhi">Tên loại phí <span class="text-danger">*</span></label>
                <input type="text"
                       id="TenLoaiPhi"
                       name="TenLoaiPhi"
                       class="form-control">
                <span class="text-danger" id="TenLoaiPhiError"></span>
            </div>

            <div class="form-group">
                <label for="DonGia">Đơn giá <span class="text-danger">*</span></label>
                <input type="number"
                       id="DonGia"
                       name="DonGia"
                       class="form-control"
                       min="0">
                <span class="text-danger" id="DonGiaError"></span>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Thêm mới
                </button>
                <a href="{{ route('admin.loaiphi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#createForm').submit(function(e) {
        e.preventDefault();

        // Reset error messages
        $('#TenLoaiPhiError').text('');
        $('#DonGiaError').text('');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Thêm loại phí thành công!');
                    setTimeout(() => {
                        window.location.href = "{{ route('admin.loaiphi.index') }}";
                    }, 500);
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if(errors.TenLoaiPhi) {
                    $('#TenLoaiPhiError').text(errors.TenLoaiPhi[0]);
                }
                if(errors.DonGia) {
                    $('#DonGiaError').text(errors.DonGia[0]);
                }
            }
        });
    });
});
</script>
@endpush
@endsection
