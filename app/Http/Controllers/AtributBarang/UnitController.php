<?php

namespace App\Http\Controllers\AtributBarang;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Unit;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class UnitController extends Controller
{
    public function index()
    {
        $datas = Unit::all();
        return view('pages.atributBarang.unit.index', compact('datas'));
    }

    public function form($id = null)
    {
        $data = [];

        if ($id) {
            $data = Unit::findOrFail($id);
        }

        return view('pages.atributBarang.unit.form', compact('data'));
    }

    public function store($id = null)
    {
        if ($id) {
            $data = Unit::findOrFail($id);
        } else {
            $data = new Unit;
        }
        try {
            $data->name = request()->name;
            $data->save();

            if ($id) {
                Alert::success('Berhasil', 'Data Satuan Berhasil Diubah');
            } else {
                Alert::success('Berhasil', 'Data Satuan Berhasil Ditambahkan');
            }

            return redirect()->route('satuan.index');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Alert::error('Gagal', $th);
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $data = Unit::findOrFail($id);
        $data->delete();
        Alert::success('Berhasil', 'Data Satuan Berhasil Dihapus');
        return redirect()->back();
    }
}
