<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\With;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// #[Fillable(['title', 'slug', 'content', 'category_id', 'description', 'posted', 'image','user_id'])]
// #[With(['category'])]
class Post extends Model
{
    use HasFactory; 

    protected $fillable = ['title', 'slug', 'content', 'category_id', 'description', 'posted', 'image','user_id'];
    // protected $table = 'posts';
    protected $with = ['category'];

    function category() {
        return $this->belongsTo(Category::class);
    }

    function tags()  {
        // return $this->belongsToMany(Tag::class);
        return $this->morphToMany(Tag::class,'taggable');
    }
}
