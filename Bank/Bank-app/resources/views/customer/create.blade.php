@extends('layout.app')

@section('content')
    <h1>Добавить клиента</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customers.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="name">ФИО:</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="identification_number">Идентификационный номер:</label>
            <input type="text" name="identification_number" class="form-control" required value="{{ old('identification_number') }}">
        </div>

        <div class="form-group">
            <label for="address">Адрес:</label>
            <input type="text" name="address" class="form-control" required value="{{ old('address') }}">
        </div>

        <div class="form-group">
            <label for="phone">Телефон:</label>
            <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}">
        </div>

        <button type="submit" class="btn btn-success">Сохранить</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Назад</a>
    </form>
@endsection
