<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameProductSku extends Model
{
    protected $table = 'game_product_skus';

    protected $fillable = [
        'game_id',
        'sku',
        'barcode',
        'price',
        'cost_price',
        'stock_quantity',
        'status',
        'variant_data',
        'is_default',
    ];

    protected $casts = [
        'variant_data' => 'array',
        'is_default' => 'boolean',
        'price' => 'float',
        'cost_price' => 'float',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock_quantity > 10) {
            return 'In Stock';
        } elseif ($this->stock_quantity > 0) {
            return 'Low Stock';
        }
        return 'Out of Stock';
    }

    public function getProfitMarginAttribute(): ?float
    {
        if (!$this->cost_price || !$this->price) {
            return null;
        }
        
        return (($this->price - $this->cost_price) / $this->price) * 100;
    }
}
