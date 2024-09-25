<?php

namespace App\Http\Controllers\AtributBarang;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Brand;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class BrandController extends Controller
{
    public function index()
    {
        $datas = Brand::all();
        return view('pages.atributBarang.brand.index', compact('datas'));
    }

    public function form($id = null)
    {
        $data = [];

        if ($id) {
            $data = Brand::findOrFail($id);
        }

        return view('pages.atributBarang.brand.form', compact('data'));
    }

    public function store($id = null)
    {
        if ($id) {
            $data = Brand::findOrFail($id);
        } else {
            $data = new Brand;
        }
        try {
            $data->name = request()->name;
            $data->save();

            if ($id) {
                Alert::success('Berhasil', 'Data Merek Berhasil Diubah');
            } else {
                Alert::success('Berhasil', 'Data Merek Berhasil Ditambahkan');
            }

            return redirect()->route('merek.index');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Alert::error('Gagal', $th);
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $data = Brand::findOrFail($id);
        $data->delete();
        Alert::success('Berhasil', 'Data Merek Berhasil Dihapus');
        return redirect()->back();
    }
}
