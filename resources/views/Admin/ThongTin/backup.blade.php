@extends('Layout.admin')
@section('title', 'Sao lưu dữ liệu')
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="nav flex-column nav-pills">
                    <a class="nav-link" href="{{ route('admin.thongtin.index') }}">
                        <i class="fas fa-user mr-2"></i> Thông tin cá nhân
                    </a>
                    <a class="nav-link" href="{{ route('admin.thongtin.account') }}">
                        <i class="fas fa-key mr-2"></i> Chỉnh sửa tài khoản
                    </a>
                    <a class="nav-link active" href="{{ route('admin.thongtin.backup') }}">
                        <i class="fas fa-database mr-2"></i> Sao lưu dữ liệu
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sao lưu và phục hồi dữ liệu</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-text">Sao lưu dữ liệu</h5>
                                <form id="createBackupForm" action="{{ route('admin.thongtin.createBackup') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-download mr-2"></i>Tạo bản sao lưu
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-text">Phục hồi dữ liệu</h5>
                                <form id="restoreDatabaseForm" action="{{ route('admin.thongtin.restoreDatabase') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="custom-file mb-3">
                                        <input type="file" name="backup_file" class="custom-file-input" id="backupFile" accept=".sql">
                                        <label class="custom-file-label" for="backupFile">Chọn file</label>
                                    </div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-upload mr-2"></i>Phục hồi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
        $('#createBackupForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        window.location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('Có lỗi xảy ra khi tạo bản sao lưu');
                }
            });
        });

        $('#restoreDatabaseForm').on('submit', function(e) {
            e.preventDefault();
            if (!confirm('Bạn có chắc chắn muốn phục hồi dữ liệu? Hành động này không thể hoàn tác!')) {
                return;
            }

            var formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('Có lỗi xảy ra khi phục hồi dữ liệu');
                }
            });
        });
    });
</script>
@endpush
@endsection
