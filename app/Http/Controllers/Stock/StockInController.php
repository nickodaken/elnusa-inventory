<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\MasterData\Supplier;
use App\Models\Stock\StockIn;
use App\Models\Stock\StockInDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class StockInController extends Controller
{
    public function index()
    {
        $startDate = request()->startDate;
        $endDate = request()->endDate;

        $datas = [];
        if ($startDate) {
            $from = Carbon::createFromFormat('Y-m-d', $startDate);
            $to = Carbon::createFromFormat('Y-m-d', $endDate);

            $datas = StockIn::whereBetween('date', [$from, $to])->get();
        } else {
            $datas = StockIn::whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()])->get();
        }

        return view('pages.stock.stockIn.index', compact('datas'));
    }

    public function add()
    {
        $datas = Barang::all();
        $suppliers = Supplier::all();
        $carts = StockInDetail::where('user_id', Auth::id())->whereNull('stock_id')->get();
        return view('pages.stock.stockIn.add', compact(['datas', 'suppliers', 'carts']));
    }

    public function cart()
    {
        $data = new StockInDetail();
        $data->barang_id = request()->barang_id;
        $data->qty = request()->qty;
        $data->po_number = request()->po_number;
        $data->remarks = request()->remarks;
        $data->user_id = Auth::id();
        $data->save();

        Alert::success('Berhasil', 'Barang Berhasil Ditambahkan');
        return redirect()->back();
    }

    public function updateCart($id)
    {
        $data = StockInDetail::findOrFail($id);
        $data->qty = request()->qty;
        $data->save();

        Alert::success('Berhasil', 'Data Berhasil Diubah');
        return redirect()->back();
    }

    public function deleteCart($id)
    {
        $data = StockInDetail::findOrFail($id);
        $data->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus');
        return redirect()->back();
    }

    public function store()
    {
        $carts = StockInDetail::where('user_id', Auth::id())->whereNull('stock_id')->get();

        DB::beginTransaction();
        try {
            if ($carts->count() > 0) {
                $total = sprintf("%03d", StockIn::whereYear('created_at', Carbon::now())->count() + 1);
                $month = Carbon::now()->format('m');
                $year = Carbon::now()->format('Y');
                $billNo = $total . '/' . 'StockIn' . '/' . $month . '/' . $year;

                $data = new StockIn();
                $data->bill_no = $billNo;
                $data->supplier_id = request()->supplier_id;
                $data->user_id = Auth::id();
                $data->date = Carbon::now();
                $data->save();


                $letData = [];
                foreach ($carts as $value) {
                    $detail = StockInDetail::findOrFail($value->id);
                    $detail->stock_id = $data->id;
                    $detail->date = Carbon::now();
                    $detail->save();

                    $updateStock = Barang::findOrFail($value->barang_id);
                    $updateStock->stock += $value->qty;
                    $updateStock->save();

                    array_push($letData, $value, $updateStock);
                }
                Alert::success('Berhasil', 'Data Stok Masuk Berhasil Ditambahkan');
                DB::commit();
                return redirect()->route('masuk.index');
            } else {
                Alert::error('Gagal', 'Data Barang Masuk Tidak Boleh Kosong');
                DB::rollback();
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            DB::rollback();
            Alert::error('Gagal', $th);
            return redirect()->back();
        }
    }

    public function detail($id)
    {
        $data = StockIn::findOrFail($id);
        return view('pages.stock.stockIn.detail', compact('data'));
    }

    public function delete($id)
    {
        $data = StockIn::findOrFail($id);

        DB::beginTransaction();
        try {
            if (isset($data->detail)) {
                foreach ($data->detail as $value) {
                    $updateStock = Barang::findOrFail($value->barang_id);
                    $updateStock->stock -= $value->qty;
                    $updateStock->save();
                }
                $data->detail()->delete();
            }
            $data->delete();

            Alert::success('Berhasil', 'Data Berhasil dihapus');
            DB::commit();
            return redirect()->back();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            DB::rollback();
            Alert::error('Gagal', $th);
            return redirect()->back();
        }
    }
}
