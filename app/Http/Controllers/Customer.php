<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alert;
use App\Models\Customer as ModelsCustomer;
use Illuminate\Support\Facades\Crypt;

class Customer extends Controller
{
    public function index()
    {
        $data = [
            'customers' => DB::table('customers')->get(),
        ];
        return view('customer', $data);
    }

    public function add(Request $request)
    {
        if (empty($request->name)) {
            Alert::error('Maaf', 'Nama Wajib di isi');

            return back();
        } else {
            $chek = DB::table('customers')->where('name', $request->name)->first();
            if (!empty($chek)) {
                Alert::error('Maaf', 'Nama telah di gunakan');

                return back();
            }
        }

        ModelsCustomer::create([
            'name' => $request->name
        ]);
        Alert::toast('Berhasil Menambah customer', 'Berhasil Menambah customer', 'success');
        return back();
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);

        DB::table('customers')->where('id', $id)->delete();
        Alert::toast('Berhasil menghapus customer', 'Berhasil menghapus customer', 'success');
        return back();
    }

    public function edit(Request $request)
    {
        ModelsCustomer::where('id',  Crypt::decrypt($request->id))
            ->update(['name' => $request->name]);
        Alert::toast('Berhasil merubah customer', '', 'success');
        return back();
    }
}
