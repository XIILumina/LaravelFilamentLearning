<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
       protected $fillable = [
        'title',
        'description',
        'release_date',
        'publisher',
        'rating',
        'image_url',
    ];
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
        public function platforms()
    {
        return $this->belongsToMany(Platform::class);
    }
    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }
}
