<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $datas = User::all();
        return view('pages.user.index', compact('datas'));
    }

    public function form($id = null)
    {
        $data = [];

        if ($id) {
            $data = User::findOrFail($id);
        }

        return view('pages.user.form', compact('data'));
    }

    public function store($id = null)
    {
        if ($id) {
            $data = User::findOrFail($id);
        } else {
            $data = new User;
        }

        try {
            $data->name = request()->name;
            $data->email = request()->email;
            $data->username = request()->username;
            if (request()->password) {
                $data->password = Hash::make(request()->password);
            }
            $data->save();

            if ($id) {
                Alert::success('Berhasil', 'Data Pengguna Berhasil Diubah');
            } else {
                Alert::success('Berhasil', 'Data Pengguna Berhasil Ditambahkan');
            }

            return redirect()->route('user.index');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Alert::error('Gagal', $th);
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        Alert::success('Berhasil', 'Data Pengguna Berhasil Dihapus');
        return redirect()->back();
    }
}
