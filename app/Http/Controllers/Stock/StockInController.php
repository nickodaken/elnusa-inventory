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
            $datas = StockIn::whereBetween('created_at', [$startDate, $endDate])->get();
        } else {
            $datas = StockIn::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])->get();
        }

        return view('pages.stock.stockIn.index', compact('datas'));
    }

    public function add()
    {
        $datas = Barang::where('stock', '>', 0)->get();
        $suppliers = Supplier::all();
        $carts = StockInDetail::where('user_id', Auth::id())->whereNull('stock_id')->get();
        return view('pages.stock.stockIn.add', compact(['datas', 'suppliers', 'carts']));
    }

    public function cart()
    {
        $data = new StockInDetail();
        $data->barang_id = request()->barang_id;
        $data->qty = request()->qty;
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
                // Available alpha caracters
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

                // generate a pin based on 2 * 7 digits + a random character
                $pin = mt_rand(1000000, 9999999)
                    . mt_rand(1000000, 9999999)
                    . $characters[rand(0, strlen($characters) - 1)];

                $data = new StockIn();
                $data->bill_no = str_shuffle($pin);
                $data->supplier_id = request()->supplier_id;
                $data->user_id = Auth::id();
                $data->save();


                $letData = [];
                foreach ($carts as $value) {
                    $detail = StockInDetail::findOrFail($value->id);
                    $detail->stock_id = $data->id;
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
