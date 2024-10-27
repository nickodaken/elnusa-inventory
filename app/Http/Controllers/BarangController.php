<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\MasterData\Brand;
use App\Models\MasterData\Project;
use App\Models\MasterData\Unit;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
{
    public function index()
    {
        $datas = Barang::all();
        return view('pages.barang.index', compact('datas'));
    }

    public function form($id = null)
    {
        $data = [];

        if ($id) {
            $data = Barang::findOrFail($id);
        }

        $project = Project::all();
        $brand = Brand::all();
        $unit = Unit::all();
        return view('pages.barang.form', compact([
            'data',
            'project',
            'brand',
            'unit'
        ]));
    }

    public function store($id = null)
    {
        if ($id) {
            $data = Barang::findOrFail($id);
        } else {
            $data = new Barang;
        }
        try {
            $data->code = request()->code;
            $data->name = request()->name;
            $data->project_id = request()->project_id;
            $data->unit_id = request()->unit_id;
            $data->brand_id = request()->brand_id;
            $data->stock = request()->stock ?? $data->stock;
            $data->minimal_stock = request()->minimal_stock;
            $data->po_number = request()->po_number;
            $data->location = request()->location;
            $data->exp_date = request()->exp_date;
            $data->remark = request()->remark;
            $data->material_no = request()->material_no;
            $data->save();

            if ($id) {
                Alert::success('Berhasil', 'Data Barang Berhasil Diubah');
            } else {
                Alert::success('Berhasil', 'Data Barang Berhasil Ditambahkan');
            }

            return redirect()->route('barang.index');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Alert::error('Gagal', $th->getMessage());
            return redirect()->back();
        }
    }

    public function visible($id)
    {
        $data = Barang::findOrFail($id);

        $value = '';

        switch ($data->is_visible) {
            case true:
                $value = false;
                break;

            case false:
                $value = true;
                break;
        }

        $data->is_visible = $value;
        $data->save();

        Alert::success('Berhasil', 'Data Barang Berhasil Diubah');
        return redirect()->back();
    }
}
