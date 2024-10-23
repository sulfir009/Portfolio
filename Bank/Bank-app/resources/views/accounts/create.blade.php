@extends('layout.app')
@section('content')
    <h1>Добавить счет для клиента {{ $customer->name }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('accounts.store', $customer) }}" method="POST" class="mt-4">
        @csrf

        <div class="form-group">
            <label for="balance">Начальный баланс:</label>
            <input type="number" name="balance" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Добавить счет</button>
        <a href="{{ route('accounts.index', $customer->id) }}" class="btn btn-secondary">Назад</a>
    </form>
@endsection