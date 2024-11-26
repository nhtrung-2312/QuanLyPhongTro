@extends('Layout.admin')
@section('title', 'Facility List')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Facility List</h3>
        <div class="card-tools">
            <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>PhoneNumber</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($facilities as $facility)
                <tr>
                    <td>{{ $facility->MaCoSo }}</td>
                    <td>{{ $facility->TenCoSo }}</td>
                    <td>{{ $facility->DiaChi }}</td>
                    <td>{{ $facility->SDT}}</td>
                    <td>
                        <a href="{{ route('admin.facilities.edit', $facility->MaCoSo) }}" class="btn btn-sm btn-info">Edit</a>
                        <button onclick="deleteFacility('{{ $facility->MaCoSo }}', '{{$facility->TenCoSo}}')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>  </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $facilities->links() }}
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa cơ sở <span id="deleteFacilityName" class="font-weight-bold"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Xóa</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
let deleteId = null;

function deleteFacility(id, name) {
    console.log(id, name);
    deleteId = id;
    $('#deleteFacilityName').text(name);
    $('#deleteModal').modal('show');
}

function confirmDelete() {
    if (!deleteId) return;

    $.ajax({
        url: `/admin/facilities/delete/${deleteId}`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'DELETE'
        },
        success: function(response) {
            $('#deleteModal').modal('hide');
            if (response.success) {
                toastr.success('Delete Success!');
                setTimeout(function() {
                    window.location.reload();
                }, 1500);
            } else {
                toastr.error('Delete Error!');
            }
        },
        error: function(xhr) {
            $('#deleteModal').modal('hide');
            toastr.error('Delete Error!');
        }
    });
}

toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000"
};
</script>
@endpush
