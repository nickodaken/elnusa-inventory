<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class JsonController extends Controller
{
    public function getJson($id)
    {
        return Barang::where('id', $id)->get();
    }
}
