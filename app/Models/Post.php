<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'category_id', 'description', 'posted', 'image'];

    function category() {
        return $this->belongsTo(Category::class);
    }

    function tags()  {
        // return $this->belongsToMany(Tag::class);
        return $this->morphToMany(Tag::class,'taggable');
    }
}
