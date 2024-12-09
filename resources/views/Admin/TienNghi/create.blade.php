@extends('layout.admin')
@section('title', 'Thêm tiện nghi mới')
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.tiennghi.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card-body">
        <form id="formCreateTienNghi" action="{{ route('admin.tiennghi.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="TenTienNghi">Tên tiện nghi <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="TenTienNghi" name="TenTienNghi" required>
                <div id="errorTenTienNghi" class="text-danger"></div>
                @error('TenTienNghi')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="MoTa">Mô tả</label>
                <textarea class="form-control" id="MoTa" name="MoTa" rows="3"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        $('#formCreateTienNghi').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        window.location.href = "{{ route('admin.tiennghi.index') }}";
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    const errors = xhr.responseJSON.errors;
                    console.log(errors);
                    $('#errorTenTienNghi').text(errors.TenTienNghi);
                }
            });
        });
    });
</script>
@endpush
@endsection
