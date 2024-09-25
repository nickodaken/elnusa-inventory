<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Supplier;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class SupplierController extends Controller
{
    public function index()
    {
        $datas = Supplier::all();
        return view('pages.masterData.supplier.index', compact('datas'));
    }

    public function form($id = null)
    {
        $data = [];

        if ($id) {
            $data = Supplier::findOrFail($id);
        }

        return view('pages.masterData.supplier.form', compact('data'));
    }

    public function store($id = null)
    {
        if ($id) {
            $data = Supplier::findOrFail($id);
        } else {
            $data = new Supplier;
        }
        try {
            $data->code = request()->code;
            $data->register_date = request()->register_date;
            $data->name = request()->name;
            $data->address = request()->address;
            $data->telp = request()->telp;
            $data->save();

            if ($id) {
                Alert::success('Berhasil', 'Data Supplier Berhasil Diubah');
            } else {
                Alert::success('Berhasil', 'Data Supplier Berhasil Ditambahkan');
            }

            return redirect()->route('supplier.index');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Alert::error('Gagal', $th);
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $data = Supplier::findOrFail($id);
        $data->delete();
        Alert::success('Berhasil', 'Data Supplier Berhasil Dihapus');
        return redirect()->back();
    }
}
