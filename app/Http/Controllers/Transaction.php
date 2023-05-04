<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Alert;

class Transaction extends Controller
{
    public function index()
    {
        $transactions = DB::table('transactions')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->select('transactions.*', 'customers.name')
            ->get();

        $data = [
            'transactions' =>  $transactions,
            'customers' =>  DB::table('customers')->get(),
        ];
        return view('transaction', $data);
    }
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|string|max:255',
            'produc' => 'required|string|max:255',
            'amount' => 'required',
            'debitcredit' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Maaf', 'Harap isi semua data');
            return back();
        }
        


        Alert::toast('Berhasil Menambah customer', 'Berhasil Menambah customer', 'success');
        return back();
    }
}
