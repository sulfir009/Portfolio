<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Account;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'identification_number' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        Customer::create($request->all());
        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
{
    $customer->load('accounts.transactions');
    return view('customer.show', compact('customer'));
}

public function destroyAll()
{
    // Удаляем всех клиентов
    Customer::truncate(); // Это удалит все записи в таблице customers

    return redirect()->route('customers.index')->with('success', 'Все клиенты были удалены.');
}

    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $customer->update($request->all());
        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully.');
    }
}
