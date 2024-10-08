<?php

namespace App\Models\Stock;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockOutDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'barang_id',
        'qty',
        'user_id',
        'do_number',
        'date',
        'remarks'
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(StockOut::class, 'stock_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
