<?php


namespace App\Services\Post;


use App\Models\Posts\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PostService
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;

    }

    public function handlerPost(Request $request)
    {

        //Валидируем запрос
        $request->validate([
            'message' => 'required|max:255'
        ]);

        $Post = Post::create($request->all());

        if (!$Post instanceof Post) {
            return false;
        }
        return true;
    }



}
