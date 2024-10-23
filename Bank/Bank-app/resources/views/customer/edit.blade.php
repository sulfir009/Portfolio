@extends('layout.app')

@section('content')
    <h1>Редактирование клиента</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">ФИО:</label>
            <input type="text" name="name" class="form-control" required value="{{ $customer->name }}">
        </div>

        <div class="form-group">
            <label for="identification_number">Идентификационный номер:</label>
            <input type="text" name="identification_number" class="form-control" required value="{{ $customer->identification_number }}">
        </div>

        <div class="form-group">
            <label for="address">Адрес:</label>
            <input type="text" name="address" class="form-control" required value="{{ $customer->address }}">
        </div>

        <div class="form-group">
            <label for="phone">Телефон:</label>
            <input type="text" name="phone" class="form-control" required value="{{ $customer->phone }}">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@endSection