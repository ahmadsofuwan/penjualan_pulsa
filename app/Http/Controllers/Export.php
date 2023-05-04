<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class Export extends Controller
{
    public function index(Request $request)
    {
        $transactions = DB::table('transactions')
            ->where('customer_id', $request->customer_id)
            ->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"])
            ->get();

        if (count($transactions) == 0) {
            Alert::error('Maaf', 'tidak ada transaksi di tanggal itu');
            return back();
        }
        $data = [
            'transactions' => $transactions
        ];

        $pdf = PDF::loadview('export', $data);
        return $pdf->stream('laporan');
    }
}
