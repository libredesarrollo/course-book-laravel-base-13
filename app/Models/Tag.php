<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title'])]
class Tag extends Model
{
    function posts()  {
        // return $this->belongsToMany(Post::class);
        return $this->morphedByMany(Post::class,'taggable');
    }
}
