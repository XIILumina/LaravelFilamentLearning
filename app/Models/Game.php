<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
    /**
     * Cast attributes to native types / date instances.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'release_date' => 'date',
        'featured' => 'boolean',
        'rating' => 'decimal:1',
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
    
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    
    public function wishlistedByUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }
    
    public function isWishlistedBy($user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }
        
        if (!$user) {
            return false;
        }
        
        return $this->wishlistedByUsers()->where('user_id', $user->id)->exists();
    }
}
