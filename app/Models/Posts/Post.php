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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

}
