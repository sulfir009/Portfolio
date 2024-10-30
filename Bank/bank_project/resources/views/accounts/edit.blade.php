@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Edit Account</h1>

    <form action="{{ route('accounts.update', $account->id) }}" method="POST" class="mb-5">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="account_number" class="form-label">Account Number</label>
            <input type="text" name="account_number" class="form-control" id="account_number" value="{{ $account->account_number }}" required>
        </div>
        <div class="mb-3">
            <label for="balance" class="form-label">Balance</label>
            <input type="number" step="0.01" name="balance" class="form-control" id="balance" value="{{ $account->balance }}" required>
        </div>
        <div class="mb-3">
            <label for="client_id" class="form-label">Client</label>
            <select name="client_id" class="form-control" id="client_id" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $client->id == $account->client_id ? 'selected' : '' }}>{{ $client->full_name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
