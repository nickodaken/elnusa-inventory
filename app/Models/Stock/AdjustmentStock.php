<?php

namespace App\Models\Stock;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdjustmentStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_no',
        'user_id',
        'remark',
    ];

    public function detail(): HasMany
    {
        return $this->hasMany(AdjustmentDetailStock::class, 'adjustment_stock_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
