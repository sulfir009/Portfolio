@extends('layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Клиенты</h1>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">Добавить клиента</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($customers->isEmpty())
        <p class="mt-3">Клиенты не найдены.</p>
    @else
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Идентификационный номер</th>
                    <th>Телефон</th>
                    <th>Адрес</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->identification_number }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>
                            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info btn-sm">Просмотр</a>
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('customers.destroyAll') }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mt-3" onclick="return confirm('Вы уверены, что хотите удалить всех клиентов?')">Удалить всех клиентов</button>
        </form>
    @endif
@endsection
