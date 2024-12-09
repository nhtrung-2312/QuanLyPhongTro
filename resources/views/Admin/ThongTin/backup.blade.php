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
                                    <button type="button" class="btn btn-primary" onclick="createBackup()">
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
                                        <input type="file" name="backup_file" class="custom-file-input" id="backupFile" accept=".sql" onchange="updateFileName(this)">
                                        <label class="custom-file-label" for="backupFile">Chọn file backup (.sql)</label>
                                    </div>
                                    <button type="button" class="btn btn-success" onclick="restoreDatabase()">
                                        <i class="fas fa-upload mr-2"></i> Phục hồi dữ liệu
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
function updateFileName(input) {
    const fileName = input.files[0].name;
    input.nextElementSibling.innerText = fileName;
}

function createBackup() {
    fetch('{{ route('admin.thongtin.createBackup') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (response.headers.get('content-type') === 'application/json') {
            return response.json().then(data => {
                throw new Error(data.message);
            });
        }
        return response.blob();
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'backup.sql';
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error(error.message || 'Có lỗi xảy ra khi tạo backup');
    });
}

function restoreDatabase() {
    if (!document.getElementById('backupFile').files[0]) {
        toastr.warning('Vui lòng chọn file backup');
        return;
    }

    if (!confirm('Bạn có chắc chắn muốn phục hồi dữ liệu? Hành động này không thể hoàn tác!')) {
        return;
    }

    const formData = new FormData(document.getElementById('restoreDatabaseForm'));

    toastr.info('Đang phục hồi dữ liệu... Vui lòng đợi trong giây lát');

    fetch('{{ route('admin.thongtin.restoreDatabase') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastr.success(data.message);
            document.getElementById('restoreDatabaseForm').reset();
            document.querySelector('.custom-file-label').innerText = 'Chọn file backup (.sql)';
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        toastr.error(error.message || 'Có lỗi xảy ra khi phục hồi dữ liệu');
    });
}
</script>
@endpush
@endsection
