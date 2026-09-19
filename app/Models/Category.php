<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use GhostCompiler\LaravelModelCaching\Concerns\HasModelCaching;

#[Fillable(['title', 'slug'])]
class Category extends Model
{
    use HasFactory, HasModelCaching;

    public function getTitleAttribute(?string $value): string
    {
        return strtoupper($value);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
