<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug'])]
class Category extends Model
{
    use HasFactory;
    // protected $fillable = ['title', 'slug'];

    function getTitleAttribute(?string $value) : string {
         return strtoupper($value);
        // return strtoupper($this->attributes['slug']);
        // return strtoupper($this->attributes['title']);
    }
    // function setTitleAttribute(?string $value) : void {
    //     $this->attributes['title'] = ucfirst($value);
    // }

    // protected function title(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => ucfirst($value),
    //         set: fn (string $value) => strtolower($value),
    //     );
    // }


    function posts() {
        return $this->hasMany(Post::class);
    }
}
