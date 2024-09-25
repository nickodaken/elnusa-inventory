<?php

namespace App\Http\Controllers\AtributBarang;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Project;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class ProjectController extends Controller
{
    public function index()
    {
        $datas = Project::all();
        return view('pages.atributBarang.project.index', compact('datas'));
    }

    public function form($id = null)
    {
        $data = [];

        if ($id) {
            $data = Project::findOrFail($id);
        }

        return view('pages.atributBarang.project.form', compact('data'));
    }

    public function store($id = null)
    {
        if ($id) {
            $data = Project::findOrFail($id);
        } else {
            $data = new Project;
        }
        try {
            $data->name = request()->name;
            $data->save();

            if ($id) {
                Alert::success('Berhasil', 'Data Proyek Berhasil Diubah');
            } else {
                Alert::success('Berhasil', 'Data Proyek Berhasil Ditambahkan');
            }

            return redirect()->route('proyek.index');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Alert::error('Gagal', $th);
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $data = Project::findOrFail($id);
        $data->delete();
        Alert::success('Berhasil', 'Data Proyek Berhasil Dihapus');
        return redirect()->back();
    }
}
