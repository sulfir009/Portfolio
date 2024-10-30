@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Add New Branch</h1>

    <form action="{{ route('branches.store') }}" method="POST" class="mb-5">
        @csrf
        <div class="mb-3">
            <label for="branch_name" class="form-label">Branch Name</label>
            <input type="text" name="branch_name" class="form-control" id="branch_name" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('branches.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
