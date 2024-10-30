@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Add New Client</h1>

    <form action="{{ route('clients.store') }}" method="POST" class="mb-5">
        @csrf
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" id="full_name" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" required>
        </div>
        <div class="mb-3">
            <label for="identification_number" class="form-label">Identification Number</label>
            <input type="text" name="identification_number" class="form-control" id="identification_number" required>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" id="phone_number" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
