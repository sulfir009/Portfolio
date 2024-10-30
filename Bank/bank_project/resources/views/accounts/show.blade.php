@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Account Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Account Number: {{ $account->account_number }}</h5>
            <p class="card-text"><strong>Balance:</strong> ${{ number_format($account->balance, 2) }}</p>
            <p class="card-text"><strong>Client:</strong> {{ $account->client->full_name }}</p>
            <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection
