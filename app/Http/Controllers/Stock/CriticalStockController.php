<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class CriticalStockController extends Controller
{
    public function index()
    {
        $datas = Barang::whereColumn('stock', '<=', 'minimal_stock')->where('is_visible', true)->get();
        return view('pages.stock.criticalStock.index', compact('datas'));
    }
}
