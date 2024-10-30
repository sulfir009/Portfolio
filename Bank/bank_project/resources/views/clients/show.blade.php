@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Client Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $client->full_name }}</h5>
            <p class="card-text"><strong>Address:</strong> {{ $client->address }}</p>
            <p class="card-text"><strong>Identification Number:</strong> {{ $client->identification_number }}</p>
            <p class="card-text"><strong>Phone Number:</strong> {{ $client->phone_number }}</p>
            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection
