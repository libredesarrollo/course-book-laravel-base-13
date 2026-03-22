<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'avatar', 'address'])]
class Profile extends Model
{
    function user() {
        return $this->belongsTo(User::class);
    }
}
