<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\MasterData\Customer;
use App\Models\Stock\StockOut;
use App\Models\Stock\StockOutDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class StockOutController extends Controller
{
    public function index()
    {
        $startDate = request()->startDate;
        $endDate = request()->endDate;

        $datas = [];
        if ($startDate) {
            $from = Carbon::createFromFormat('Y-m-d', $startDate);
            $to = Carbon::createFromFormat('Y-m-d', $endDate);

            $datas = StockOut::whereBetween('date', [$from, $to])->get();
        } else {
            $datas = StockOut::whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()])->get();
        }

        return view('pages.stock.stockOut.index', compact('datas'));
    }

    public function add()
    {
        $datas = Barang::where('is_visible', true)->where('stock', '>', 0)->get();

        $customers = Customer::all();
        $carts = StockOutDetail::where('user_id', Auth::id())->whereNull('stock_id')->get();
        return view('pages.stock.stockOut.add', compact(['datas', 'customers', 'carts']));
    }

    public function cart()
    {
        $barang = Barang::where('id', request()->barang_id)->first();

        if (request()->qty <= $barang->stock) {
            $data = new StockOutDetail();
            $data->barang_id = request()->barang_id;
            $data->qty = request()->qty;
            $data->remarks = request()->remarks;
            $data->user_id = Auth::id();
            $data->save();

            Alert::success('Berhasil', 'Barang Berhasil Ditambahkan');
        } else {
            Alert::error('Gagal', 'Stok Tidak Mencukupi');
        }

        return redirect()->back();
    }

    public function updateCart($id)
    {
        $data = StockOutDetail::findOrFail($id);
        $data->qty = request()->qty;
        $data->save();

        Alert::success('Berhasil', 'Data Berhasil Diubah');
        return redirect()->back();
    }

    public function deleteCart($id)
    {
        $data = StockOutDetail::findOrFail($id);
        $data->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus');
        return redirect()->back();
    }

    public function store()
    {
        $carts = StockOutDetail::where('user_id', Auth::id())->whereNull('stock_id')->get();

        DB::beginTransaction();
        try {
            if ($carts->count() > 0) {
                $total = sprintf("%03d", StockOut::whereYear('created_at', Carbon::now())->count() + 1);
                $month = Carbon::now()->format('m');
                $year = Carbon::now()->format('Y');
                $billNo = $total . '/' . 'StockOut' . '/' . $month . '/' . $year;

                $data = new StockOut();
                $data->bill_no = $billNo;
                $data->customer_id = request()->customer_id;
                $data->user_id = Auth::id();
                $data->date = Carbon::now();
                $data->attn = request()->attn;
                $data->via = request()->via;
                $data->carrier = request()->carrier;
                $data->reff = request()->reff;
                $data->truck_no = request()->truck_no;
                $data->delivered_by = request()->delivered_by;
                $data->from = request()->from;
                $data->save();


                $letData = [];
                foreach ($carts as $value) {
                    $detail = StockOutDetail::findOrFail($value->id);
                    $detail->stock_id = $data->id;
                    $detail->date = Carbon::now();
                    $detail->save();

                    $updateStock = Barang::findOrFail($value->barang_id);
                    $updateStock->stock -= $value->qty;
                    $updateStock->save();

                    array_push($letData, $value, $updateStock);
                }
                Alert::success('Berhasil', 'Data Stok Keluar Berhasil Ditambahkan');
                DB::commit();
                return redirect()->route('keluar.index');
            } else {
                Alert::error('Gagal', 'Data Barang Keluar Tidak Boleh Kosong');
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
        $data = StockOut::findOrFail($id);
        return view('pages.stock.stockOut.detail', compact('data'));
    }

    public function delete($id)
    {
        $data = StockOut::findOrFail($id);

        DB::beginTransaction();
        try {
            if (isset($data->detail)) {
                foreach ($data->detail as $value) {
                    $updateStock = Barang::findOrFail($value->barang_id);
                    $updateStock->stock += $value->qty;
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
            Alert::error('Gagal', $th->getMessage());
            return redirect()->back();
        }
    }

    public function getPDF($id)
    {
        $data = StockOut::findOrFail($id);

        return view('pdf.do', compact('data'));

        $pdf = PDF::loadView('pdf.do', compact('data'));

        return $pdf->download(str_replace("/", "-", $data->do_number) . '.pdf');
    }
}
