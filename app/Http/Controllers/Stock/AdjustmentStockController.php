<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Stock\AdjustmentDetailStock;
use App\Models\Stock\AdjustmentStock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class AdjustmentStockController extends Controller
{
    public function index()
    {
        $startDate = request()->startDate;
        $endDate = request()->endDate;

        $datas = [];
        if ($startDate) {
            $from = Carbon::createFromFormat('Y-m-d', $startDate);
            $to = Carbon::createFromFormat('Y-m-d', $endDate);

            $datas = AdjustmentStock::whereBetween('date', [$from, $to])->get();
        } else {
            $datas = AdjustmentStock::whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()])->get();
        }

        return view('pages.stock.adjustmentStock.index', compact('datas'));
    }

    public function add()
    {
        $datas = Barang::where('is_visible', true)->get();
        $carts = AdjustmentDetailStock::where('user_id', Auth::id())->whereNull('adjustment_stock_id')->get();
        return view('pages.stock.adjustmentStock.add', compact(['datas', 'carts']));
    }

    public function cart()
    {
        $data = new AdjustmentDetailStock();
        $data->barang_id = request()->barang_id;
        $data->stock_existing = request()->stock_existing;
        $data->stock_actual = request()->stock_actual;
        $data->remark = request()->remark;
        $data->user_id = Auth::id();
        $data->save();

        Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
        return redirect()->back();
    }

    public function updateCart($id)
    {
        $data = AdjustmentDetailStock::findOrFail($id);
        $data->stock_actual = request()->stock_actual;
        $data->remark = request()->remark;
        $data->save();

        Alert::success('Berhasil', 'Data Berhasil Diubah');
        return redirect()->back();
    }

    public function deleteCart($id)
    {
        $data = AdjustmentDetailStock::findOrFail($id);
        $data->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus');
        return redirect()->back();
    }

    public function store()
    {
        $carts = AdjustmentDetailStock::where('user_id', Auth::id())->whereNull('adjustment_stock_id')->get();

        DB::beginTransaction();
        try {
            if ($carts->count() > 0) {
                $totalRFC = sprintf("%03d", AdjustmentStock::whereYear('created_at', Carbon::now())->count() + 1);
                $month = Carbon::now()->format('m');
                $year = Carbon::now()->format('Y');
                $billNo = $totalRFC . '/' . 'StockIn' . '/' . $month . '/' . $year;

                $data = new AdjustmentStock();
                $data->bill_no = $billNo;
                $data->user_id = Auth::id();
                $data->remark = request()->remark;
                $data->date = Carbon::now();
                $data->save();


                $letData = [];
                foreach ($carts as $value) {
                    $detail = AdjustmentDetailStock::findOrFail($value->id);
                    $detail->adjustment_stock_id = $data->id;
                    $detail->date = Carbon::now();
                    $detail->save();

                    $updateStock = Barang::findOrFail($value->barang_id);
                    $updateStock->stock = $value->stock_actual;
                    $updateStock->save();

                    array_push($letData, $value, $updateStock);
                }
                Alert::success('Berhasil', 'Data Penyesuaian Stok Berhasil DItambahkan');
                DB::commit();
                return redirect()->route('penyesuaian.stok.index');
            } else {
                Alert::error('Gagal', 'Data Penyesuaian Stok Tidak Boleh Kosong');
                DB::rollback();
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            DB::rollback();
            Alert::error('Gagal', $th->getMessage());
            return redirect()->back();
        }
    }

    public function detail($id)
    {
        $data = AdjustmentStock::findOrFail($id);
        return view('pages.stock.adjustmentStock.detail', compact('data'));
    }
}
