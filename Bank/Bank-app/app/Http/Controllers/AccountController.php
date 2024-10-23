<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Customer $customer)
{
    // Получаем все счета клиента
    $accounts = $customer->accounts;

    // Возвращаем представление со списком счетов
    return view('accounts.index', compact('customer', 'accounts'));
}


    public function create(Customer $customer)
    {
        return view('accounts.create', compact('customer'));
    }

    public function store(Request $request, Customer $customer)
    {
        $request->validate([
            'balance' => 'required',
        ]);

        $customer->accounts()->create($request->all());
        return redirect()->route('accounts.index', $customer)->with('success', 'Account created successfully.');
    }
}
