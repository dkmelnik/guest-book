<?php


namespace App\Services\Post;


use App\Models\Posts\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (Auth::check())
        {
            $id = Auth::user()->id;
            $post = Post::create(array_merge(["user_id" => $id], $request->all()));
        }
        else{
            $post = Post::create($request->all());
        }


        if (!$post instanceof Post) {
            return false;
        }
        return true;
    }



}
