@extends('Layout.admin')
@section('title', 'Facility List')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Facility List</h3>
        <div class="card-tools">
            {{-- <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary">Add New</a> --}}
            <a href="#" class="btn btn-primary">Add New</a>
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
                        <a href="#" class="btn btn-sm btn-info">Edit</a>
                        <button onclick="#" class="btn btn-sm btn-danger">Delete</button>
                        {{-- <a href="{{ route('admin.facilities.edit', $facility->id) }}" class="btn btn-sm btn-info">Edit</a> --}}
                        {{-- <button onclick="deleteFacility({{ $facility->id }})" class="btn btn-sm btn-danger">Delete</button> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $facilities->links() }}
    </div>
</div>

@push('scripts')
<script>
function deleteFacility(id) {
    if(confirm('Are you sure?')) {
        $.ajax({
            url: '/admin/facilities/' + id,
            type: 'DELETE',
            data: {_token: '{{ csrf_token() }}'},
            success: function(result) {
                location.reload();
            }
        });
    }
}
</script>
@endpush
@endsection