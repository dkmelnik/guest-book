<?php

namespace App\Models\Posts;

use App\Casts\setDateAttribute;
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
        'created_at' => setDateAttribute::class,
    ];



}
