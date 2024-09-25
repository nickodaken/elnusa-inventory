<?php

namespace App\Models;

use App\Models\MasterData\Brand;
use App\Models\MasterData\Project;
use App\Models\MasterData\Unit;
use App\Models\Stock\AdjustmentDetailStock;
use App\Models\Stock\StockInDetail;
use App\Models\Stock\StockOutDetail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'code',
        'name',
        'project_id',
        'unit_id',
        'brand_id',
        'stock',
        'minimal_stock',
        'po_number',
        'location',
        'exp_date',
        'remark'
    ];

    protected $appends = ['stockin_label', 'stockout_label'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function adjustment(): HasMany
    {
        return $this->hasMany(AdjustmentDetailStock::class, 'barang_id', 'id');
    }

    public function stockin(): HasMany
    {
        return $this->hasMany(StockInDetail::class, 'barang_id', 'id');
    }

    public function stockout(): HasMany
    {
        return $this->hasMany(StockOutDetail::class, 'barang_id', 'id');
    }

    public function getstockinLabelAttribute()
    {
        $data = 0;

        foreach ($this->stockin as $value) {
            $data += $value->qty;
        }

        return $data;
    }

    public function getstockoutLabelAttribute()
    {
        $data = 0;

        foreach ($this->stockout as $value) {
            $data += $value->qty;
        }

        return $data;
    }
}
