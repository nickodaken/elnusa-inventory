<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Stock\AdjustmentDetailStock;
use App\Models\Stock\StockInDetail;
use App\Models\Stock\StockOutDetail;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $datas = Barang::all();
        return view('pages.stock.report.index', compact('datas'));
    }

    public function detail($id)
    {
        $data = Barang::findOrFail($id);

        $startDate = request()->startDate;
        $endDate = request()->endDate;
        $stockIns = [];
        $stockOuts = [];
        $adjustments = [];

        if ($startDate && $endDate) {
            $stockIns = StockInDetail::where('barang_id', $data->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'DESC')
                ->get();
            $stockOuts = StockOutDetail::where('barang_id', $data->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'DESC')
                ->get();
            $adjustments = AdjustmentDetailStock::where('barang_id', $data->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'DESC')
                ->get();
        } else {
            $stockIns = StockInDetail::where('barang_id', $data->id)
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])
                ->orderBy('created_at', 'DESC')
                ->get();
            $stockOuts = StockOutDetail::where('barang_id', $data->id)
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])
                ->orderBy('created_at', 'DESC')
                ->get();
            $adjustments = AdjustmentDetailStock::where('barang_id', $data->id)
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        return view('pages.stock.report.detail', compact(['data', 'stockIns', 'stockOuts', 'adjustments']));
    }
}
