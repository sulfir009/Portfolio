@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Add New Transaction</h1>

    <form action="{{ route('transactions.store') }}" method="POST" class="mb-5">
        @csrf
        <div class="mb-3">
            <label for="transaction_date" class="form-label">Transaction Date</label>
            <input type="date" name="transaction_date" class="form-control" id="transaction_date" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" id="amount" required>
        </div>
        <div class="mb-3">
            <label for="operation_reason" class="form-label">Operation Reason</label>
            <input type="text" name="operation_reason" class="form-control" id="operation_reason" required>
        </div>
        <div class="mb-3">
            <label for="payment_type" class="form-label">Payment Type</label>
            <input type="text" name="payment_type" class="form-control" id="payment_type" required>
        </div>
        <div class="mb-3">
            <label for="account_id" class="form-label">Account</label>
            <select name="account_id" class="form-control" id="account_id" required>
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->account_number }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
