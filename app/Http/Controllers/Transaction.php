<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\Transaction as ModelsTransaction;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

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

        $point = $this->point($request->produc, $request->amount);


        ModelsTransaction::create($request->all());
        Customer::where('id', $request->customer_id)->increment('point', $point);

        Alert::toast('Berhasil Transaction', '', 'success');
        return back();
    }
    public function delete($id)
    {
        $id = Crypt::decrypt($id);

        $data = ModelsTransaction::where('id', $id)->first();
        $point = $this->point($data->produc, $data->amount);
        Customer::where('id', $data->customer_id)->decrement('point', $point);

        ModelsTransaction::where('id', $id)->delete();


        Alert::toast('Berhasil menghapus transaksi', '', 'success');
        return back();
    }


    public function point($produc, $amount)
    {
        $point = 0;
        //jika listrik 
        if ($produc == 'listrik') {
            $param1 = [
                'bagi' => 2000,
                'kali' => 1,
            ];
            $param2 = [
                'bagi' => 2000,
                'kali' => 2,
            ];

            if ($amount > 50000) {
                $point += (50000 / $param1['bagi']) * $param1['kali']; //50.001 - 100.000 => 50.000/2.000 = 25 *1 = 25  pasti hanya 25 tidak akan berubah walau berapa pun
            }

            if ($amount > 100000) {
                $point += ($amount - 100000) /  $param2['bagi'] *  $param2['kali'];
            }
        }

        //jika pulsa 
        if ($produc == 'pulsa') {
            $param1 = [
                'bagi' => 1000,
                'kali' => 1,
            ];
            $param2 = [
                'bagi' => 1000,
                'kali' => 2,
            ];

            if ($amount > 10000) {
                $point += (10000 / $param1['bagi']) * $param1['kali']; //50.001 - 100.000 => 50.000/2.000 = 25 *1 = 25  pasti hanya 25 tidak akan berubah walau berapa pun
            }

            if ($amount > 30000) {
                $point += ($amount - 30000) /  $param2['bagi'] *  $param2['kali'];
            }
        }
        return  $point;
    }
}
