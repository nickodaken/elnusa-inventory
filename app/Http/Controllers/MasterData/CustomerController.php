<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Customer;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    public function index()
    {
        $datas = Customer::all();
        return view('pages.masterData.customer.index', compact('datas'));
    }

    public function form($id = null)
    {
        $data = [];

        if ($id) {
            $data = Customer::findOrFail($id);
        }

        return view('pages.masterData.customer.form', compact('data'));
    }

    public function store($id = null)
    {
        if ($id) {
            $data = Customer::findOrFail($id);
        } else {
            $data = new Customer;
        }
        try {
            $data->code = request()->code;
            $data->name = request()->name;
            $data->address = request()->address;
            $data->telp = request()->telp;
            $data->save();

            if ($id) {
                Alert::success('Berhasil', 'Data Pelanggan Berhasil Diubah');
            } else {
                Alert::success('Berhasil', 'Data Pelanggan Berhasil Ditambahkan');
            }

            return redirect()->route('pelanggan.index');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Alert::error('Gagal', $th);
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $data = Customer::findOrFail($id);
        $data->delete();
        Alert::success('Berhasil', 'Data Pelanggan Berhasil Dihapus');
        return redirect()->back();
    }
}
