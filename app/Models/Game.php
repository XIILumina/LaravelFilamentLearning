<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    
       protected $fillable = [
        'title',
        'description',
        'featured',
        'release_date',
        'publisher',
        'rating',
        'image_url',
        'developer_id',
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
