@extends('Layout.admin')
@section('title', 'Add Facility')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add New Facility</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.facilities.store') }}" method="POST">
        <form action="" method="POST">
            @csrf
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="TenCoSo" class="form-control" value="{{ old('TenCoSo') }}">
                @error('TenCoSo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="DiaChi" class="form-control" value="{{ old('DiaChi') }}">
                @error('DiaChi')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="SDT" class="form-control" value="{{ old('SDT') }}">
                @error('SDT')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection