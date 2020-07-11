<?php

namespace App\Models\Posts;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $fillable = [
        'user_id',
        'message'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
