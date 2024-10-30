@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Accounts</h1>
        <a href="{{ route('accounts.create') }}" class="btn btn-primary">Add New Account</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Account Number</th>
                <th scope="col">Balance</th>
                <th scope="col">Client</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
                <tr>
                    <th scope="row">{{ $account->id }}</th>
                    <td>{{ $account->account_number }}</td>
                    <td>${{ number_format($account->balance, 2) }}</td>
                    <td>{{ $account->client->full_name }}</td>
                    <td>
                        <a href="{{ route('accounts.show', $account->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
