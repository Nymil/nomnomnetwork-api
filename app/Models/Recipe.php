<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $casts = [
        'ingredients' => 'array',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'creator_id',
        'likes'
    ];

    // a like is another model with the properties user_id and recipe_id
    public function likes()
    {
        return $this->hasMany(Like::class, 'recipe_id', 'id');
    }
}
