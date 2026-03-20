<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug'])]
class Category extends Model
{
    // protected $fillable = ['title', 'slug'];

    function posts() {
        return $this->hasMany(Post::class);
    }
}
