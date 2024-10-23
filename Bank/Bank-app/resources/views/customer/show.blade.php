@extends('layout.app')

@section('content')
    <h1>Информация о клиенте: {{ $customer->name }}</h1>

    <p>Идентификационный номер: {{ $customer->identification_number }}</p>
    <p>Адрес: {{ $customer->address }}</p>
    <p>Телефон: {{ $customer->phone }}</p>

    <h2>Действия</h2>
    <a href="{{ route('accounts.index', $customer) }}" class="btn btn-primary">Просмотр счетов</a>

    <h2>Счета</h2>

    @if($customer->accounts->isEmpty())
        <p>У клиента нет открытых счетов.</p>
    @else
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Номер счета</th>
                    <th>Баланс</th>
                    <th>Транзакции</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customer->accounts as $account)
                    <tr>
                        <td>{{ $account->id }}</td>
                        <td>{{ $account->balance }} грн</td>
                        <td>
                            <ul>
                                @foreach ($account->transactions as $transaction)
                                    <li>
                                        {{ $transaction->type === 'deposit' ? 'Пополнение' : 'Снятие' }}: {{ $transaction->amount }} грн - {{ $transaction->created_at->format('d.m.Y') }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <a href="{{ route('transactions.create', $account->id) }}" class="btn btn-primary btn-sm">Добавить транзакцию</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('customers.index') }}" class="btn btn-secondary mt-3">Назад к списку клиентов</a>
@endsection
