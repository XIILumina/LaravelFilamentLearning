<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'input_type',
        'field_type',
        'is_filterable',
        'is_searchable',
        'is_required',
        'description',
        'options',
        'sort_order',
    ];

    protected $casts = [
        'options' => 'array',
        'is_filterable' => 'boolean',
        'is_searchable' => 'boolean',
        'is_required' => 'boolean',
    ];

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function gameAttributes(): HasMany
    {
        return $this->hasMany(GameAttribute::class);
    }
}
