<?php

namespace App\Models\Stock;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdjustmentDetailStock extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'adjustment_stock_id',
        'barang_id',
        'stock_existing',
        'stock_actual',
        'remark',
        'user_id'
    ];

    public function adjustment(): BelongsTo
    {
        return $this->belongsTo(AdjustmentStock::class, 'adjustment_stock_id');
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
