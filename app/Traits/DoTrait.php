<?php

namespace App\Traits;

use App\Models\MasterData\Customer;
use App\Models\Stock\StockOut;
use Carbon\Carbon;
use Exception;

trait DoTrait
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $data = StockOut::with('customer')->whereYear('created_at', Carbon::now())->get();
                $customerData = Customer::find(request()->customer_id);

                $customerCode = $customerData->code;
                $totalDO = sprintf("%03d", $data->count() + 1);
                $month = Carbon::now()->format('m');

                $romawiMonth = '';
                switch ($month) {
                    case 1:
                        $romawiMonth = 'I';
                        break;
                    case 2:
                        $romawiMonth = 'II';
                        break;
                    case 3:
                        $romawiMonth = 'III';
                        break;
                    case 4:
                        $romawiMonth = 'IV';
                        break;
                    case 5:
                        $romawiMonth = 'V';
                        break;
                    case 6:
                        $romawiMonth = 'VI';
                        break;
                    case 7:
                        $romawiMonth = 'VII';
                        break;
                    case 8:
                        $romawiMonth = 'VII';
                        break;
                    case 9:
                        $romawiMonth = 'IX';
                        break;
                    case 10:
                        $romawiMonth = 'X';
                        break;
                    case 11:
                        $romawiMonth = 'XI';
                        break;
                    case 12:
                        $romawiMonth = 'XII';
                        break;
                }

                $year = Carbon::now()->format('Y');

                $doNo = $customerCode . '/' . $totalDO . '/' . $romawiMonth . '/' . $year;

                $model->do_number = $doNo;
            } catch (Exception $e) {
                abort(500, $e->getMessage());
                return $e;
            }
        });
    }
}
