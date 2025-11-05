<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
           protected $fillable = [
        'name',
        'website',
    ];
    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
