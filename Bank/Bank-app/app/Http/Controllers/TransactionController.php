<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Routing\Controller;
use App\Models\Customer;
use App\Models\Account;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create(Account $account)
    {
        return view('transaction.create', compact('account'));
    }

    public function store(Request $request, Account $account)
    {
        $request->validate([
            'amount' => 'required',
        ]);

        $account->transactions()->create($request->all());

        if($request->type === 'deposit') {
            $account->balance += $request->amount;
        } else {
            $account->balance -= $request->amount;
        }
        $account->save();
        
        return redirect()->route('account.index')->with('success', 'Transaction created successfully.');
    }
}
