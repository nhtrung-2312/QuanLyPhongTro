@extends('Layout.admin')
@section('title', 'Thêm quyền mới')
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.phanquyen.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card-body">
        <form id="form-create" action="{{ route('admin.phanquyen.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="TenQuyen">Tên quyền</label>
                <input type="text" class="form-control" id="TenQuyen" name="TenQuyen" required>
            </div>
            <div class="form-group">
                <label for="MoTa">Mô tả</label>
                <textarea class="form-control" id="MoTa" name="MoTa" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm quyền</button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        $('#form-create').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        window.location.href = "{{ route('admin.phanquyen.index') }}";
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        })
    })
</script>
@endpush
@endsection
