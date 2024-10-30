@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Add New Account</h1>

    <form action="{{ route('accounts.store') }}" method="POST" class="mb-5">
        @csrf
        <div class="mb-3">
            <label for="account_number" class="form-label">Account Number</label>
            <input type="text" name="account_number" class="form-control" id="account_number" required>
        </div>
        <div class="mb-3">
            <label for="balance" class="form-label">Balance</label>
            <input type="number" step="0.01" name="balance" class="form-control" id="balance" required>
        </div>
        <div class="mb-3">
            <label for="client_id" class="form-label">Client</label>
            <select name="client_id" class="form-control" id="client_id" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->full_name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
