<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

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

        $roles = Role::all();

        return view('pages.user.form', compact('data', 'roles'));
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

            if (request()->role) {
                $role = Role::findOrFail(request()->role);

                // return $role;
                if ($data->roles_label) {
                    $data->roles_label->map(function ($res) use ($data) {
                        $data->removeRole($res);
                    });
                }
                $data->assignRole($role);
            }


            if ($id) {
                Alert::success('Berhasil', 'Data Pengguna Berhasil Diubah');
            } else {
                Alert::success('Berhasil', 'Data Pengguna Berhasil Ditambahkan');
            }

            return redirect()->route('user.index');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Alert::error('Gagal', $th->getMessage());
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
