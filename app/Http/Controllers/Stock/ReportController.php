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

        if ($startDate) {
            $from = Carbon::createFromFormat('Y-m-d', $startDate);
            $to = Carbon::createFromFormat('Y-m-d', $endDate);

            $stockIns = StockInDetail::where('barang_id', $data->id)
                ->whereBetween('date', [$from, $to])
                ->get();
            $stockOuts = StockOutDetail::where('barang_id', $data->id)
                ->whereBetween('date', [$from, $to])
                ->get();
            $adjustments = AdjustmentDetailStock::where('barang_id', $data->id)
                ->whereBetween('date', [$from, $to])
                ->get();
        } else {
            $stockIns = StockInDetail::where('barang_id', $data->id)
                ->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()])
                ->get();
            $stockOuts = StockOutDetail::where('barang_id', $data->id)
                ->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()])
                ->get();
            $adjustments = AdjustmentDetailStock::where('barang_id', $data->id)
                ->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()])
                ->get();
        }

        return view('pages.stock.report.detail', compact(['data', 'stockIns', 'stockOuts', 'adjustments']));
    }

    public function stockIn()
    {
        $startDate = request()->startDate;
        $endDate = request()->endDate;

        $datas = [];
        if ($startDate) {
            $from = Carbon::createFromFormat('Y-m-d', $startDate);
            $to = Carbon::createFromFormat('Y-m-d', $endDate);

            $datas = StockInDetail::whereBetween('date', [$from, $to])->get();
        } else {
            $datas = StockInDetail::whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()])->get();
        }

        return view('pages.stock.report.stockIn', compact('datas'));
    }

    public function stockOut()
    {
        $startDate = request()->startDate;
        $endDate = request()->endDate;

        $datas = [];
        if ($startDate) {
            $from = Carbon::createFromFormat('Y-m-d', $startDate);
            $to = Carbon::createFromFormat('Y-m-d', $endDate);

            $datas = StockOutDetail::whereBetween('date', [$from, $to])->get();
        } else {
            $datas = StockOutDetail::whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()])->get();
        }

        return view('pages.stock.report.stockOut', compact('datas'));
    }

    public function adjustmentStock()
    {
        $startDate = request()->startDate;
        $endDate = request()->endDate;

        $datas = [];
        if ($startDate) {
            $from = Carbon::createFromFormat('Y-m-d', $startDate);
            $to = Carbon::createFromFormat('Y-m-d', $endDate);

            $datas = AdjustmentDetailStock::whereBetween('date', [$from, $to])->get();
        } else {
            $datas = AdjustmentDetailStock::whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()])->get();
        }

        return view('pages.stock.report.adjustment', compact('datas'));
    }
}
